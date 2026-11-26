<?php

namespace App\Http\Controllers;

use App\Models\PenugasanTimHukum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimHukumController extends Controller
{
    /**
     * Menampilkan daftar tugas milik Tim Hukum yang sedang login.
     */
    public function index()
    {
        abort_unless((int) auth()->user()->id_role === 3, 403);

        $idTimHukum = auth()->id();
        $hariIni = now()->startOfDay();

        $aktif = PenugasanTimHukum::with('pengaduan.mahasiswa.pengguna')
            ->where('id_tim_hukum', $idTimHukum)
            ->whereIn('status_penugasan', ['Ditugaskan', 'Perlu Revisi'])
            ->orderByRaw(
                "CASE WHEN status_penugasan = 'Perlu Revisi' THEN 0 ELSE 1 END"
            )
            ->orderBy('tanggal_penyerahan')
            ->get();

        $jumlahAktif = $aktif->count();

        // Tugas aktif yang sudah berjalan 5 hari atau lebih.
        $mendekatiTenggat = $aktif->filter(function ($tugas) use ($hariIni) {
            return $tugas->tanggal_penyerahan
                && Carbon::parse($tugas->tanggal_penyerahan)
                    ->startOfDay()
                    ->lte($hariIni->copy()->subDays(5));
        })->count();

        // Tugas baru yang diserahkan pada hari ini.
        $baruHariIni = $aktif->filter(function ($tugas) use ($hariIni) {
            return $tugas->status_penugasan === 'Ditugaskan'
                && $tugas->tanggal_penyerahan
                && Carbon::parse($tugas->tanggal_penyerahan)
                    ->isSameDay($hariIni);
        })->count();

        // Tugas selesai yang memiliki keputusan pada bulan berjalan.
        $selesaiBulanIni = PenugasanTimHukum::query()
            ->where('id_tim_hukum', $idTimHukum)
            ->where('status_penugasan', 'Selesai')
            ->whereHas('pengaduan.keputusanPengaduan', function ($query) {
                $query->whereBetween('tanggal_keputusan', [
                    now()->startOfMonth()->startOfDay(),
                    now()->endOfMonth()->endOfDay(),
                ]);
            })
            ->count();

        return view('tim-hukum.dashboard', compact(
            'aktif',
            'jumlahAktif',
            'mendekatiTenggat',
            'baruHariIni',
            'selesaiBulanIni'
        ));
    }

    /**
     * Menampilkan detail tugas milik Tim Hukum yang sedang login.
     */
    public function show($id)
    {
        abort_unless((int) auth()->user()->id_role === 3, 403);

        $tugas = PenugasanTimHukum::with('pengaduan.mahasiswa.pengguna')
            ->where('id_tim_hukum', auth()->id())
            ->findOrFail($id);

        $pengaduan = $tugas->pengaduan;

        abort_if(!$pengaduan, 404);

        // Ambil catatan revisi terbaru jika tugas perlu direvisi.
        $keputusanRevisi = null;

        if ($tugas->status_penugasan === 'Perlu Revisi') {
            $keputusanRevisi = $pengaduan->keputusanPengaduan()
                ->where('status_keputusan', 'Perlu Revisi')
                ->orderByDesc('id_keputusan')
                ->first();
        }

        return view('tim-hukum.detail-tugas', compact(
            'tugas',
            'pengaduan',
            'keputusanRevisi'
        ));
    }

    /**
     * Menyimpan hasil analisis dan rekomendasi penanganan.
     */
    public function lihatBukti($id, $buktiId)
    {
        abort_unless((int) auth()->user()->id_role === 3, 403);

        $tugas = PenugasanTimHukum::where('id_tim_hukum', auth()->id())
            ->findOrFail($id);
        $pengaduan = $tugas->pengaduan;
        abort_if(!$pengaduan, 404);
        $bukti = $pengaduan->buktiPengaduan()->findOrFail($buktiId);
        $disk = \Illuminate\Support\Facades\Storage::disk('local');
        abort_unless($disk->exists($bukti->lokasi_file), 404);

        return response()->file($disk->path($bukti->lokasi_file));
    }

    public function simpan(Request $request, $id)
    {
        abort_unless((int) auth()->user()->id_role === 3, 403);

        $validated = $request->validate([
            'hasil_analisis' => ['required', 'string'],
            'rekomendasi_penanganan' => ['required', 'string'],
        ]);

        DB::transaction(function () use ($id, $validated) {
            // Pastikan tugas milik pengguna yang sedang login.
            $tugas = PenugasanTimHukum::where('id_tim_hukum', auth()->id())
                ->lockForUpdate()
                ->findOrFail($id);

            // Hasil hanya dapat dikirim untuk tugas aktif.
            abort_unless(
                in_array(
                    $tugas->status_penugasan,
                    ['Ditugaskan', 'Perlu Revisi'],
                    true
                ),
                403
            );

            $pengaduan = $tugas->pengaduan;

            abort_if(!$pengaduan, 404);

            $pimpinans = \App\Models\Pengguna::where('id_role', 4)
                ->where('status_akun', 'Aktif')
                ->get();

            foreach ($pimpinans as $pimpinan) {
                \App\Models\Notifikasi::create([
                    'id_pengguna' => $pimpinan->id_pengguna,
                    'id_pengaduan' => $pengaduan->id_pengaduan,
                    'isi_notifikasi' => 'Hasil penanganan pengaduan ' . $pengaduan->nomor_pengaduan
                        . ' telah dikirim dan menunggu review Anda.',
                    'waktu_dibuat' => now(),
                    'status_notifikasi' => 'Belum Dibaca',
                ]);
            }

            $statusSebelumnya = $pengaduan->status;

            $pengaduan->hasilPenanganan()->create([
                'id_tim_hukum' => auth()->id(),
                'hasil_analisis' => $validated['hasil_analisis'],
                'rekomendasi_penanganan' => $validated['rekomendasi_penanganan'],
                'tanggal_penyusunan' => now()->toDateString(),
            ]);

            $pengaduan->update([
                'status' => 'Menunggu Review Pimpinan',
            ]);

            $tugas->update([
                'status_penugasan' => 'Menunggu Review',
            ]);

            $pengaduan->riwayatPengaduan()->create([
                'aktivitas' => 'Hasil penanganan dikirim oleh Tim Hukum',
                'status_sebelumnya' => $statusSebelumnya,
                'status_baru' => 'Menunggu Review Pimpinan',
                'keterangan' => 'Hasil analisis dan rekomendasi siap ditinjau pimpinan.',
                'waktu_perubahan' => now(),
            ]);
        });

        return redirect()
            ->route('tim-hukum.dashboard')
            ->with('success', 'Hasil penanganan berhasil dikirim.');
    }
}