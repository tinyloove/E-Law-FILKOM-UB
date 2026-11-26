@php
    $user = auth()->user();
    $role = (int) $user->id_role;

    $roleLabel = [
        1 => 'Mahasiswa',
        2 => 'Admin Layanan Hukum',
        3 => 'Tim Hukum',
        4 => 'Pimpinan Fakultas',
    ][$role] ?? '';

    $menus = match ($role) {
        1 => [
            ['Pengaduan Saya', route('mahasiswa.dashboard'), ['mahasiswa.dashboard', 'mahasiswa.pengaduan.detail'], '▦'],
            ['Ajukan Pengaduan', route('mahasiswa.pengaduan.create'), ['mahasiswa.pengaduan.create'], '＋'],
            ['Pusat Bantuan', '#', [], '☏'],
        ],
        2 => [
            ['Perlu Diperiksa', route('admin.dashboard'), ['admin.dashboard', 'admin.pengaduan.*'], '▤'],
            ['Tim Pengaduan', route('admin.penugasan'), ['admin.penugasan*'], '☷'],
            ['Pusat Bantuan', '#', [], '☏'],
        ],
        3 => [
            ['Daftar Tugas', route('tim-hukum.dashboard'), ['tim-hukum.dashboard'], '▤'],
            ['Penanganan', '#', [], '☷'],
            ['Pusat Bantuan', '#', [], '☏'],
        ],
        4 => [
            ['Review Pengaduan', route('pimpinan.dashboard'), ['pimpinan.dashboard', 'pimpinan.pengaduan.*'], '▤'],
        ],
        default => [],
    };

    if (in_array($role, [1, 2, 3, 4], true)) {
        $menus[] = ['Notifikasi', route('notifikasi.index'), ['notifikasi.*'], '✉'];
    }
@endphp

<aside class="sidebar">
    <div class="brand">
        <img src="{{ asset('images/logo-elaw.png') }}" alt="Logo E-Law">
        <div>
            <h2>E - Law</h2>
            <p>Fakultas Ilmu Komputer</p>
        </div>
    </div>

    <nav class="menu">
        @foreach ($menus as [$label, $url, $patterns, $icon])
            @if ($role === 3 && $url === '#')
                <span class="menu-disabled" aria-disabled="true">
                    <span class="menu-icon">{{ $icon }}</span>
                    <span>{{ $label }}</span>
                </span>
            @else
                <a href="{{ $url }}"
                   class="{{ count($patterns) && request()->routeIs(...$patterns) ? 'active' : '' }}">
                    <span class="menu-icon">{{ $icon }}</span>
                    <span>{{ $label }}</span>
                </a>
            @endif
        @endforeach
    </nav>

    <div class="sidebar-bottom">
        <div class="profile">
            <div class="profile-avatar">{{ strtoupper(substr($user->nama, 0, 1)) }}</div>
            <div class="profile-info">
                <h4>{{ $user->nama }}</h4>
                <p>{{ $roleLabel }}</p>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn" title="Keluar">⇥</button>
        </form>
    </div>
</aside>