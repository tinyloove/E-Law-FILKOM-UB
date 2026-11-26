<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Notifikasi;
use App\Models\Pengaduan;
use App\Models\Pengguna;
use App\Models\PenugasanTimHukum;

class AdminDashboardController extends Controller
{
    public function index()
    {
        abort_unless((int) Auth::user()->id_role === 2, 403);

        $pengaduans = Pengaduan::with([
            'mahasiswa.pengguna',
        ])
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        $totalPengaduan = $pengaduans->count();

        $pengaduanDiajukan = $pengaduans
            ->whereIn('status', ['Diajukan', 'Menunggu Pemeriksaan'])
            ->count();

        $menungguPerbaikan = $pengaduans
            ->where('status', 'Perlu Dilengkapi/Diperbaiki')
            ->count();

        $diteruskanBulanIni = DB::table('penugasan_tim_hukum')
            ->whereMonth('tanggal_penyerahan', now()->month)
            ->whereYear('tanggal_penyerahan', now()->year)
            ->count();

        return view('admin.dashboard', compact(
            'pengaduans',
            'totalPengaduan',
            'pengaduanDiajukan',
            'menungguPerbaikan',
            'diteruskanBulanIni'
        ));
    }

    public function show($id)
    {
        abort_unless((int) Auth::user()->id_role === 2, 403);

        $pengaduan = Pengaduan::with([
            'mahasiswa.pengguna',
            'buktiPengaduan',
            'riwayatPengaduan',
        ])->findOrFail($id);

        return view('admin.detail-pengaduan', compact('pengaduan'));
    }

    /** Menampilkan bukti kepada admin yang berwenang. */
    public function lihatBukti($pengaduanId, $buktiId)
    {
        abort_unless((int) Auth::user()->id_role === 2, 403);

        $pengaduan = Pengaduan::findOrFail($pengaduanId);
        $bukti = $pengaduan->buktiPengaduan()->findOrFail($buktiId);
        $disk = \Illuminate\Support\Facades\Storage::disk('local');

        abort_unless($disk->exists($bukti->lokasi_file), 404);

        return response()->file($disk->path($bukti->lokasi_file));
    }

    public function penugasan()
    {
        abort_unless((int) Auth::user()->id_role === 2, 403);

        $pengaduans = Pengaduan::with([
            'mahasiswa.pengguna',
            'penugasanTimHukum.timHukum',
        ])
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        $timHukums = Pengguna::where('id_role', 3)
            ->where('status_akun', 'Aktif')
            ->orderBy('nama')
            ->get();

        return view('admin.penugasan', compact(
            'pengaduans',
            'timHukums'
        ));
    }

    /**
     * Meneruskan pengaduan kepada Tim Hukum.
     */
    public function teruskan(Request $request, $id)
    {
        abort_unless((int) Auth::user()->id_role === 2, 403);

        $request->validate([
            'id_tim_hukum' => [
                'required',
                'exists:pengguna,id_pengguna',
            ],
        ]);

        $timHukum = Pengguna::where('id_pengguna', $request->id_tim_hukum)
            ->where('id_role', 3)
            ->where('status_akun', 'Aktif')
            ->firstOrFail();

        $hasil = DB::transaction(function () use ($id, $timHukum) {
            $pengaduan = Pengaduan::lockForUpdate()->findOrFail($id);

            if ($pengaduan->penugasanTimHukum()->exists()) {
                return 'sudah_ditugaskan';
            }

            if ($pengaduan->status !== 'Data Valid') {
                return 'belum_valid';
            }

            $statusSebelumnya = $pengaduan->status;

            PenugasanTimHukum::create([
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'id_tim_hukum' => $timHukum->id_pengguna,
                'kategori_akhir' => $pengaduan->kategori,
                'tanggal_penyerahan' => now()->toDateString(),
                'status_penugasan' => 'Ditugaskan',
            ]);

            $pengaduan->update([
                'status' => 'Diteruskan ke Tim Hukum',
            ]);

            $pengaduan->riwayatPengaduan()->create([
                'aktivitas' => 'Pengaduan diteruskan ke Tim Hukum',
                'status_sebelumnya' => $statusSebelumnya,
                'status_baru' => 'Diteruskan ke Tim Hukum',
                'keterangan' => 'Pengaduan diteruskan oleh Admin Layanan Hukum.',
                'waktu_perubahan' => now(),
            ]);

            Notifikasi::create([
                'id_pengguna' => $timHukum->id_pengguna,
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'isi_notifikasi' => 'Pengaduan ' . $pengaduan->nomor_pengaduan
                    . ' telah ditugaskan kepada Anda.',
                'waktu_dibuat' => now(),
                'status_notifikasi' => 'Belum Dibaca',
            ]);

            return 'berhasil';
        });

        if ($hasil === 'sudah_ditugaskan') {
            return back()->with(
                'error',
                'Pengaduan sudah pernah diteruskan ke Tim Hukum.'
            );
        }

        if ($hasil === 'belum_valid') {
            return back()->with(
                'error',
                'Periksa dan nyatakan data pengaduan valid sebelum meneruskannya.'
            );
        }

        return redirect()
            ->route('admin.penugasan')
            ->with('success', 'Pengaduan berhasil diteruskan kepada Tim Hukum.');
    }

