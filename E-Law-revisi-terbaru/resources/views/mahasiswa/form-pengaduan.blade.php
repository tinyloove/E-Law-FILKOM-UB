@extends('layouts.portal')

@section('title', 'Ajukan Pengaduan')

@section('content')
<div class="page-heading">
    <div>
        <p class="eyebrow">Portal Mahasiswa</p>
        <h1>Ajukan Pengaduan</h1>
        <p class="subtitle">Sampaikan permasalahan Anda melalui formulir pengaduan berikut.</p>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-error">Terdapat kesalahan pada formulir. Silakan periksa kembali isian Anda.</div>
@endif

<form action="{{ route('mahasiswa.pengaduan.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-grid">

        <div class="card">
            <div class="form-card-header">
                <h3>Informasi pengaduan</h3>
                <p>Pastikan informasi yang Anda masukkan benar dan dapat dipertanggungjawabkan.</p>
            </div>

            <div class="form-card-body">

                <div class="form-group">
                    <label for="kategori">Kategori permasalahan <span class="required">*</span></label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">Pilih kategori permasalahan</option>
                        @foreach (['Akademik', 'Administrasi', 'Fasilitas', 'Etika dan Perilaku', 'Lainnya'] as $kategori)
                            <option value="{{ $kategori }}" {{ old('kategori') === $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="judul_pengaduan">Judul pengaduan <span class="required">*</span></label>
                    <input type="text" name="judul_pengaduan" id="judul_pengaduan" class="form-control"
                           placeholder="Masukkan judul pengaduan" maxlength="150"
                           value="{{ old('judul_pengaduan') }}" required>
                    @error('judul_pengaduan') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="informasi_permasalahan">Informasi permasalahan <span class="required">*</span></label>
                    <textarea name="informasi_permasalahan" id="informasi_permasalahan" class="form-control"
                              placeholder="Jelaskan secara singkat permasalahan yang Anda alami..." required>{{ old('informasi_permasalahan') }}</textarea>
                    <p class="form-hint">Berikan gambaran umum mengenai permasalahan yang ingin Anda laporkan.</p>
                    @error('informasi_permasalahan') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="kronologi">Kronologi kejadian <span class="required">*</span></label>
                    <textarea name="kronologi" id="kronologi" class="form-control"
                              placeholder="Ceritakan urutan kejadian secara jelas, mulai dari waktu, tempat, pihak yang terlibat, hingga permasalahan yang terjadi..." required>{{ old('kronologi') }}</textarea>
                    <p class="form-hint">Tuliskan kejadian secara berurutan agar pihak yang berwenang dapat memahami laporan Anda.</p>
                    @error('kronologi') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="bukti">Lampiran bukti pendukung <span class="required">*</span></label>
                    <input type="file" name="bukti" id="bukti" class="form-control" required accept=".pdf,.jpg,.jpeg,.png">
                    <p class="form-hint">Format file: PDF, JPG, JPEG, atau PNG. Maksimal ukuran file 5 MB. Lampiran wajib diisi.</p>
                    <p class="form-hint" id="namaFile">Belum ada file yang dipilih.</p>
                    @error('bukti') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn">Kirim Pengaduan</button>
                </div>

            </div>
        </div>

        <div class="card side-card">
            <div class="side-icon">⛨</div>
            <h3>Laporan Anda aman</h3>
            <p class="side-text">Identitas dan seluruh informasi pengaduan hanya dapat diakses oleh pihak yang berwenang.</p>

            <h4>Sebelum mengirim, pastikan:</h4>
            <ul>
                <li>Kronologi kejadian sudah lengkap.</li>
                <li>Gunakan bahasa yang jelas dan mudah dipahami.</li>
                <li>Lampirkan bukti yang relevan.</li>
                <li>Informasi yang diberikan dapat dipertanggungjawabkan.</li>
            </ul>
        </div>

    </div>
</form>
@endsection

@push('scripts')
<script>
    document.getElementById('bukti').addEventListener('change', function () {
        document.getElementById('namaFile').textContent =
            this.files.length ? 'File dipilih: ' + this.files[0].name : 'Belum ada file yang dipilih.';
    });
</script>
@endpush