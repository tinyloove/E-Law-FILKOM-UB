@extends('layouts.portal')

@section('title', 'Daftar Tugas')

@section('content')
    <div class="tim-tugas">
        <div class="tim-tugas-heading">
            <p class="tim-tugas-eyebrow">Tim Hukum</p>
            <h1>Daftar Tugas</h1>
            <p>Kelola pengaduan yang ditugaskan dan siapkan rekomendasi.</p>
        </div>

        <section class="tim-tugas-banner" aria-labelledby="ringkasan-tugas">
            <div>
                <p class="tim-tugas-banner-label">E-Law · Tim Hukum</p>
                <h2 id="ringkasan-tugas">Ringkasan tugas</h2>
                <p>Pantau tugas yang menjadi tanggung jawabmu.</p>
            </div>

            <div class="tim-tugas-banner-total">
                <strong>{{ $jumlahAktif }}</strong>
                <span>kasus aktif</span>
            </div>
        </section>

        <section class="tim-tugas-stats" aria-label="Statistik tugas">
            <div class="tim-tugas-stat">
                <span>Kasus aktif</span>
                <strong>{{ $jumlahAktif }}</strong>
            </div>

            <div class="tim-tugas-stat">
                <span>Perlu perhatian</span>
                <strong>{{ $mendekatiTenggat }}</strong>
                <small>Berjalan 5 hari atau lebih</small>
            </div>

            <div class="tim-tugas-stat">
                <span>Selesai bulan ini</span>
                <strong>{{ $selesaiBulanIni }}</strong>
            </div>

            <div class="tim-tugas-stat">
                <span>Baru hari ini</span>
                <strong>{{ $baruHariIni }}</strong>
            </div>
        </section>

        <section class="tim-tugas-section" aria-labelledby="kasus-aktif">
            <div class="tim-tugas-section-header">
                <div>
                    <h2 id="kasus-aktif">Kasus Aktif</h2>
                    <p>Daftar pengaduan yang ditugaskan kepadamu.</p>
                </div>
            </div>

            @if ($aktif->isEmpty())
                <div class="tim-tugas-empty">
                    <h3>Belum ada kasus aktif</h3>
                    <p>Tugas yang diteruskan kepadamu akan muncul di sini.</p>
                </div>
            @else
                <div class="tim-tugas-grid">
                    @foreach ($aktif as $tugas)
                        @php
                            $pengaduan = $tugas->pengaduan;
                            $perluRevisi = $tugas->status_penugasan === 'Perlu Revisi';
                            $namaMahasiswa = $pengaduan?->mahasiswa?->pengguna?->nama
                                ?? $pengaduan?->mahasiswa?->nama
                                ?? 'Nama tidak tersedia';
                        @endphp

                        <article class="tim-tugas-card">
                            <div class="tim-tugas-card-top">
                                <span class="tim-tugas-number">
                                    {{ $pengaduan?->nomor_pengaduan ?? 'Nomor tidak tersedia' }}
                                </span>

                                <span class="tim-tugas-badge {{ $perluRevisi ? 'tim-tugas-badge-revisi' : 'tim-tugas-badge-baru' }}">
                                    {{ $perluRevisi ? 'Perlu Revisi' : 'Baru' }}
                                </span>
                            </div>

                            <h3>{{ $pengaduan?->judul_pengaduan ?? 'Judul tidak tersedia' }}</h3>

                            <dl class="tim-tugas-details">
                                <div>
                                    <dt>Kategori</dt>
                                    <dd>{{ $pengaduan?->kategori ?? 'Tidak tersedia' }}</dd>
                                </div>
                                <div>
                                    <dt>Mahasiswa</dt>
                                    <dd>{{ $namaMahasiswa }}</dd>
                                </div>
                                <div>
                                    <dt>Tanggal penyerahan</dt>
                                    <dd>
                                        {{ $tugas->tanggal_penyerahan
                                            ? \Carbon\Carbon::parse($tugas->tanggal_penyerahan)->format('d-m-Y')
                                            : 'Tidak tersedia' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt>Status penugasan</dt>
                                    <dd>{{ $tugas->status_penugasan }}</dd>
                                </div>
                            </dl>

                            <a class="tim-tugas-card-link"href="{{ route('tim-hukum.tugas.detail', $tugas->id_penugasan) }}">
                                Detail tugas
                            </a>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
@endsection