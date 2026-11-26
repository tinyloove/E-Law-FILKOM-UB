<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekomendasiKasus extends Model
{
    protected $table = 'rekomendasi_kasus';

    protected $primaryKey = 'id_rekomendasi';

    public $timestamps = false;

    protected $fillable = [
        'id_pengaduan',
        'isi_rekomendasi',
        'tanggal_rekomendasi',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }
}
