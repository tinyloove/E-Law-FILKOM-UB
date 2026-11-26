README.txt DOKUMENTASI SERAH TERIMA PROYEK E-LAW
=====================================

Dokumen ini dibuat sebagai konteks kerja untuk melanjutkan proyek E-Law
di komputer pengembang maupun melalui ChatGPT lain. Informasi dibagi
menjadi fakta yang sudah diketahui, implementasi yang sudah dilakukan,
dan pekerjaan yang masih perlu diverifikasi. Jangan menganggap fitur
yang berstatus “belum diverifikasi” sudah selesai.

1. IDENTITAS DAN TUJUAN PROYEK

Nama proyek : E-Law Jenis aplikasi : Sistem informasi layanan/pengaduan
hukum fakultas Framework : Laravel Frontend : Blade, HTML, CSS Database
: MySQL Lingkungan kerja : Windows, VS Code, XAMPP/phpMyAdmin, terminal
Folder proyek : C:\SI UB-law Nama database : e_law (nama yang digunakan
dalam rancangan/setup awal; verifikasi di file .env)

Tujuan: E-Law digunakan untuk mengelola pengaduan mahasiswa terkait
layanan/permasalahan hukum di lingkungan fakultas. Sistem memiliki empat
jenis pengguna: Mahasiswa, Admin Layanan Hukum, Tim Hukum, dan Pimpinan
Fakultas.

Alur bisnis utama: 1. Mahasiswa login, mengajukan pengaduan, melampirkan
bukti, dan memantau status. 2. Admin Layanan Hukum memeriksa pengaduan,
mengelola proses verifikasi, meminta perbaikan jika diperlukan, serta
meneruskan pengaduan kepada anggota Tim Hukum. 3. Tim Hukum menerima
penugasan, menangani/menganalisis kasus, dan menyiapkan hasil atau
rekomendasi penanganan. 4. Pimpinan Fakultas meninjau hasil/rekomendasi
dan memberikan keputusan.

2. ROLE DAN HAK AKSES

Data role yang sudah diperiksa langsung melalui Laravel Tinker:

id_role = 1 | Mahasiswa Deskripsi: Pengguna yang mengajukan dan memantau
pengaduan.

id_role = 2 | Admin Layanan Hukum Deskripsi: Pengguna yang memverifikasi
dan mengelola pengaduan.

id_role = 3 | Tim Hukum Deskripsi: Pengguna yang menangani dan
menganalisis pengaduan.

id_role = 4 | Pimpinan Fakultas Deskripsi: Pengguna yang meninjau dan
memberikan keputusan.

Pemeriksaan role pada controller menggunakan: - Admin:
Auth::user()->id_role === 2 - Tim Hukum: id_role === 3 - Pimpinan:
id_role === 4

Jangan mengubah ID role tanpa menyesuaikan seluruh controller, query,
dan route.

3. STACK DAN SETUP LINGKUNGAN

Yang diketahui: - Proyek Laravel berhasil dibuat dan dijalankan pada
Windows. - Node.js v26.13.0 dan NPM 11.20.0 pernah terdeteksi
tersedia. - Perintah npm.cmd tersedia pada Windows. - XAMPP/MySQL
digunakan atau direncanakan untuk database lokal. - Editor yang
digunakan: Visual Studio Code.

Perintah pengembangan umum: cd “C:\SI UB-law” composer install npm
install npm run build php artisan serve

Jika proyek baru dikloning, periksa dahulu file README, composer.json,
package.json, dan .env.example. Jangan menimpa .env lokal tanpa
memeriksa konfigurasi.

Langkah setup database: 1. Jalankan MySQL melalui XAMPP. 2.
Buat/pastikan database e_law tersedia di phpMyAdmin, atau gunakan nama
database yang tercantum di .env. 3. Periksa DB_DATABASE, DB_USERNAME,
DB_PASSWORD, DB_HOST, dan DB_PORT pada .env. 4. Jalankan migrasi hanya
setelah memeriksa apakah database sudah berisi data penting: php artisan
migrate:status php artisan migrate 5. Jangan menjalankan migrate:fresh
atau db:wipe pada database yang berisi data penting karena dapat
menghapus tabel/data.

