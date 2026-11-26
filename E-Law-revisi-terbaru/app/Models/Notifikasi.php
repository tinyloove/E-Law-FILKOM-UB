<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $primaryKey = 'id_notifikasi';

    public $timestamps = false;

    protected $fillable = [
        'id_pengguna',
        'id_pengaduan',
        'isi_notifikasi',
        'waktu_dibuat',
        'status_notifikasi',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }
}
