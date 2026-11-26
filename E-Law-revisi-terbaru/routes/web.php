<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MahasiswaDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TimHukumController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\NotifikasiController;


// Halaman login
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

// Proses login
Route::post('/login', [LoginController::class, 'login'])
    ->name('login.process');

// Proses logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// Landing page E-Law
Route::get('/', function () {
    return view('welcome');
});

// Dashboard berdasarkan role
Route::middleware('auth')->group(function () {
    
    // Notifikasi pengguna yang sedang login
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])
        ->name('notifikasi.index');

    Route::post('/notifikasi/{id}/dibaca', [NotifikasiController::class, 'tandaiDibaca'])
        ->whereNumber('id')
        ->name('notifikasi.dibaca');

    // Dashboard dan pengaduan mahasiswa
    Route::get('/mahasiswa/dashboard', [MahasiswaDashboardController::class, 'index'])
        ->name('mahasiswa.dashboard');

    Route::get('/mahasiswa/pengaduan/create', [MahasiswaDashboardController::class, 'create'])
        ->name('mahasiswa.pengaduan.create');

    Route::post('/mahasiswa/pengaduan', [MahasiswaDashboardController::class, 'store'])
        ->name('mahasiswa.pengaduan.store');

    Route::get('/mahasiswa/pengaduan/{id}', [MahasiswaDashboardController::class, 'show'])
        ->whereNumber('id')
        ->name('mahasiswa.pengaduan.detail');

    Route::get('/mahasiswa/pengaduan/{id}/perbaikan', [MahasiswaDashboardController::class, 'editPerbaikan'])
    ->whereNumber('id')
    ->name('mahasiswa.pengaduan.perbaikan');

    Route::post('/mahasiswa/pengaduan/{id}/perbaikan', [MahasiswaDashboardController::class, 'simpanPerbaikan'])
        ->whereNumber('id')
        ->name('mahasiswa.pengaduan.perbaikan.simpan');

    Route::get(
        '/mahasiswa/pengaduan/{pengaduanId}/bukti/{buktiId}',
        [MahasiswaDashboardController::class, 'lihatBukti']
    )->name('mahasiswa.bukti.lihat');

    Route::get(
        '/mahasiswa/pengaduan/{pengaduanId}/bukti/{buktiId}/unduh',
        [MahasiswaDashboardController::class, 'unduhBukti']
    )->name('mahasiswa.bukti.unduh');

    Route::get('/admin/pengaduan/{pengaduanId}/bukti/{buktiId}', [AdminDashboardController::class, 'lihatBukti'])
        ->whereNumber('pengaduanId')->whereNumber('buktiId')
        ->name('admin.bukti.lihat');

    // Dashboard dan penugasan admin
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/pengaduan/{id}', [AdminDashboardController::class, 'show'])
        ->whereNumber('id')
        ->name('admin.pengaduan.detail');

    Route::post('/admin/pengaduan/{id}/validasi', [AdminDashboardController::class, 'validasiPengaduan'])
        ->whereNumber('id')
        ->name('admin.pengaduan.validasi');

    Route::post('/admin/pengaduan/{id}/minta-perbaikan', [AdminDashboardController::class, 'mintaPerbaikan'])
        ->whereNumber('id')
        ->name('admin.pengaduan.minta-perbaikan');

    Route::get('/admin/penugasan', [AdminDashboardController::class, 'penugasan'])
        ->name('admin.penugasan');

    Route::post('/admin/pengaduan/{id}/teruskan', [AdminDashboardController::class, 'teruskan'])
        ->whereNumber('id')
        ->name('admin.pengaduan.teruskan');

    // Daftar Tugas Tim Hukum
    Route::get('/tim-hukum/dashboard', [TimHukumController::class, 'index'])
        ->name('tim-hukum.dashboard');

    Route::get('/tim-hukum/tugas/{id}', [TimHukumController::class, 'show'])
    ->whereNumber('id')
    ->name('tim-hukum.tugas.detail');

    Route::post('/tim-hukum/tugas/{id}', [TimHukumController::class, 'simpan'])
    ->whereNumber('id')
    ->name('tim-hukum.tugas.simpan');

    Route::get('/tim-hukum/tugas/{id}/bukti/{buktiId}', [TimHukumController::class, 'lihatBukti'])
        ->whereNumber('id')->whereNumber('buktiId')
        ->name('tim-hukum.bukti.lihat');

    // Dashboard Pimpinan Fakultas
   Route::get('/pimpinan/dashboard', [PimpinanController::class, 'index'])
   ->name('pimpinan.dashboard');

   Route::get('/pimpinan/pengaduan/{id}', [PimpinanController::class, 'show'])
   ->whereNumber('id')
   ->name('pimpinan.pengaduan.detail');

   Route::get('/pimpinan/pengaduan/{id}/bukti/{buktiId}', [PimpinanController::class, 'lihatBukti'])
       ->whereNumber('id')->whereNumber('buktiId')
       ->name('pimpinan.bukti.lihat');

   Route::post('/pimpinan/pengaduan/{id}/keputusan', [PimpinanController::class, 'putuskan'])
   ->whereNumber('id')
    ->name('pimpinan.pengaduan.putuskan');
});