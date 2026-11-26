<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPenanganan extends Model
{
    protected $table = 'hasil_penanganan';

    protected $primaryKey = 'id_hasil';

    public $timestamps = false;

    protected $fillable = [
        'id_pengaduan',
        'id_tim_hukum',
        'hasil_analisis',
        'rekomendasi_penanganan',
        'tanggal_penyusunan',
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