Perintah berguna: php artisan route:list php artisan route:list
–name=admin php artisan migrate:status php artisan optimize:clear php
artisan view:clear php artisan config:clear php artisan tinker

4. DESAIN UI DAN POLA TAMPILAN

Arah desain yang diminta dan dipakai pada halaman yang dikerjakan: -
Tampilan dashboard menggunakan sidebar berwarna merah. - Logo
ditempatkan pada sidebar. - Struktur section, jarak, dan pola layout
antarhalaman dibuat seragam. - Halaman admin mengikuti pola visual
dashboard/detail yang sudah ada. - HTML dan CSS ditulis pada Blade view;
jangan mengganti keseluruhan desain saat menambahkan fitur. -
Pertahankan konsistensi nama menu, warna, sidebar, header, card, tabel,
tombol, dan section. - Beberapa halaman menggunakan HTML/CSS langsung di
file Blade.

Halaman/UI yang telah dibahas/dikerjakan dalam percakapan: - Dashboard
Admin: resources/views/admin/dashboard.blade.php (nama view yang
dipanggil controller: admin.dashboard). - Detail Pengaduan Admin:
resources/views/admin/detail-pengaduan.blade.php (nama view:
admin.detail-pengaduan). - Halaman penugasan Admin dipanggil sebagai
view admin.penugasan, sehingga file yang diharapkan adalah
resources/views/admin/penugasan.blade.php. Keberadaan dan kelengkapan UI
finalnya harus diperiksa. - Halaman detail pengaduan mahasiswa dan
dashboard mahasiswa pernah menjadi bagian pengerjaan sebelumnya. Periksa
file aktual sebelum menyimpulkan semua alur mahasiswa sudah lengkap. -
Dashboard Tim Hukum dan Pimpinan saat ini masih berupa placeholder
sederhana yang mengembalikan view dashboard.index dengan judul
masing-masing.

Penting: sebelum mengubah UI, baca file Blade yang sudah ada. Pengguna
meminta desain yang seragam dengan sidebar merah dan sectioning yang
sama, bukan desain ulang.

5. STRUKTUR DATABASE DAN INFORMASI DDL YANG SUDAH DIKETAHUI

Catatan: DDL lengkap seluruh database belum tersedia dalam konteks ini.
Bagian berikut adalah hasil DESCRIBE yang pernah dijalankan langsung
melalui Tinker. Untuk tabel lain, periksa database aktual menggunakan
DESCRIBE atau SHOW CREATE TABLE sebelum menulis kode.

5.1 Tabel roles Model menggunakan: - tabel: roles - primary key:
id_role - kolom yang diisi model: nama_role, deskripsi - tabel juga
menampilkan created_at dan updated_at saat Role::all() dijalankan.

5.2 Tabel pengguna Model menggunakan: - tabel: pengguna - primary key:
id_pengguna - fillable: nama, username, password, email, status_akun,
id_role - password disembunyikan dari serialisasi. - password
menggunakan cast hashed. - relasi role: belongsTo Role melalui
id_role. - relasi mahasiswa: hasOne Mahasiswa melalui id_pengguna.

Akun Tim Hukum diambil dengan kondisi: Pengguna::where(‘id_role’, 3)
->where(‘status_akun’, ‘Aktif’) ->orderBy(‘nama’) ->get();

Pastikan nilai status_akun aktual memang “Aktif” (kapitalisasi harus
cocok).

5.3 Tabel pengaduan Hasil DESCRIBE pengaduan: - id_pengaduan int(11),
primary key, auto_increment, NOT NULL - nomor_pengaduan varchar(50), NOT
NULL, UNIQUE - id_mahasiswa int(11), NOT NULL, index - kategori
varchar(100), NOT NULL - judul_pengaduan varchar(150), NULL -
informasi_permasalahan text, NULL - kronologi text, NOT NULL -
tanggal_pengajuan datetime, NOT NULL, default current_timestamp() -
status varchar(50), NOT NULL, default ‘Diajukan’

