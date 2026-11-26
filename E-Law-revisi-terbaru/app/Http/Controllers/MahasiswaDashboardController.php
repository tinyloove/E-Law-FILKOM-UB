<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MahasiswaDashboardController extends Controller
{
    /**
     * Menampilkan dashboard mahasiswa.
     */
    public function index()
    {
        $pengguna = Auth::user();

        // Pastikan pengguna adalah mahasiswa.
        abort_unless((int) $pengguna->id_role === 1, 403);

        $mahasiswa = $pengguna->mahasiswa;

        // Ambil pengaduan milik mahasiswa yang sedang login.
        $pengaduans = $mahasiswa
            ? $mahasiswa->pengaduan()
                ->orderBy('tanggal_pengajuan', 'desc')
                ->get()
            : collect();

        $totalPengaduan = $pengaduans->count();

        $pengaduanDiajukan = $pengaduans
            ->where('status', 'Diajukan')
            ->count();

        $pengaduanLainnya = $totalPengaduan - $pengaduanDiajukan;

        return view('mahasiswa.dashboard', compact(
            'pengguna',
            'mahasiswa',
            'pengaduans',
            'totalPengaduan',
            'pengaduanDiajukan',
            'pengaduanLainnya'
        ));
    }

    /**
     * Menampilkan detail pengaduan milik mahasiswa.
     */
    public function show($id)
    {
        $pengguna = Auth::user();

        abort_unless((int) $pengguna->id_role === 1, 403);

        $mahasiswa = $pengguna->mahasiswa;

        $pengaduan = $mahasiswa
            ? $mahasiswa->pengaduan()
                ->with(['buktiPengaduan', 'riwayatPengaduan'])
                ->findOrFail($id)
            : abort(404);

        return view('mahasiswa.detail-pengaduan', compact(
            'pengguna',
            'mahasiswa',
            'pengaduan'
        ));
    }

    /**
     * Menampilkan bukti pengaduan milik mahasiswa.
     */
    public function lihatBukti($pengaduanId, $buktiId)
    {
        $pengguna = Auth::user();

        abort_unless((int) $pengguna->id_role === 1, 403);

        $mahasiswa = $pengguna->mahasiswa;

        abort_if(!$mahasiswa, 404);

        $pengaduan = $mahasiswa->pengaduan()
            ->findOrFail($pengaduanId);

        $bukti = $pengaduan->buktiPengaduan()
            ->findOrFail($buktiId);

        abort_unless(
            Storage::disk('local')->exists($bukti->lokasi_file),
            404
        );

        return response()->file(
            Storage::disk('local')->path($bukti->lokasi_file)
        );
    }

    /**
     * Mengunduh bukti pengaduan milik mahasiswa.
     */
    public function unduhBukti($pengaduanId, $buktiId)
    {
        $pengguna = Auth::user();

        abort_unless((int) $pengguna->id_role === 1, 403);

        $mahasiswa = $pengguna->mahasiswa;

        abort_if(!$mahasiswa, 404);

        $pengaduan = $mahasiswa->pengaduan()
            ->findOrFail($pengaduanId);

        $bukti = $pengaduan->buktiPengaduan()
            ->findOrFail($buktiId);

        abort_unless(
            Storage::disk('local')->exists($bukti->lokasi_file),
            404
        );

        return Storage::disk('local')->download(
            $bukti->lokasi_file,
            $bukti->nama_file
        );
    }

    /**
     * Menampilkan formulir pengaduan.
     */
    public function create()
    {
        $pengguna = Auth::user();

        abort_unless((int) $pengguna->id_role === 1, 403);

        return view('mahasiswa.form-pengaduan', compact('pengguna'));
    }

    /**
     * Menyimpan pengaduan baru.
     */
    public function store(Request $request)
    {
        $pengguna = Auth::user();

        abort_unless((int) $pengguna->id_role === 1, 403);

        $mahasiswa = $pengguna->mahasiswa;

        abort_if(!$mahasiswa, 404);


        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'judul_pengaduan' => 'required|string|max:150',
            'informasi_permasalahan' => 'required|string',
            'kronologi' => 'required|string',
            'bukti' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $lokasiFile = null;

        try {
            DB::transaction(function () use (
                $validated,
                $request,
                $mahasiswa,
                &$lokasiFile
            ) {
                // Nomor sementara unik diganti setelah ID pengaduan dibuat.
                $nomor = 'TEMP-' . (string) \Illuminate\Support\Str::uuid();

                $pengaduan = $mahasiswa->pengaduan()->create([
                    'nomor_pengaduan' => $nomor,
                    'kategori' => $validated['kategori'],
                    'judul_pengaduan' => $validated['judul_pengaduan'],
                    'informasi_permasalahan' => $validated['informasi_permasalahan'],
                    'kronologi' => $validated['kronologi'],
                    'tanggal_pengajuan' => now(),
                    'status' => 'Diajukan',
                ]);

                $pengaduan->update([
                    'nomor_pengaduan' => 'ELAW-' . now()->year . '-'
                        . str_pad((string) $pengaduan->id_pengaduan, 4, '0', STR_PAD_LEFT),
                ]);

                // Simpan bukti baru pada penyimpanan lokal yang privat.
                if ($request->hasFile('bukti')) {
                    $file = $request->file('bukti');

                    $lokasiFile = $file->store(
                        'bukti_pengaduan',
                        'local'
                    );

                    if ($lokasiFile === false) {
                        throw new \RuntimeException('Bukti tidak dapat disimpan.');
                    }

                    $pengaduan->buktiPengaduan()->create([
                        'nama_file' => $file->getClientOriginalName(),
                        'lokasi_file' => $lokasiFile,
                        'tanggal_upload' => now(),
                    ]);
                }

                $pengaduan->riwayatPengaduan()->create([
                    'aktivitas' => 'Pengaduan diajukan oleh mahasiswa',
                    'status_sebelumnya' => null,
                    'status_baru' => 'Diajukan',
                    'keterangan' => 'Mahasiswa berhasil mengirimkan pengaduan.',
                    'waktu_perubahan' => now(),
                ]);
            });
        } catch (\Throwable $e) {
            // Hapus file baru jika penyimpanan database gagal.
            if ($lokasiFile) {
                Storage::disk('local')->delete($lokasiFile);
            }

            throw $e;
        }

        return redirect()
            ->route('mahasiswa.dashboard')
            ->with('success', 'Pengaduan berhasil diajukan.');
    }

    /**
     * Menampilkan formulir perbaikan pengaduan.
     */
    public function editPerbaikan($id)
    {
        $pengguna = Auth::user();

        abort_unless((int) $pengguna->id_role === 1, 403);

        $mahasiswa = $pengguna->mahasiswa;

        abort_if(!$mahasiswa, 404);

        // Pastikan pengaduan milik mahasiswa yang sedang login.
        $pengaduan = $mahasiswa->pengaduan()->findOrFail($id);

        abort_unless(
            $pengaduan->status === 'Perlu Dilengkapi/Diperbaiki',
            403,
            'Pengaduan ini tidak sedang menunggu perbaikan.'
        );

        $permintaanPerbaikan = $pengaduan->riwayatPengaduan()
            ->where('status_baru', 'Perlu Dilengkapi/Diperbaiki')
            ->orderByDesc('id_riwayat')
            ->first();

        return view('mahasiswa.perbaikan-pengaduan', compact(
            'pengaduan',
            'permintaanPerbaikan'
        ));
    }

    /**
     * Menyimpan perbaikan teks pengaduan.
     */
    public function simpanPerbaikan(Request $request, $id)
    {
        $pengguna = Auth::user();

        abort_unless((int) $pengguna->id_role === 1, 403);

        $mahasiswa = $pengguna->mahasiswa;

        abort_if(!$mahasiswa, 404);

        $validated = $request->validate([
            'kategori' => ['required', 'string', 'max:100'],
            'judul_pengaduan' => ['required', 'string', 'max:150'],
            'informasi_permasalahan' => ['required', 'string'],
            'kronologi' => ['required', 'string'],
        ]);

        DB::transaction(function () use ($mahasiswa, $id, $validated) {
            $pengaduan = $mahasiswa->pengaduan()
                ->lockForUpdate()
                ->findOrFail($id);

            abort_unless(
                $pengaduan->status === 'Perlu Dilengkapi/Diperbaiki',
                403,
                'Pengaduan ini tidak sedang menunggu perbaikan.'
            );

            $admins = \App\Models\Pengguna::where('id_role', 2)
                ->where('status_akun', 'Aktif')
                ->get();

            foreach ($admins as $admin) {
                \App\Models\Notifikasi::create([
                    'id_pengguna' => $admin->id_pengguna,
                    'id_pengaduan' => $pengaduan->id_pengaduan,
                    'isi_notifikasi' => 'Perbaikan pengaduan ' . $pengaduan->nomor_pengaduan
                        . ' telah dikirim dan menunggu pemeriksaan.',
                    'waktu_dibuat' => now(),
                    'status_notifikasi' => 'Belum Dibaca',
                ]);
            }

            $statusSebelumnya = $pengaduan->status;

            $pengaduan->update([
                'kategori' => $validated['kategori'],
                'judul_pengaduan' => $validated['judul_pengaduan'],
                'informasi_permasalahan' => $validated['informasi_permasalahan'],
                'kronologi' => $validated['kronologi'],
                'status' => 'Menunggu Pemeriksaan',
            ]);

            $pengaduan->riwayatPengaduan()->create([
                'aktivitas' => 'Mahasiswa mengirim perbaikan pengaduan',
                'status_sebelumnya' => $statusSebelumnya,
                'status_baru' => 'Menunggu Pemeriksaan',
                'keterangan' => 'Perbaikan pengaduan dikirim untuk diperiksa kembali.',
                'waktu_perubahan' => now(),
            ]);
        });

        return redirect()
            ->route('mahasiswa.pengaduan.detail', $id)
            ->with('success', 'Perbaikan pengaduan berhasil dikirim.');
    }
}