    public function validasiPengaduan($id)
    {
        abort_unless((int) Auth::user()->id_role === 2, 403);

        DB::transaction(function () use ($id) {
            $pengaduan = Pengaduan::lockForUpdate()->findOrFail($id);

            abort_unless(
                in_array(
                    $pengaduan->status,
                    ['Diajukan', 'Menunggu Pemeriksaan'],
                    true
                ) && !$pengaduan->penugasanTimHukum()->exists(),
                403,
                'Pengaduan tidak dapat divalidasi pada status saat ini.'
            );

            $statusSebelumnya = $pengaduan->status;

            $pengaduan->update([
                'status' => 'Data Valid',
            ]);

            $pengaduan->riwayatPengaduan()->create([
                'aktivitas' => 'Pengaduan diperiksa oleh Admin Layanan Hukum',
                'status_sebelumnya' => $statusSebelumnya,
                'status_baru' => 'Data Valid',
                'keterangan' => 'Data pengaduan dinyatakan valid oleh admin.',
                'waktu_perubahan' => now(),
            ]);
        });

        return redirect()
            ->route('admin.pengaduan.detail', $id)
            ->with('success', 'Pengaduan berhasil dinyatakan valid.');
    }

    /**
     * Meminta mahasiswa memperbaiki pengaduan.
     */
    public function mintaPerbaikan(Request $request, $id)
    {
        abort_unless((int) Auth::user()->id_role === 2, 403);

        $validated = $request->validate([
            'catatan_perbaikan' => ['required', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($id, $validated) {
            $pengaduan = Pengaduan::lockForUpdate()->findOrFail($id);

            abort_unless(
                in_array(
                    $pengaduan->status,
                    ['Diajukan', 'Menunggu Pemeriksaan'],
                    true
                ) && !$pengaduan->penugasanTimHukum()->exists(),
                403,
                'Pengaduan tidak dapat diminta perbaikan pada status saat ini.'
            );

            $mahasiswa = $pengaduan->mahasiswa;

            abort_unless(
                $mahasiswa && $mahasiswa->id_pengguna,
                422,
                'Akun mahasiswa untuk pengaduan ini tidak ditemukan.'
            );

            $statusSebelumnya = $pengaduan->status;

            $pengaduan->update([
                'status' => 'Perlu Dilengkapi/Diperbaiki',
            ]);

            $pengaduan->riwayatPengaduan()->create([
                'aktivitas' => 'Admin meminta perbaikan pengaduan',
                'status_sebelumnya' => $statusSebelumnya,
                'status_baru' => 'Perlu Dilengkapi/Diperbaiki',
                'keterangan' => $validated['catatan_perbaikan'],
                'waktu_perubahan' => now(),
            ]);

            Notifikasi::create([
                'id_pengguna' => $mahasiswa->id_pengguna,
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'isi_notifikasi' => 'Pengaduan ' . $pengaduan->nomor_pengaduan
                    . ' perlu dilengkapi atau diperbaiki. Silakan buka detail pengaduan.',
                'waktu_dibuat' => now(),
                'status_notifikasi' => 'Belum Dibaca',
            ]);
        });

        return redirect()
            ->route('admin.pengaduan.detail', $id)
            ->with('success', 'Permintaan perbaikan berhasil disimpan.');
    }
}