Model: App - tabel pengaduan - primary key id_pengaduan - timestamps
false - fillable: nomor_pengaduan, id_mahasiswa, kategori,
judul_pengaduan, informasi_permasalahan, kronologi, tanggal_pengajuan,
status - mahasiswa(): belongsTo Mahasiswa - buktiPengaduan(): hasMany
BuktiPengaduan - riwayatPengaduan(): hasMany RiwayatPengaduan -
penugasanTimHukum(): hasMany PenugasanTimHukum - hasilPenanganan():
hasMany HasilPenanganan - rekomendasiKasus(): hasMany RekomendasiKasus -
keputusanPengaduan(): hasMany KeputusanPengaduan - notifikasi(): hasMany
Notifikasi

5.4 Tabel penugasan_tim_hukum Hasil DESCRIBE penugasan_tim_hukum: -
id_penugasan int(11), primary key, auto_increment, NOT NULL -
id_pengaduan int(11), NOT NULL, index - id_tim_hukum int(11), NOT NULL,
index - kategori_akhir varchar(100), NOT NULL - tanggal_penyerahan
datetime, NOT NULL, default current_timestamp() - status_penugasan
varchar(30), NOT NULL, default ‘Ditugaskan’

Model: App - tabel: penugasan_tim_hukum - primary key: id_penugasan -
timestamps false - fillable: id_pengaduan, id_tim_hukum, kategori_akhir,
tanggal_penyerahan, status_penugasan - pengaduan(): belongsTo Pengaduan
melalui id_pengaduan - timHukum(): belongsTo Pengguna melalui
id_tim_hukum -> id_pengguna

Perhatian: - kategori_akhir NOT NULL. Implementasi awal mengisi nilainya
dari pengaduan.kategori. - tanggal_penyerahan mempunyai default
current_timestamp(), sehingga tidak perlu dikirim ketika create kecuali
memang ingin menetapkan waktu eksplisit. - status_penugasan mempunyai
default ‘Ditugaskan’. - Tidak ada bukti pada konteks bahwa tabel ini
memiliki unique constraint untuk id_pengaduan. Controller saat ini
mencegah penugasan kedua dengan pemeriksaan exists(), tetapi constraint
database dapat dipertimbangkan setelah aturan bisnis dipastikan.

5.5 Tabel lain Model/relasi yang disebut dalam aplikasi: - mahasiswa -
bukti_pengaduan - riwayat_pengaduan - hasil_penanganan -
rekomendasi_kasus - keputusan_pengaduan - notifikasi

DDL lengkap, kolom, foreign key, indeks, dan constraint tabel-tabel
tersebut BELUM terdokumentasi di sini. Periksa database lokal dengan:
DESCRIBE nama_tabel; SHOW CREATE TABLE nama_tabel;

Jangan menebak nama kolom atau nilai status untuk tabel-tabel tersebut.

6. MODEL YANG SUDAH DIPERIKSA

A. app/Models/Pengaduan.php - Tabel pengaduan, PK id_pengaduan,
timestamps false. - Fillable dan relasi seperti tercantum di bagian 5.3.

B. app/Models/PenugasanTimHukum.php - Tabel penugasan_tim_hukum, PK
id_penugasan, timestamps false. - Fillable: id_pengaduan, id_tim_hukum,
kategori_akhir, tanggal_penyerahan, status_penugasan. - Relasi
pengaduan() dan timHukum().

C. app/Models/Pengguna.php - Extends Illuminateas Authenticatable. -
Tabel pengguna, PK id_pengguna. - Fillable: nama, username, password,
email, status_akun, id_role. - Hidden: password. - Cast password:
hashed. - getAuthPasswordName() mengembalikan ‘password’. - Relasi
role() belongsTo Role. - Relasi mahasiswa() hasOne Mahasiswa.

D. app/Models/Role.php - Tabel roles, PK id_role. - Fillable: nama_role,
deskripsi.

7. CONTROLLER DAN ROUTE YANG SUDAH DIKERJAKAN

7.1 AdminDashboardController File:
app/Http/Controllers/AdminDashboardController.php

