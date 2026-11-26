@extends('layouts.portal')

@section('title', 'Review Pengaduan')

@section('content')
    <div class="tim-tugas">
        <div class="tim-tugas-heading">
            <p class="tim-tugas-eyebrow">Pimpinan Fakultas</p>
            <h1>Review Pengaduan</h1>
            <p>Tinjau hasil penanganan dan rekomendasi dari Tim Hukum.</p>
        </div>

        <section class="tim-tugas-banner">
            <div>
                <p class="tim-tugas-banner-label">E-Law · Pimpinan Fakultas</p>
                <h2>Menunggu review</h2>
                <p>Pengaduan yang siap ditinjau akan tampil di bawah ini.</p>
            </div>

            <div class="tim-tugas-banner-total">
                <strong>{{ $pengaduans->count() }}</strong>
                <span>pengaduan</span>
            </div>
        </section>

        <section class="tim-tugas-section" style="margin-top: 28px;">
            <div class="tim-tugas-section-header">
                <h2>Daftar Review</h2>
                <p>Pilih pengaduan untuk melihat hasil penanganannya.</p>
            </div>

            @if ($pengaduans->isEmpty())
                <div class="tim-tugas-empty">
                    <h3>Belum ada pengaduan untuk direview</h3>
                    <p>Pengaduan dari Tim Hukum akan muncul di sini.</p>
                </div>
            @else
                <div class="tim-tugas-grid">
                    @foreach ($pengaduans as $pengaduan)
                        <article class="tim-tugas-card">
                            <div class="tim-tugas-card-top">
                                <span class="tim-tugas-number">
                                    {{ $pengaduan->nomor_pengaduan }}
                                </span>

                                <span class="tim-tugas-badge tim-tugas-badge-baru">
                                    Menunggu Review
                                </span>
                            </div>

                            <h3>{{ $pengaduan->judul_pengaduan }}</h3>

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
                                    <dt>Tanggal pengajuan</dt>
                                    <dd>
                                        {{ \Carbon\Carbon::parse($pengaduan->tanggal_pengajuan)->format('d-m-Y') }}
                                    </dd>
                                </div>
                            </dl>

                            <a class="tim-tugas-card-link"
                               href="{{ route('pimpinan.pengaduan.detail', $pengaduan->id_pengaduan) }}">
                                Tinjau pengaduan
                            </a>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
@endsection