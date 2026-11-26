<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenugasanTimHukum extends Model
{
    protected $table = 'penugasan_tim_hukum';

    protected $primaryKey = 'id_penugasan';

    public $timestamps = false;

    protected $fillable = [
        'id_pengaduan',
        'id_tim_hukum',
        'kategori_akhir',
        'tanggal_penyerahan',
        'status_penugasan',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }

    public function timHukum()
    {
        return $this->belongsTo(Pengguna::class, 'id_tim_hukum', 'id_pengguna');
    }
}
