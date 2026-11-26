@extends('layouts.portal')

@section('title', 'Detail Tugas')

@section('content')
    <div class="tim-tugas">
        <div class="tim-tugas-heading">
            <p class="tim-tugas-eyebrow">Tim Hukum</p>
            <h1>Detail Tugas</h1>
            <p>Pelajari pengaduan dan siapkan hasil penanganan.</p>
        </div>

        <p>
            <a href="{{ route('tim-hukum.dashboard') }}">
                ← Kembali ke Daftar Tugas
            </a>
        </p>

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Data belum dapat disimpan:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($keputusanRevisi)
            <section class="tim-tugas-card" style="margin-top: 20px;">
                <h2>Catatan revisi dari pimpinan</h2>
                <p>{{ $keputusanRevisi->catatan_arahan }}</p>
            </section>
        @endif

        <section class="tim-tugas-card">
            <div class="tim-tugas-card-top">
                <span class="tim-tugas-number">
                    {{ $pengaduan->nomor_pengaduan }}
                </span>

                <span class="tim-tugas-badge tim-tugas-badge-baru">
                    {{ $tugas->status_penugasan }}
                </span>
            </div>

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

                <div>
                    <dt>Tanggal penyerahan</dt>
                    <dd>
                        {{ \Carbon\Carbon::parse($tugas->tanggal_penyerahan)->format('d-m-Y') }}
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
                <p><a href="{{ route('tim-hukum.bukti.lihat', [$tugas->id_penugasan, $bukti->id_bukti]) }}" target="_blank" rel="noopener">{{ $bukti->nama_file }}</a></p>
            @empty
                <p>Belum ada bukti yang dilampirkan.</p>
            @endforelse
        </section>

        <section class="tim-tugas-card" style="margin-top: 20px;">
            <h2>Hasil penanganan</h2>
            <p>Isi hasil analisis dan rekomendasi untuk pengaduan ini.</p>

            <form action="{{ route('tim-hukum.tugas.simpan', $tugas->id_penugasan) }}"
                  method="POST">
                @csrf

                <div style="margin-top: 20px;">
                    <label for="hasil_analisis">
                        <strong>Hasil analisis</strong>
                    </label>
                    <textarea
                        id="hasil_analisis"
                        name="hasil_analisis"
                        rows="6"
                        required
                        style="display: block; width: 100%; margin-top: 8px;"
                    >{{ old('hasil_analisis') }}</textarea>
                </div>

                <div style="margin-top: 20px;">
                    <label for="rekomendasi_penanganan">
                        <strong>Rekomendasi penanganan</strong>
                    </label>
                    <textarea
                        id="rekomendasi_penanganan"
                        name="rekomendasi_penanganan"
                        rows="6"
                        required
                        style="display: block; width: 100%; margin-top: 8px;"
                    >{{ old('rekomendasi_penanganan') }}</textarea>
                </div>

                <button type="submit" style="margin-top: 20px;">
                    Kirim hasil penanganan
                </button>
            </form>
        </section>
    </div>
@endsection