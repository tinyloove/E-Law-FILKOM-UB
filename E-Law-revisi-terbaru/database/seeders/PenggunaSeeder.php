<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        $pengguna = [
            [
                'id_pengguna' => 1,
                'nama' => 'Mahasiswa Dummy',
                'username' => 'mahasiswa',
                'password' => Hash::make('password123'),
                'email' => 'mahasiswa@elaw.test',
                'status_akun' => 'Aktif',
                'id_role' => 1,
            ],
            [
                'id_pengguna' => 2,
                'nama' => 'Admin Layanan Hukum',
                'username' => 'admin',
                'password' => Hash::make('password123'),
                'email' => 'admin@elaw.test',
                'status_akun' => 'Aktif',
                'id_role' => 2,
            ],
            [
                'id_pengguna' => 3,
                'nama' => 'Tim Hukum Dummy',
                'username' => 'timhukum',
                'password' => Hash::make('password123'),
                'email' => 'timhukum@elaw.test',
                'status_akun' => 'Aktif',
                'id_role' => 3,
            ],
            [
                'id_pengguna' => 4,
                'nama' => 'Pimpinan Fakultas',
                'username' => 'pimpinan',
                'password' => Hash::make('password123'),
                'email' => 'pimpinan@elaw.test',
                'status_akun' => 'Aktif',
                'id_role' => 4,
            ],
        ];

        foreach ($pengguna as $data) {
            Pengguna::updateOrCreate(
                ['id_pengguna' => $data['id_pengguna']],
                $data
            );
        }
    }
}
