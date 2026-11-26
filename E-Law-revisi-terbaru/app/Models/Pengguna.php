<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';

    protected $primaryKey = 'id_pengguna';

    protected $fillable = [
        'nama',
        'username',
        'password',
        'email',
        'status_akun',
        'id_role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function getAuthPasswordName()
    {
        return 'password';
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'id_pengguna', 'id_pengguna');
    }
}
