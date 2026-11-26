<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';

    protected $primaryKey = 'id_pengaduan';

    public $timestamps = false;

    protected $fillable = [
        'nomor_pengaduan',
        'id_mahasiswa',
        'kategori',
        'judul_pengaduan',
        'informasi_permasalahan',
        'kronologi',
        'tanggal_pengajuan',
        'status',
    ];

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    // Relasi ke Bukti Pengaduan
    public function buktiPengaduan()
    {
        return $this->hasMany(BuktiPengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }

    // Relasi ke Riwayat Pengaduan
    public function riwayatPengaduan()
    {
        return $this->hasMany(RiwayatPengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }

    // Relasi ke Penugasan Tim Hukum
    public function penugasanTimHukum()
    {
        return $this->hasMany(PenugasanTimHukum::class, 'id_pengaduan', 'id_pengaduan');
    }

    // Relasi ke Hasil Penanganan
    public function hasilPenanganan()
    {
        return $this->hasMany(HasilPenanganan::class, 'id_pengaduan', 'id_pengaduan');
    }

    // Relasi ke Rekomendasi Kasus
    public function rekomendasiKasus()
    {
        return $this->hasMany(RekomendasiKasus::class, 'id_pengaduan', 'id_pengaduan');
    }

    // Relasi ke Keputusan Pengaduan
    public function keputusanPengaduan()
    {
        return $this->hasMany(KeputusanPengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }

    // Relasi ke Notifikasi
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_pengaduan', 'id_pengaduan');
    }
}