Fungsi index(): - Memastikan hanya role 2 yang dapat mengakses. -
Mengambil seluruh pengaduan dengan eager loading mahasiswa.pengguna. -
Mengurutkan berdasarkan tanggal_pengajuan terbaru. - Menghitung total
pengaduan. - Menghitung status ‘Diajukan’. - Menghitung status ‘Menunggu
Perbaikan’. - Menghitung jumlah baris penugasan_tim_hukum pada bulan dan
tahun berjalan. - Mengirim variabel ke view admin.dashboard.

Fungsi show($id): - Memastikan role 2. - Mengambil pengaduan dengan
relasi mahasiswa.pengguna, buktiPengaduan, riwayatPengaduan. -
Mengembalikan view admin.detail-pengaduan.

Fungsi penugasan(): - Memastikan role 2. - Mengambil pengaduan dengan
mahasiswa.pengguna dan penugasanTimHukum.timHukum. - Mengurutkan
berdasarkan tanggal_pengajuan terbaru. - Mengambil akun pengguna role 3
dengan status_akun ‘Aktif’. - Mengembalikan view admin.penugasan dengan
variabel pengaduans dan timHukums.

Fungsi teruskan(Request $request, $id): - Memastikan role 2. -
Memvalidasi id_tim_hukum sebagai required dan exists pada
pengguna.id_pengguna. - Mengambil pengaduan berdasarkan ID. - Memastikan
akun penerima benar-benar id_role 3 dan status_akun ‘Aktif’. - Mencegah
penerusan ulang apabila pengaduan sudah mempunyai penugasan. -
Menggunakan DB::transaction(). - Membuat PenugasanTimHukum dengan:
id_pengaduan = pengaduan yang dipilih id_tim_hukum = pengguna Tim Hukum
yang dipilih kategori_akhir = pengaduan.kategori status_penugasan =
‘Ditugaskan’ - Mengubah pengaduan.status menjadi ‘Diteruskan ke Tim
Hukum’. - Redirect ke route admin.penugasan dengan flash success.

Catatan implementasi: - Fungsi teruskan baru ditambahkan pada sesi 14
November 2026. - Import Request dan PenugasanTimHukum ditambahkan. -
Kode telah disimpan oleh pengguna dan pengguna menyatakan tidak ada
error editor. - Proses submit penugasan BELUM dibuktikan berjalan
end-to-end. Belum ada hasil uji submit dari browser/database. - Belum
ada pencatatan riwayat dan notifikasi dalam fungsi teruskan. - Validasi
exists hanya memastikan ID ada; pengecekan role dan status aktif
dilakukan lagi melalui query Pengguna. - Jika pengaduan dapat ditugaskan
ulang atau dialihkan, aturan exists() harus disesuaikan dengan kebutuhan
bisnis. Saat ini implementasi menolak penugasan kedua untuk pengaduan
yang sama.

7.2 routes/web.php Route yang diketahui: GET /login name login POST
/login name login.process POST /logout name logout

Di dalam middleware auth: GET /mahasiswa/dashboard name
mahasiswa.dashboard GET /mahasiswa/pengaduan/create name
mahasiswa.pengaduan.create POST /mahasiswa/pengaduan name
mahasiswa.pengaduan.store GET /mahasiswa/pengaduan/{id} name
mahasiswa.pengaduan.detail GET
/mahasiswa/pengaduan/{pengaduanId}/bukti/{buktiId} name
mahasiswa.bukti.lihat GET
/mahasiswa/pengaduan/{pengaduanId}/bukti/{buktiId}/unduh name
mahasiswa.bukti.unduh

GET /admin/dashboard name admin.dashboard GET /admin/pengaduan/{id} name
admin.pengaduan.detail GET /admin/penugasan name admin.penugasan POST
/admin/pengaduan/{id}/teruskan name admin.pengaduan.teruskan

GET /tim-hukum/dashboard name tim-hukum.dashboard GET
/pimpinan/dashboard name pimpinan.dashboard

Route POST penerusan ditambahkan pada sesi 14 November 2026:
Route::post(‘/admin/pengaduan/{id}/teruskan’,
[AdminDashboardController::class, ‘teruskan’]) ->whereNumber(‘id’)
->name(‘admin.pengaduan.teruskan’);

Pengguna telah menjalankan: php artisan route:list –name=admin dan
mengonfirmasi route berhasil terdaftar.

