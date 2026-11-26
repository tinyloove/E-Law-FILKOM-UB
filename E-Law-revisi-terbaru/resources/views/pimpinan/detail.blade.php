@extends('layouts.portal')

@section('title', 'Detail Review Pengaduan')

@section('content')
    <div class="tim-tugas">
        <div class="tim-tugas-heading">
            <p class="tim-tugas-eyebrow">Pimpinan Fakultas</p>
            <h1>Detail Review</h1>
            <p>Periksa pengaduan dan hasil penanganan sebelum mengambil keputusan.</p>
        </div>

        <p>
            <a href="{{ route('pimpinan.dashboard') }}">
                ← Kembali ke Daftar Review
            </a>
        </p>

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Keputusan belum dapat disimpan:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="tim-tugas-card">
            <span class="tim-tugas-number">
                {{ $pengaduan->nomor_pengaduan }}
            </span>

            <h2>{{ $pengaduan->judul_pengaduan }}</h2>

            <dl class="tim-tugas-details">
                <div>
                    <dt>Kategori</dt>
                    <dd>{{ $pengaduan->kategori }}</dd>
                </div>

                <div>
                    <dt>Mahasiswa</dt>
                    <dd>
                        {{ $pengaduan->mahasiswa?->pengguna?->nama
                            ?? $pengaduan->mahasiswa?->nama
                            ?? 'Nama tidak tersedia' }}
                    </dd>
                </div>
            </dl>

            <h3>Informasi permasalahan</h3>
            <p>{{ $pengaduan->informasi_permasalahan }}</p>

            <h3>Kronologi kejadian</h3>
            <p>{{ $pengaduan->kronologi }}</p>
        </section>

        <section class="tim-tugas-card" style="margin-top: 20px;">
            <h2>Bukti Pengaduan</h2>
            @forelse ($pengaduan->buktiPengaduan as $bukti)
                <p><a href="{{ route('pimpinan.bukti.lihat', [$pengaduan->id_pengaduan, $bukti->id_bukti]) }}" target="_blank" rel="noopener">{{ $bukti->nama_file }}</a></p>
            @empty
                <p>Belum ada bukti yang dilampirkan.</p>
            @endforelse
        </section>

        <section class="tim-tugas-card" style="margin-top: 20px;">
            <h2>Hasil penanganan Tim Hukum</h2>

            @if ($hasilPenanganan)
                <p>
                    <strong>Disusun oleh:</strong>
                    {{ $hasilPenanganan->timHukum?->nama ?? 'Tidak tersedia' }}
                </p>

                <h3>Hasil analisis</h3>
                <p>{{ $hasilPenanganan->hasil_analisis }}</p>

                <h3>Rekomendasi penanganan</h3>
                <p>{{ $hasilPenanganan->rekomendasi_penanganan }}</p>
            @else
                <p>Hasil penanganan belum tersedia.</p>
            @endif
        </section>

        @if ($hasilPenanganan)
            <section class="tim-tugas-card" style="margin-top: 20px;">
                <h2>Keputusan Pimpinan</h2>
                <p>Pilih keputusan dan isi catatan arahan.</p>

                <form action="{{ route('pimpinan.pengaduan.putuskan', $pengaduan->id_pengaduan) }}"
                      method="POST">
                    @csrf

                    <div style="margin-top: 20px;">
                        <label for="status_keputusan">
                            <strong>Keputusan</strong>
                        </label>

                        <select id="status_keputusan"
                                name="status_keputusan"
                                required
                                style="display: block; width: 100%; margin-top: 8px; padding: 12px;">
                            <option value="">Pilih keputusan</option>
                            <option value="Setuju" {{ old('status_keputusan') === 'Setuju' ? 'selected' : '' }}>
                                Setuju
                            </option>
                            <option value="Ditolak" {{ old('status_keputusan') === 'Ditolak' ? 'selected' : '' }}>
                                Ditolak
                            </option>
                            <option value="Perlu Revisi" {{ old('status_keputusan') === 'Perlu Revisi' ? 'selected' : '' }}>
                                Perlu Revisi
                            </option>
                        </select>
                    </div>

                    <div style="margin-top: 20px;">
                        <label for="catatan_arahan">
                            <strong>Catatan arahan *</strong>
                        </label>

                        <textarea
                            id="catatan_arahan"
                            name="catatan_arahan" required
                            rows="5"
                            style="display: block; width: 100%; margin-top: 8px;"
                        >{{ old('catatan_arahan') }}</textarea>

                        <small>Catatan wajib diisi untuk setiap keputusan.</small>
                    </div>

                    <button type="submit" style="margin-top: 20px;">
                        Kirim keputusan
                    </button>
                </form>
            </section>
        @endif
    </div>
@endsection