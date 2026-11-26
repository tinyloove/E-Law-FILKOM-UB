<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'login_log';

    protected $primaryKey = 'id_log';

    public $timestamps = false;

    protected $fillable = [
        'id_pengguna',
        'waktu_login',
        'ip_address',
        'status',
    ];

    // Relasi ke Pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