Catatan keamanan: - Semua route di atas berada di middleware auth. -
Dashboard Tim Hukum dan Pimpinan masih menggunakan closure yang
memeriksa role lalu mengembalikan view dashboard.index. - Controller
Admin juga memeriksa role secara langsung. - Untuk route mahasiswa,
periksa controller agar memastikan pembatasan role dan kepemilikan data
dilakukan pada setiap aksi, bukan hanya mengandalkan middleware auth.

8. STATUS PROGRES PADA 14 NOVEMBER 2026

SUDAH DIKETAHUI / SUDAH DIBUAT: [✓] Proyek Laravel dibuat dan berhasil
dijalankan. [✓] Database MySQL digunakan untuk proyek. [✓] Model
Pengguna dan Role digunakan untuk autentikasi/role. [✓] Role database
telah diperiksa: Mahasiswa=1, Admin=2, Tim Hukum=3, Pimpinan=4. [✓]
Model Pengaduan diperiksa dan memiliki relasi ke tabel-tabel terkait.
[✓] Model PenugasanTimHukum diperiksa. [✓] Dashboard Admin memiliki
fungsi pengambilan data dan statistik. [✓] Detail pengaduan Admin
memiliki fungsi show(). [✓] Fungsi penugasan() mengambil daftar
pengaduan dan akun Tim Hukum aktif. [✓] Route admin.penugasan tersedia.
[✓] Fungsi controller teruskan() ditambahkan. [✓] Route POST
admin.pengaduan.teruskan ditambahkan dan terdaftar. [✓] Pola UI yang
diminta: sidebar merah, logo sidebar, sectioning/layout konsisten.

BELUM DIUJI / PERLU DIVERIFIKASI: [ ] Apakah halaman admin.penugasan
menampilkan daftar pengaduan dan pilihan anggota Tim Hukum dengan benar.
[ ] Apakah form Blade mengirim POST ke route admin.pengaduan.teruskan. [
] Apakah @csrf sudah ada di form. [ ] Apakah proses simpan menghasilkan
baris pada penugasan_tim_hukum. [ ] Apakah status pengaduan berubah
menjadi ‘Diteruskan ke Tim Hukum’. [ ] Apakah pesan sukses dan error
tampil di UI. [ ] Apakah pengaduan yang sudah ditugaskan tidak bisa
diteruskan ulang dari UI. [ ] Apakah anggota Tim Hukum dapat melihat
hanya penugasan miliknya. [ ] Apakah riwayat_pengaduan tercatat saat
status berubah. [ ] Apakah notifikasi dibuat untuk Tim Hukum penerima. [
] Apakah alur hasil penanganan, rekomendasi, dan keputusan Pimpinan
sudah berjalan. [ ] Apakah seluruh halaman dan aksi membatasi akses
berdasarkan role dan kepemilikan data. [ ] Apakah seluruh DDL, foreign
key, dan constraint sudah terdokumentasi. [ ] Apakah seluruh fitur telah
diuji dengan data dummy dari awal hingga akhir.

9. LANGKAH SELANJUTNYA (URUTAN YANG DISARANKAN)

Lanjutkan dari titik terakhir, jangan mengulang setup Laravel atau
membuat ulang model tanpa alasan.

LANGKAH 1 - Periksa UI halaman penugasan Admin - Buka
resources/views/admin/penugasan.blade.php. - Pastikan tabel pengaduan
ditampilkan. - Pastikan setiap baris yang belum ditugaskan mempunyai
form pemilihan Tim Hukum. - Form harus menggunakan method POST dan
action: route(‘admin.pengaduan.teruskan’, $pengaduan->id_pengaduan) -
Sertakan @csrf. - Select harus mengirim name=“id_tim_hukum”. - Opsi
diambil dari variabel $timHukums dan menggunakan id_pengguna sebagai
value. - Tampilkan nama pengguna sebagai label. - Jangan tampilkan
tombol teruskan untuk pengaduan yang sudah ditugaskan. - Pertahankan
sidebar merah, logo, dan pola section UI yang ada.

