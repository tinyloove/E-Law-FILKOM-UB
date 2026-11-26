<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KeputusanPengaduan;

class KeputusanPengaduanSeeder extends Seeder
{
    public function run(): void
    {
        KeputusanPengaduan::updateOrCreate(
            ['id_keputusan' => 1],
            [
                'id_pengaduan' => 1,
                'id_pimpinan' => 4,
                'status_keputusan' => 'Disetujui',
                'catatan_arahan' => 'Rekomendasi Tim Hukum disetujui. Pihak fakultas diminta melakukan koordinasi dengan program studi terkait untuk menindaklanjuti penyelesaian permasalahan akademik mahasiswa.',
                'tanggal_keputusan' => '2026-11-10',
            ]
        );
    }
}
