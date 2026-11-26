@extends('layouts.portal')

@section('title', 'Pengaduan Masuk')
@section('topbar_search', 'Cari pengaduan...')

@section('content')
@php
    // Tampilkan pengaduan yang masih memerlukan tindakan admin.
    $perluTindakan = $pengaduans->whereIn('status', [
        'Diajukan',
        'Menunggu Pemeriksaan',
        'Perlu Dilengkapi/Diperbaiki',
    ]);

    $warnaStatus = fn ($status) => match ($status) {
        'Diteruskan ke Tim Hukum' => 'blue',
        'Disetujui' => 'green',
        'Ditolak' => 'red',
        default => '',
    };
@endphp

<div class="page-heading">
    <div>
        <p class="eyebrow">Admin Layanan Hukum</p>
        <h1>Pengaduan Masuk</h1>
        <p class="subtitle">Periksa kelengkapan dan validitas laporan mahasiswa.</p>
    </div>
</div>

<div class="statistics">
    <div class="stat-card">
        <div class="stat-icon purple">▤</div>
        <div>
            <div class="stat-number">{{ $pengaduanDiajukan }}</div>
            <div class="stat-label">Perlu Diperiksa</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon blue">◷</div>
        <div>
            <div class="stat-number">{{ $menungguPerbaikan }}</div>
            <div class="stat-label">Menunggu Perbaikan</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">✎</div>
        <div>
            <div class="stat-number">{{ $diteruskanBulanIni }}</div>
            <div class="stat-label">Diteruskan Bulan Ini</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <p class="card-title">Perlu pemeriksaan</p>
            <p class="card-desc">
                {{ $perluTindakan->count() }} pengaduan memerlukan tindakan.
            </p>
        </div>

        <div class="filters">
            <input
                type="search"
                id="searchComplaint"
                placeholder="Cari ID atau pelapor..."
            >

            <select id="statusFilter">
                <option value="">Semua status</option>

                @foreach ($perluTindakan->pluck('status')->unique() as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Pengaduan</th>
                    <th>Pelapor</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($perluTindakan as $pengaduan)
                    <tr
                        class="complaint-row"
                        data-search="{{ strtolower($pengaduan->nomor_pengaduan . ' ' . $pengaduan->judul_pengaduan . ' ' . ($pengaduan->mahasiswa->pengguna->nama ?? '')) }}"
                        data-status="{{ $pengaduan->status }}"
                    >
                        <td>
                            <div class="cell-number">
                                {{ $pengaduan->nomor_pengaduan }}
                            </div>

                            <div class="cell-sub">
                                {{ \Carbon\Carbon::parse($pengaduan->tanggal_pengajuan)->locale('id')->translatedFormat('d F Y') }}
                            </div>
                        </td>

                        <td class="cell-bold">
                            {{ $pengaduan->mahasiswa->pengguna->nama ?? '-' }}
                        </td>

                        <td>{{ $pengaduan->kategori }}</td>

                        <td>
                            <span class="badge {{ $warnaStatus($pengaduan->status) }}">
                                {{ $pengaduan->status }}
                            </span>
                        </td>

                        <td>
                            <a
                                class="link-action"
                                href="{{ route('admin.pengaduan.detail', $pengaduan->id_pengaduan) }}"
                            >
                                Periksa →
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            Tidak ada pengaduan yang perlu diperiksa.
                        </td>
                    </tr>
                @endforelse

                <tr id="noResults" style="display: none;">
                    <td colspan="5" class="empty-state">
                        Pengaduan tidak ditemukan.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const search = document.getElementById('searchComplaint');
        const status = document.getElementById('statusFilter');
        const rows = document.querySelectorAll('.complaint-row');
        const none = document.getElementById('noResults');

        function apply() {
            const q = search.value.toLowerCase().trim();
            const s = status.value;
            let visible = 0;

            rows.forEach(function (row) {
                const ok = row.dataset.search.includes(q)
                    && (s === '' || row.dataset.status === s);

                row.style.display = ok ? '' : 'none';

                if (ok) {
                    visible++;
                }
            });

            none.style.display = rows.length > 0 && visible === 0
                ? ''
                : 'none';
        }

        search.addEventListener('input', apply);
        status.addEventListener('change', apply);
    })();
</script>
@endpush