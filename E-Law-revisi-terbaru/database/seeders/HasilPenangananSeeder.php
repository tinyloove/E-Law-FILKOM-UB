<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HasilPenanganan;

class HasilPenangananSeeder extends Seeder
{
    public function run(): void
    {
        HasilPenanganan::updateOrCreate(
            ['id_hasil' => 1],
            [
                'id_pengaduan' => 1,
                'id_tim_hukum' => 3,
                'hasil_analisis' => 'Berdasarkan hasil pemeriksaan awal, pengaduan berkaitan dengan permasalahan akademik yang memerlukan klarifikasi dari pihak terkait.',
                'rekomendasi_penanganan' => 'Tim Hukum merekomendasikan koordinasi dengan program studi dan pihak fakultas untuk memperoleh informasi serta menyelesaikan permasalahan.',
                'tanggal_penyusunan' => '2026-11-10',
            ]
        );
    }
}
