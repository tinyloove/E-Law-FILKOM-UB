<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiPengaduan extends Model
{
    protected $table = 'bukti_pengaduan';

    protected $primaryKey = 'id_bukti';

    public $timestamps = false;

    protected $fillable = [
        'id_pengaduan',
        'nama_file',
        'lokasi_file',
        'tanggal_upload',
    ];

    // Relasi: satu bukti dimiliki oleh satu pengaduan
    public function pengaduan()
    {
        return $this->belongsTo(
            Pengaduan::class,
            'id_pengaduan',
            'id_pengaduan'
        );
    }
}