Contoh bentuk form (sesuaikan dengan struktur HTML halaman, jangan
mengganti keseluruhan desain):
@csrf Pilih Tim Hukum @foreach ($timHukums as $timHukum) {{
$timHukum->nama }} @endforeach Teruskan ke Tim Hukum
LANGKAH 2 - Uji penerusan - Login sebagai Admin (role 2). - Buka
/admin/penugasan. - Pilih pengaduan yang belum memiliki penugasan. -
Pilih akun Tim Hukum aktif (role 3). - Klik Teruskan ke Tim Hukum. -
Pastikan redirect ke admin.penugasan. - Pastikan pesan sukses muncul. -
Pastikan tabel penugasan_tim_hukum memiliki baris baru. - Pastikan
pengaduan.status berubah menjadi ‘Diteruskan ke Tim Hukum’. - Uji pula
validasi jika tidak memilih Tim Hukum dan jika mencoba meneruskan
pengaduan yang sama dua kali.

LANGKAH 3 - Perbaiki dan lengkapi proses bisnis - Tambahkan pencatatan
RiwayatPengaduan saat status pengaduan berubah, setelah memeriksa skema
tabel dan model aktual. - Tambahkan Notifikasi untuk akun Tim Hukum
penerima, setelah memeriksa skema tabel dan model aktual. - Pastikan
transaksi database mencakup penugasan, perubahan status, riwayat, dan
notifikasi bila seluruh tabel sudah siap. - Tentukan aturan apakah satu
pengaduan hanya boleh memiliki satu penugasan atau dapat
dialihkan/ditugaskan ulang. Sesuaikan validasi dan constraint database
dengan keputusan tersebut.

LANGKAH 4 - Bangun dashboard Tim Hukum - Ganti placeholder dashboard Tim
Hukum dengan controller khusus. - Ambil penugasan berdasarkan
id_tim_hukum = Auth::id() (atau PK autentikasi yang sesuai, yaitu
id_pengguna). - Tampilkan hanya kasus yang ditugaskan kepada pengguna
yang sedang login. - Buat halaman daftar penugasan dan detail
pengaduan. - Tambahkan proses perubahan status penugasan/penanganan
sesuai aturan bisnis yang disepakati. - Jangan tampilkan seluruh
pengaduan kepada semua anggota Tim Hukum.

LANGKAH 5 - Lengkapi proses hasil penanganan - Periksa DDL dan model
HasilPenanganan. - Buat form dan proses simpan hasil penanganan. -
Periksa DDL dan model RekomendasiKasus. - Buat proses rekomendasi
kasus. - Pastikan hasil/rekomendasi terkait dengan pengaduan dan petugas
yang benar.

LANGKAH 6 - Dashboard Pimpinan Fakultas - Ganti placeholder dashboard
Pimpinan dengan controller khusus. - Tampilkan kasus dan rekomendasi
yang memang perlu ditinjau. - Buat aksi keputusan sesuai DDL
keputusan_pengaduan. - Simpan keputusan dan riwayat perubahan status. -
Batasi akses hanya untuk role 4.

LANGKAH 7 - Pengujian dan dokumentasi - Uji seluruh alur dari Mahasiswa
-> Admin -> Tim Hukum -> Pimpinan -> Mahasiswa. - Uji hak akses empat
role. - Uji validasi input, upload/akses bukti, status, riwayat, dan
notifikasi. - Periksa error log Laravel di storage/logs/laravel.log. -
Jalankan php artisan route:list dan php artisan migrate:status. -
Dokumentasikan DDL lengkap menggunakan SHOW CREATE TABLE untuk seluruh
tabel. - Siapkan akun dummy untuk setiap role dan jangan gunakan
password asli di README/GitHub.

10. CARA MELANJUTKAN DENGAN CHATGPT LAIN

Berikan README.txt ini kepada temanmu atau unggah file ini ke percakapan
ChatGPT baru. Kemudian kirim prompt berikut:

“Saya sedang melanjutkan proyek Laravel bernama E-Law. Baca seluruh
README.txt yang saya lampirkan dan jadikan sebagai konteks utama proyek.
README ini menjelaskan tujuan, stack, role, database yang sudah
diketahui, model, controller, route, UI, progres, serta pekerjaan
berikutnya.

