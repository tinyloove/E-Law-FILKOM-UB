<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PenugasanTimHukum;

class PenugasanTimHukumSeeder extends Seeder
{
    public function run(): void
    {
        PenugasanTimHukum::updateOrCreate(
            ['id_penugasan' => 1],
            [
                'id_pengaduan' => 1,
                'id_tim_hukum' => 3,
                'kategori_akhir' => 'Akademik',
                'tanggal_penyerahan' => '2026-11-10',
                'status_penugasan' => 'Ditugaskan',
            ]
        );
    }
}
