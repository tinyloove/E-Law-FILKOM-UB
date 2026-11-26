<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPengaduan extends Model
{
    protected $table = 'riwayat_pengaduan';

    protected $primaryKey = 'id_riwayat';

    public $timestamps = false;

    protected $fillable = [
        'id_pengaduan',
        'aktivitas',
        'status_sebelumnya',
        'status_baru',
        'keterangan',
        'waktu_perubahan',
    ];

    // Relasi ke Pengaduan
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }
}
