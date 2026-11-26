<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PimpinanController extends Controller
{
    /**
     * Menampilkan pengaduan yang menunggu review pimpinan.
     */
    public function index()
    {
        abort_unless((int) auth()->user()->id_role === 4, 403);

        $pengaduans = Pengaduan::with([
            'mahasiswa.pengguna',
            'hasilPenanganan',
        ])
            ->where('status', 'Menunggu Review Pimpinan')
            ->orderBy('tanggal_pengajuan')
            ->get();

        return view('pimpinan.dashboard', compact('pengaduans'));
    }

    /**
     * Menampilkan detail pengaduan dan hasil penanganannya.
     */
    public function show($id)
    {
        abort_unless((int) auth()->user()->id_role === 4, 403);

        $pengaduan = Pengaduan::with([
            'mahasiswa.pengguna',
            'hasilPenanganan.timHukum',
        ])
            ->where('status', 'Menunggu Review Pimpinan')
            ->findOrFail($id);

        $hasilPenanganan = $pengaduan->hasilPenanganan
            ->sortByDesc('id_hasil')
            ->first();

        return view('pimpinan.detail', compact(
            'pengaduan',
            'hasilPenanganan'
        ));
    }

    /**
     * Menyimpan keputusan pimpinan dan memperbarui status pengaduan.
     */
    public function lihatBukti($id, $buktiId)
    {
        abort_unless((int) auth()->user()->id_role === 4, 403);

        $pengaduan = Pengaduan::where('status', 'Menunggu Review Pimpinan')
            ->findOrFail($id);
        $bukti = $pengaduan->buktiPengaduan()->findOrFail($buktiId);
        $disk = \Illuminate\Support\Facades\Storage::disk('local');
        abort_unless($disk->exists($bukti->lokasi_file), 404);

        return response()->file($disk->path($bukti->lokasi_file));
    }

    public function putuskan(Request $request, $id)
    {
        abort_unless((int) auth()->user()->id_role === 4, 403);

        $validated = $request->validate([
            'status_keputusan' => ['required', 'in:Setuju,Ditolak,Perlu Revisi'],
            'catatan_arahan' => ['required', 'string'],
        ]);

        DB::transaction(function () use ($id, $validated) {
            $pengaduan = Pengaduan::where('status', 'Menunggu Review Pimpinan')
                ->lockForUpdate()
                ->findOrFail($id);

            $statusSebelumnya = $pengaduan->status;

            $statusBaru = match ($validated['status_keputusan']) {
                'Setuju' => 'Selesai',
                'Ditolak' => 'Ditolak',
                'Perlu Revisi' => 'Revisi Tim Hukum',
            };

            $pengaduan->keputusanPengaduan()->create([
                'id_pimpinan' => auth()->id(),
                'status_keputusan' => $validated['status_keputusan'],
                'catatan_arahan' => $validated['catatan_arahan'] ?? null,
                'tanggal_keputusan' => now()->toDateString(),
            ]);

            $pengaduan->update([
                'status' => $statusBaru,
            ]);

            // Jika revisi, tugas dikembalikan ke Tim Hukum.
            // Jika keputusan final, penugasan ditandai selesai.
            $statusPenugasan = $validated['status_keputusan'] === 'Perlu Revisi'
                ? 'Perlu Revisi'
                : 'Selesai';

            $pengaduan->penugasanTimHukum()
                ->where('status_penugasan', 'Menunggu Review')
                ->update([
                    'status_penugasan' => $statusPenugasan,
                ]);

            // Beri tahu Tim Hukum yang ditugaskan tentang keputusan pimpinan.
            $timHukumIds = $pengaduan->penugasanTimHukum()
                ->where('status_penugasan', $statusPenugasan)
                ->pluck('id_tim_hukum')
                ->unique();

            foreach ($timHukumIds as $idTimHukum) {
                \App\Models\Notifikasi::create([
                    'id_pengguna' => $idTimHukum,
                    'id_pengaduan' => $pengaduan->id_pengaduan,
                    'isi_notifikasi' => 'Keputusan pimpinan untuk pengaduan '
                        . $pengaduan->nomor_pengaduan . ': '
                        . $validated['status_keputusan'] . '.',
                    'waktu_dibuat' => now(),
                    'status_notifikasi' => 'Belum Dibaca',
                ]);
            }

            // Keputusan akhir juga disampaikan kepada mahasiswa pemilik.
            if ($validated['status_keputusan'] !== 'Perlu Revisi') {
                $mahasiswa = $pengaduan->mahasiswa;

                if ($mahasiswa && $mahasiswa->id_pengguna) {
                    \App\Models\Notifikasi::create([
                        'id_pengguna' => $mahasiswa->id_pengguna,
                        'id_pengaduan' => $pengaduan->id_pengaduan,
                        'isi_notifikasi' => 'Status pengaduan '
                            . $pengaduan->nomor_pengaduan . ' telah berubah menjadi '
                            . $statusBaru . '.',
                        'waktu_dibuat' => now(),
                        'status_notifikasi' => 'Belum Dibaca',
                    ]);
                }
            }

            $pengaduan->riwayatPengaduan()->create([
                'aktivitas' => 'Keputusan diberikan oleh Pimpinan Fakultas',
                'status_sebelumnya' => $statusSebelumnya,
                'status_baru' => $statusBaru,
                'keterangan' => $validated['catatan_arahan'] ?? null,
                'waktu_perubahan' => now(),
            ]);
        });

        return redirect()
            ->route('pimpinan.dashboard')
            ->with('success', 'Keputusan berhasil disimpan.');
    }
}