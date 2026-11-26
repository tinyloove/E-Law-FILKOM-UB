@extends('layouts.portal')

@section('title', 'Tim Pengaduan')

@section('content')
@php
    $total = $pengaduans->count();
    $sudah = $pengaduans->filter(fn ($p) => $p->penugasanTimHukum->isNotEmpty())->count();
    $belum = $total - $sudah;
@endphp

<div class="page-heading">
    <div>
        <p class="eyebrow">Admin Layanan Hukum</p>
        <h1>Tim Pengaduan</h1>
        <p class="subtitle">Kelola dan distribusikan pengaduan mahasiswa kepada Tim Hukum.</p>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-error">{{ $errors->first() }}</div>
@endif

<div class="statistics">
    <div class="stat-card">
        <div class="stat-icon purple">▤</div>
        <div>
            <div class="stat-number">{{ $total }}</div>
            <div class="stat-label">Total Pengaduan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">◷</div>
        <div>
            <div class="stat-number">{{ $belum }}</div>
            <div class="stat-label">Belum Ditugaskan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">➜</div>
        <div>
            <div class="stat-number">{{ $sudah }}</div>
            <div class="stat-label">Sudah Ditugaskan</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <p class="card-title">Daftar pengaduan</p>
            <p class="card-desc">Daftar pengaduan dan status penerusan kepada Tim Hukum.</p>
        </div>
        <div class="filters">
            <input type="search" id="searchComplaint" placeholder="Cari ID atau pelapor...">
            <select id="penugasanFilter">
                <option value="">Semua penugasan</option>
                <option value="belum">Belum ditugaskan</option>
                <option value="sudah">Sudah ditugaskan</option>
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
                    <th>Status Pengaduan</th>
                    <th>Penugasan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengaduans as $pengaduan)
                    @php $penugasan = $pengaduan->penugasanTimHukum->first(); @endphp
                    <tr class="complaint-row"
                        data-search="{{ strtolower($pengaduan->nomor_pengaduan . ' ' . $pengaduan->judul_pengaduan . ' ' . ($pengaduan->mahasiswa->pengguna->nama ?? '')) }}"
                        data-penugasan="{{ $penugasan ? 'sudah' : 'belum' }}">
                        <td>
                            <div class="cell-number">{{ $pengaduan->nomor_pengaduan }}</div>
                            <div class="cell-sub">
                                {{ \Carbon\Carbon::parse($pengaduan->tanggal_pengajuan)->locale('id')->translatedFormat('d F Y') }}
                            </div>
                        </td>
                        <td class="cell-bold">{{ $pengaduan->mahasiswa->pengguna->nama ?? '-' }}</td>
                        <td>{{ $pengaduan->kategori }}</td>
                        <td>
                            <span class="badge {{ $pengaduan->status === 'Diteruskan ke Tim Hukum' ? 'blue' : '' }}">
                                {{ $pengaduan->status }}
                            </span>
                        </td>
                        <td>
                            @if ($penugasan)
                                <span class="badge green">Sudah ditugaskan</span>
                                <div class="cell-sub" style="margin-top:5px;">
                                    {{ $penugasan->timHukum->nama ?? '-' }}
                                </div>
                            @else
                                <form action="{{ route('admin.pengaduan.teruskan', $pengaduan->id_pengaduan) }}"
                                      method="POST" class="assign-form">
                                    @csrf
                                    <select name="id_tim_hukum" required>
                                        <option value="">Pilih Tim Hukum</option>
                                        @foreach ($timHukums as $tim)
                                            <option value="{{ $tim->id_pengguna }}">{{ $tim->nama }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn">Teruskan</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="empty-state">Belum ada pengaduan.</td></tr>
                @endforelse

                <tr id="noResults" style="display:none;">
                    <td colspan="5" class="empty-state">Pengaduan tidak ditemukan.</td>
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
        const filter = document.getElementById('penugasanFilter');
        const rows = document.querySelectorAll('.complaint-row');
        const none = document.getElementById('noResults');

        function apply() {
            const q = search.value.toLowerCase().trim();
            const f = filter.value;
            let visible = 0;
            rows.forEach(function (row) {
                const ok = row.dataset.search.includes(q) && (f === '' || row.dataset.penugasan === f);
                row.style.display = ok ? '' : 'none';
                if (ok) visible++;
            });
            none.style.display = rows.length > 0 && visible === 0 ? '' : 'none';
        }
        search.addEventListener('input', apply);
        filter.addEventListener('change', apply);
    })();
</script>
@endpush