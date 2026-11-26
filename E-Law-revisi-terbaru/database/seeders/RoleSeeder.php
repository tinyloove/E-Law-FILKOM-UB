<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'id_role' => 1,
                'nama_role' => 'Mahasiswa',
                'deskripsi' => 'Pengguna yang mengajukan dan memantau pengaduan.',
            ],
            [
                'id_role' => 2,
                'nama_role' => 'Admin Layanan Hukum',
                'deskripsi' => 'Pengguna yang memverifikasi dan mengelola pengaduan.',
            ],
            [
                'id_role' => 3,
                'nama_role' => 'Tim Hukum',
                'deskripsi' => 'Pengguna yang menangani dan menganalisis pengaduan.',
            ],
            [
                'id_role' => 4,
                'nama_role' => 'Pimpinan Fakultas',
                'deskripsi' => 'Pengguna yang meninjau dan memberikan keputusan.',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['id_role' => $role['id_role']],
                $role
            );
        }
    }
}
