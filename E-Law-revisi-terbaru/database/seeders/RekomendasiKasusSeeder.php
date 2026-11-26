<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RekomendasiKasus;

class RekomendasiKasusSeeder extends Seeder
{
    public function run(): void
    {
        RekomendasiKasus::updateOrCreate(
            ['id_rekomendasi' => 1],
            [
                'id_pengaduan' => 1,
                'isi_rekomendasi' => 'Berdasarkan hasil analisis Tim Hukum, direkomendasikan agar pihak fakultas melakukan koordinasi dengan program studi terkait untuk menyelesaikan permasalahan akademik yang dialami mahasiswa.',
                'tanggal_rekomendasi' => '2026-11-10',
            ]
        );
    }
}
