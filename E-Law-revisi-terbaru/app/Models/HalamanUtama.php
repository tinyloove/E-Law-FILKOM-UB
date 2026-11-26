<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HalamanUtama extends Model
{
    protected $table = 'halaman_utama';

    protected $primaryKey = 'id_halaman';

    public $timestamps = false;

    protected $fillable = [
        'nama_halaman',
        'deskripsi',
        'id_role',
    ];

    // Relasi ke Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }
}
