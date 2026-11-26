<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaduan;

class PengaduanSeeder extends Seeder
{
    public function run(): void
    {
        Pengaduan::updateOrCreate(
            ['nomor_pengaduan' => 'ELAW-2026-0001'],
            [
                'id_mahasiswa' => 1,
                'kategori' => 'Akademik',
                'judul_pengaduan' => 'Permasalahan Akademik Mahasiswa',
                'informasi_permasalahan' => 'Mahasiswa mengalami kendala dalam proses akademik.',
                'kronologi' => 'Mahasiswa mengalami permasalahan akademik dan mengajukan pengaduan melalui sistem E-Law untuk mendapatkan tindak lanjut dari pihak fakultas.',
                'tanggal_pengajuan' => '2026-11-10',
                'status' => 'Diajukan',
            ]
        );
    }
}
