<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        Mahasiswa::updateOrCreate(
            ['id_mahasiswa' => 1],
            [
                'nama' => 'Mahasiswa Dummy',
                'id_pengguna' => 1,
            ]
        );
    }
}
