@extends('layouts.portal')

@section('title', 'Detail Pengaduan')

@section('content')
    <div class="tim-tugas">
        <div class="tim-tugas-heading">
            <p class="tim-tugas-eyebrow">Admin Layanan Hukum</p>
            <h1>Detail Pengaduan</h1>
            <p>Periksa informasi dan perkembangan pengaduan mahasiswa.</p>
        </div>

        <p style="margin-bottom: 20px;">
            <a href="{{ route('admin.dashboard') }}">
                ← Kembali ke Pengaduan Masuk
            </a>
        </p>

       @if (
            in_array($pengaduan->status, ['Diajukan', 'Menunggu Pemeriksaan'], true)
            && !$pengaduan->penugasanTimHukum()->exists()
        )
            <section class="tim-tugas-card" style="margin-top: 20px;">
                <h2>Pemeriksaan Admin</h2>
                <p>Periksa data pengaduan, lalu pilih tindakan yang sesuai.</p>

                <form action="{{ route('admin.pengaduan.validasi', $pengaduan->id_pengaduan) }}"
                    method="POST">
                    @csrf

                    <button type="submit" style="margin-top: 20px;">
                        Nyatakan Data Valid
                    </button>
                </form>

                <form action="{{ route('admin.pengaduan.minta-perbaikan', $pengaduan->id_pengaduan) }}"
                    method="POST"
                    style="margin-top: 28px;">
                    @csrf

                    <label for="catatan_perbaikan">
                        <strong>Catatan perbaikan untuk mahasiswa</strong>
                    </label>

                    <textarea
                        id="catatan_perbaikan"
                        name="catatan_perbaikan"
                        rows="4"
                        maxlength="2000"
                        required
                        style="display: block; width: 100%; margin-top: 8px;"
                    >{{ old('catatan_perbaikan') }}</textarea>

                    @error('catatan_perbaikan')
                        <p style="color: #b42318;">{{ $message }}</p>
                    @enderror

                    <button type="submit" style="margin-top: 12px;">
                        Minta Perbaikan
                    </button>
                </form>
            </section>
        @endif

        <section class="tim-tugas-card">
            <div class="tim-tugas-card-top">
                <span class="tim-tugas-number">
                    {{ $pengaduan->nomor_pengaduan }}
                </span>

                <span class="tim-tugas-badge tim-tugas-badge-baru">
                    {{ $pengaduan->status }}
                </span>
            </div>

            <h2>{{ $pengaduan->judul_pengaduan ?: 'Judul tidak tersedia' }}</h2>

            <dl class="tim-tugas-details">
                <div>
                    <dt>Mahasiswa</dt>
                    <dd>
                        {{ $pengaduan->mahasiswa?->pengguna?->nama
                            ?? $pengaduan->mahasiswa?->nama
                            ?? 'Nama tidak tersedia' }}
                    </dd>
                </div>

                <div>
                    <dt>Kategori</dt>
                    <dd>{{ $pengaduan->kategori }}</dd>
                </div>

                <div>
                    <dt>Tanggal pengajuan</dt>
                    <dd>
                        {{ \Carbon\Carbon::parse($pengaduan->tanggal_pengajuan)->format('d-m-Y') }}
                    </dd>
                </div>
            </dl>

            <h3>Informasi permasalahan</h3>
            <p style="white-space: pre-line;">{{ $pengaduan->informasi_permasalahan ?: 'Tidak tersedia.' }}</p>

            <h3>Kronologi kejadian</h3>
            <p style="white-space: pre-line;">{{ $pengaduan->kronologi }}</p>
        </section>

        <section class="tim-tugas-card" style="margin-top: 20px;">
            <h2>Bukti Pengaduan</h2>

            @forelse ($pengaduan->buktiPengaduan as $bukti)
                <p><a href="{{ route('admin.bukti.lihat', [$pengaduan->id_pengaduan, $bukti->id_bukti]) }}" target="_blank" rel="noopener">{{ $bukti->nama_file }}</a></p>
            @empty
                <p>Belum ada bukti yang dilampirkan.</p>
            @endforelse
        </section>

        <section class="tim-tugas-card" style="margin-top: 20px;">
            <h2>Riwayat Pengaduan</h2>

            @forelse ($pengaduan->riwayatPengaduan->sortByDesc('waktu_perubahan') as $riwayat)
                <div style="padding: 12px 0; border-bottom: 1px solid #e9e3e7;">
                    <strong>{{ $riwayat->status_baru }}</strong>
                    <p>
                        {{ \Carbon\Carbon::parse($riwayat->waktu_perubahan)->format('d-m-Y H:i') }}
                    </p>
                </div>
            @empty
                <p>Belum ada riwayat pengaduan.</p>
            @endforelse
        </section>

        <p style="margin-top: 20px;">
            <a class="tim-tugas-card-link" href="{{ route('admin.penugasan') }}">
                Buka halaman penugasan Tim Hukum →
            </a>
        </p>
    </div>
@endsection