Lanjutkan dari bagian LANGKAH SELANJUTNYA, dimulai dengan memeriksa file
resources/views/admin/penugasan.blade.php. Jangan menganggap fitur yang
ditandai belum diuji sebagai sudah berhasil.

Saya masih belajar Laravel. Berikan instruksi satu file atau satu
langkah dalam satu waktu. Minta saya mengirim isi file sebelum
mengubahnya. Jelaskan secara sederhana file mana yang harus dibuka, kode
apa yang perlu ditambahkan/diganti, dan perintah apa yang harus
dijalankan. Setelah memberikan satu langkah, tunggu konfirmasi saya
sebelum lanjut.

Pertahankan desain UI yang sudah ada: sidebar merah, logo sidebar, dan
sectioning/layout yang konsisten. Jangan membuat ulang proyek, database,
model, atau halaman yang sudah berfungsi tanpa alasan. Jangan menebak
struktur kolom database; minta hasil DESCRIBE/SHOW CREATE TABLE bila
diperlukan. Bedakan dengan jelas antara kode yang sudah dibuat dan fitur
yang sudah diuji.”

11. GIT DAN GITHUB - CHECKLIST SEBELUM PUSH

README ini belum berarti proyek sudah di-push ke GitHub. Push harus
dilakukan dari folder proyek lokal yang benar dan setelah memeriksa
remote serta status Git.

Buka terminal VS Code di folder proyek: cd “C:\SI UB-law”

Periksa: git status git remote -v git branch –show-current

Sebelum commit: - Pastikan .env tidak ikut di-commit. - Pastikan vendor/
dan node_modules/ tidak ikut di-commit. - Pastikan file database lokal,
password, token, dan kredensial tidak ikut di-commit. - Pastikan
.gitignore mencakup .env, /vendor, /node_modules, dan file lokal
sensitif. - Jangan menghapus atau mengganti remote yang sudah ada tanpa
memeriksa repository tujuan. - Jika README ini disimpan di root proyek,
nama file harus README.txt.

Setelah memeriksa perubahan: git add README.txt git add . git status git
commit -m “docs: add E-Law project handover” git push

Catatan: - Jika branch belum memiliki upstream, Git mungkin meminta: git
push -u origin nama-branch - Ganti nama-branch dengan hasil git branch
–show-current. - Jika belum ada remote, tambahkan URL repository GitHub
yang benar setelah pemilik proyek memastikan repository tujuan: git
remote add origin URL_REPOSITORY_GITHUB - Jangan menaruh Personal Access
Token GitHub di README, kode, chat, atau URL remote yang dibagikan. -
Jika diminta login, gunakan Git Credential Manager atau autentikasi
resmi GitHub. - Setelah push, periksa halaman repository GitHub dan
pastikan commit serta README.txt terlihat.

12. CATATAN KEAMANAN DAN KUALITAS

-   Jangan pernah mengunggah .env atau kredensial database/GitHub.
-   Jangan menyimpan password akun dummy dalam README publik.
-   Jangan menggunakan migrate:fresh pada database yang datanya perlu
    dipertahankan.
-   Jangan mempercayai ID pengaduan dari request tanpa memeriksa hak
    akses.
-   Tim Hukum hanya boleh melihat penugasan yang ditujukan kepada akun
    yang login.
-   Pimpinan hanya boleh melakukan aksi keputusan sesuai role 4.
-   Gunakan validasi server-side, CSRF protection, dan database
    transaction untuk proses yang mengubah beberapa tabel.
-   Periksa DDL aktual sebelum membuat insert/update ke tabel riwayat,
    notifikasi, hasil, rekomendasi, atau keputusan.
-   Setelah perubahan controller, periksa route:list dan uji melalui
    browser.
-   Jangan menyatakan fitur selesai hanya karena route terdaftar atau
    halaman dapat dibuka. Uji alur database secara nyata.

AKHIR DOKUMENTASI

Status terakhir yang diketahui: 14 November 2026. Titik lanjut paling
dekat: periksa dan lengkapi resources/views/admin/penugasan.blade.php,
lalu uji form penerusan pengaduan dari Admin ke Tim Hukum.
