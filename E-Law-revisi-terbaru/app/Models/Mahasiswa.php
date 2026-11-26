<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $primaryKey = 'id_mahasiswa';

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'id_pengguna',
    ];

    // Relasi ke Pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    // Relasi ke Pengaduan
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'id_mahasiswa', 'id_mahasiswa');
    }
}
