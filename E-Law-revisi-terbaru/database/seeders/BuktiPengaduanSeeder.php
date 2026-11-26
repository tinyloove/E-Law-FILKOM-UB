<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BuktiPengaduan;

class BuktiPengaduanSeeder extends Seeder
{
    public function run(): void
    {
        BuktiPengaduan::updateOrCreate(
            ['id_bukti' => 1],
            [
                'id_pengaduan' => 1,
                'nama_file' => 'bukti_pengaduan_dummy.pdf',
                'lokasi_file' => 'bukti_pengaduan/bukti_pengaduan_dummy.pdf',
                'tanggal_upload' => '2026-11-10',
            ]
        );
    }
}
