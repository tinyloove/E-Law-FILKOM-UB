@extends('layouts.portal')

@section('title', 'Perbaikan Pengaduan')

@section('content')
    <div class="tim-tugas">
        <div class="tim-tugas-heading">
            <p class="tim-tugas-eyebrow">Portal Mahasiswa</p>
            <h1>Perbaikan Pengaduan</h1>
            <p>Perbarui pengaduan sesuai catatan dari Admin Layanan Hukum.</p>
        </div>

        <p style="margin-bottom: 20px;">
            <a href="{{ route('mahasiswa.pengaduan.detail', $pengaduan->id_pengaduan) }}">
                ← Kembali ke Detail Pengaduan
            </a>
        </p>

        <section class="tim-tugas-card">
            <span class="tim-tugas-number">
                {{ $pengaduan->nomor_pengaduan }}
            </span>

            <h2>Catatan dari Admin</h2>
            <p style="white-space: pre-line;">
                {{ $permintaanPerbaikan?->keterangan ?? 'Tidak ada catatan yang tersedia.' }}
            </p>
        </section>

        <section class="tim-tugas-card" style="margin-top: 20px;">
            <h2>Formulir Perbaikan</h2>

            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>Periksa kembali isian berikut:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('mahasiswa.pengaduan.perbaikan.simpan', $pengaduan->id_pengaduan) }}"
                  method="POST">
                @csrf

                <div style="margin-top: 20px;">
                    <label for="kategori"><strong>Kategori permasalahan</strong></label>
                    <select id="kategori"
                            name="kategori"
                            class="form-control"
                            required
                            style="display: block; width: 100%; margin-top: 8px;">
                        <option value="">Pilih kategori permasalahan</option>

                        @foreach (['Akademik', 'Administrasi', 'Fasilitas', 'Etika dan Perilaku', 'Lainnya'] as $kategori)
                            <option value="{{ $kategori }}"
                                {{ old('kategori', $pengaduan->kategori) === $kategori ? 'selected' : '' }}>
                                {{ $kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-top: 20px;">
                    <label for="judul_pengaduan"><strong>Judul pengaduan</strong></label>
                    <input id="judul_pengaduan"
                           name="judul_pengaduan"
                           type="text"
                           class="form-control"
                           maxlength="150"
                           value="{{ old('judul_pengaduan', $pengaduan->judul_pengaduan) }}"
                           required
                           style="display: block; width: 100%; margin-top: 8px;">
                </div>

                <div style="margin-top: 20px;">
                    <label for="informasi_permasalahan"><strong>Informasi permasalahan</strong></label>
                    <textarea id="informasi_permasalahan"
                              name="informasi_permasalahan"
                              rows="5"
                              required
                              style="display: block; width: 100%; margin-top: 8px;">{{ old('informasi_permasalahan', $pengaduan->informasi_permasalahan) }}</textarea>
                </div>

                <div style="margin-top: 20px;">
                    <label for="kronologi"><strong>Kronologi kejadian</strong></label>
                    <textarea id="kronologi"
                              name="kronologi"
                              rows="6"
                              required
                              style="display: block; width: 100%; margin-top: 8px;">{{ old('kronologi', $pengaduan->kronologi) }}</textarea>
                </div>

                <button type="submit" style="margin-top: 20px;">
                    Kirim Perbaikan
                </button>
            </form>
        </section>
    </div>
@endsection