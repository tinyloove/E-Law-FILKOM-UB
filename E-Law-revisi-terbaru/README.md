# E-Law

Aplikasi pengaduan mahasiswa berbasis Laravel. Pengguna terdiri dari mahasiswa, admin layanan hukum, tim hukum, dan pimpinan fakultas.

## Persiapan lokal

Diperlukan PHP dan Composer yang sesuai dengan `composer.json`, serta MySQL. Siapkan database MySQL baru yang kosong. Jangan gunakan database berisi data penting untuk pengujian.

1. Ekstrak proyek dan buka terminal pada folder yang berisi `artisan`.
2. Jalankan `composer install`.
3. Salin `.env.example` menjadi `.env`, misalnya di PowerShell: `Copy-Item .env.example .env`.
4. Ubah pengaturan database di `.env` sesuai MySQL lokal: `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD`. Jangan unggah `.env` ke GitHub.
5. Jalankan `php artisan key:generate`, kemudian `php artisan migrate`.
6. Pada database kosong untuk demonstrasi, jalankan secara berurutan:

   ```powershell
   php artisan db:seed --class=RoleSeeder
   php artisan db:seed --class=PenggunaSeeder
   php artisan db:seed --class=MahasiswaSeeder
   ```

   Seeder ini membuat atau memperbarui data dengan ID tetap. Jangan jalankan pada database yang sudah berisi data penting tanpa pemeriksaan terlebih dahulu. Seeder lain berisi data contoh yang belum seluruhnya sesuai dengan alur terkini.
7. Jalankan `php artisan serve --port=8001`, lalu buka `http://127.0.0.1:8001`.

Akun contoh untuk demonstrasi lokal: `mahasiswa`, `admin`, `timhukum`, dan `pimpinan`; password awal masing-masing `password123`. Akun ini tidak boleh dipakai untuk aplikasi yang diakses publik.

## Unggah bukti

Pengaduan baru mewajibkan bukti PDF, JPG, JPEG, atau PNG, maksimal 5 MB. Pastikan PHP mengizinkan unggahan, `upload_max_filesize` minimal 5M, `post_max_size` lebih besar dari 5M, dan folder sementara unggahan tersedia serta bisa ditulis oleh proses PHP. Mulai ulang server setelah mengubah konfigurasi PHP.

Bukti baru disimpan di `storage/app/private` dan tidak termasuk dalam ZIP atau repositori. Database dan bukti pada komputer lain tidak akan otomatis terisi ketika kode disalin. Akses bukti disediakan untuk mahasiswa pemilik, admin, tim hukum yang ditugaskan, dan pimpinan selama pengaduan menunggu review.

## Status pengujian

Alur pengajuan, pemeriksaan, perbaikan, penugasan, review, keputusan, dan notifikasi telah dicoba menggunakan data contoh. Pengujian otomatis dan keamanan menyeluruh masih perlu dilengkapi sebelum digunakan dengan data nyata. Menu Pusat Bantuan dan Penanganan belum lengkap.