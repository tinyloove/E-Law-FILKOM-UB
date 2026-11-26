<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeputusanPengaduan extends Model
{
    protected $table = 'keputusan_pengaduan';

    protected $primaryKey = 'id_keputusan';

    public $timestamps = false;

    protected $fillable = [
        'id_pengaduan',
        'id_pimpinan',
        'status_keputusan',
        'catatan_arahan',
        'tanggal_keputusan',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }

    public function pimpinan()
    {
        return $this->belongsTo(Pengguna::class, 'id_pimpinan', 'id_pengguna');
    }
}
