@extends('layouts.portal')

@section('title', 'Pengaduan Saya')

@section('content')
<div class="page-heading">
    <div>
        <p class="eyebrow">Portal Mahasiswa</p>
        <h1>Pengaduan Saya</h1>
        <p class="subtitle">Pantau seluruh laporan dan perkembangan penanganannya</p>
    </div>
    <a href="{{ route('mahasiswa.pengaduan.create') }}" class="btn">＋ Ajukan Pengaduan</a>
</div>

<div class="statistics">
    <div class="stat-card">
        <div class="stat-icon purple">▤</div>
        <div>
            <div class="stat-number">{{ $totalPengaduan }}</div>
            <div class="stat-label">Total Pengaduan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">◷</div>
        <div>
            <div class="stat-number">{{ $pengaduanDiajukan }}</div>
            <div class="stat-label">Laporan Diajukan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">✎</div>
        <div>
            <div class="stat-number">{{ $pengaduanLainnya }}</div>
            <div class="stat-label">Status Lainnya</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <p class="card-title">Riwayat pengaduan</p>
            <p class="card-desc">Semua laporan yang pernah Anda ajukan.</p>
        </div>
        <div class="filters">
            <input type="search" id="searchComplaint" placeholder="⌕ Cari pengaduan...">
            <select id="statusFilter">
                <option value="">Semua status</option>
                @foreach ($pengaduans->pluck('status')->unique() as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @forelse ($pengaduans as $pengaduan)
        <a href="{{ route('mahasiswa.pengaduan.detail', $pengaduan->id_pengaduan) }}"
           class="list-item complaint-item"
           data-search="{{ strtolower($pengaduan->nomor_pengaduan . ' ' . $pengaduan->judul_pengaduan . ' ' . $pengaduan->kategori) }}"
           data-status="{{ $pengaduan->status }}">
            <div class="doc-icon">▤</div>
            <div class="list-info">
                <h4>{{ $pengaduan->nomor_pengaduan }}</h4>
                <p class="strong">{{ $pengaduan->judul_pengaduan ?: $pengaduan->kategori }}</p>
                <p>▢ {{ \Carbon\Carbon::parse($pengaduan->tanggal_pengajuan)->locale('id')->translatedFormat('d F Y') }}</p>
            </div>
            <span class="badge" style="margin-left:auto;">{{ $pengaduan->status }}</span>
        </a>
    @empty
        <div class="list-item">
            <div class="list-info">
                <h4>Belum ada pengaduan</h4>
                <p>Pengaduan yang kamu ajukan akan muncul di sini.</p>
            </div>
        </div>
    @endforelse

    <div id="noResults" class="empty-state" style="display:none;">
        Pengaduan tidak ditemukan. Coba gunakan kata kunci atau status lainnya.
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const search = document.getElementById('searchComplaint');
        const status = document.getElementById('statusFilter');
        const items = document.querySelectorAll('.complaint-item');
        const none = document.getElementById('noResults');

        function apply() {
            const q = search.value.toLowerCase().trim();
            const s = status.value;
            let visible = 0;
            items.forEach(function (item) {
                const ok = item.dataset.search.includes(q) && (s === '' || item.dataset.status === s);
                item.style.display = ok ? 'flex' : 'none';
                if (ok) visible++;
            });
            none.style.display = items.length > 0 && visible === 0 ? 'block' : 'none';
        }
        search.addEventListener('input', apply);
        status.addEventListener('change', apply);
    })();
</script>
@endpush