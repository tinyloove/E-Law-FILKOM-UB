<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notifikasi;

class NotifikasiSeeder extends Seeder
{
    public function run(): void
    {
        Notifikasi::updateOrCreate(
            ['id_notifikasi' => 1],
            [
                'id_pengguna' => 1,
                'id_pengaduan' => 1,
                'isi_notifikasi' => 'Pengaduan ELAW-2026-0001 telah berhasil diajukan dan sedang menunggu proses verifikasi oleh Admin Layanan Hukum.',
                'waktu_dibuat' => '2026-11-10 10:00:00',
                'status_notifikasi' => 'Belum Dibaca',
            ]
        );
    }
}
