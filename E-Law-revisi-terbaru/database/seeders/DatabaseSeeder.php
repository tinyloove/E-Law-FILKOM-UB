<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PenggunaSeeder::class,
            MahasiswaSeeder::class,
            PengaduanSeeder::class,
            BuktiPengaduanSeeder::class,
            RiwayatPengaduanSeeder::class,
            PenugasanTimHukumSeeder::class,
            HasilPenangananSeeder::class,
            RekomendasiKasusSeeder::class,
            KeputusanPengaduanSeeder::class,
            NotifikasiSeeder::class,
        ]);
    }
}
