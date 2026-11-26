<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RiwayatPengaduan;

class RiwayatPengaduanSeeder extends Seeder
{
    public function run(): void
    {
        RiwayatPengaduan::updateOrCreate(
            ['id_riwayat' => 1],
            [
                'id_pengaduan' => 1,
                'aktivitas' => 'Pengaduan diajukan',
                'status_sebelumnya' => null,
                'status_baru' => 'Diajukan',
                'keterangan' => 'Mahasiswa berhasil mengirimkan pengaduan melalui sistem E-Law.',
                'waktu_perubahan' => '2026-11-10 09:00:00',
            ]
        );
    }
}
