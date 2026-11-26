
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tim Hukum | E-Law</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #6A1A4D;
            --primary-light: #7F285D;
            --primary-dark: #4D0031;
            --gold: #F1A61F;
            --background: #F7F5F6;
            --white: #FFFFFF;
            --text: #252333;
            --muted: #69778C;
            --muted-light: #A5AFBF;
            --border: #E8E3E6;
            --success: #25845D;
            --warning: #D99013;
            --danger: #C74343;
            --blue: #4776C5;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--background);
            color: var(--text);
            min-height: 100vh;
        }

        button,
        input {
            font: inherit;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */

        .sidebar {
            width: 250px;
            min-width: 250px;
            background: var(--primary);
            color: var(--white);
            padding: 28px 18px;
            display: flex;
            flex-direction: column;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 32px;
            border-bottom: 1px solid rgba(255,255,255,.16);
        }

        .brand-logo {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            background: var(--gold);
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 20px;
        }

        .brand-name {
            font-size: 21px;
            font-weight: 800;
            letter-spacing: .5px;
        }

        .brand-subtitle {
            font-size: 11px;
            margin-top: 4px;
            color: #E5D3DE;
        }

        .menu-label {
            margin: 30px 12px 13px;
            font-size: 10px;
            letter-spacing: 1.5px;
            font-weight: 700;
            color: #D9B9CB;
            text-transform: uppercase;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 14px;
            border-radius: 9px;
            font-size: 13px;
            color: #F0E6EC;
            transition: .2s;
        }

        .menu-item:hover {
            background: rgba(255,255,255,.10);
        }

        .menu-item.active {
            background: var(--primary-light);
            color: var(--white);
            font-weight: 700;
            box-shadow: inset 3px 0 0 var(--gold);
        }

        .menu-icon {
            width: 20px;
            text-align: center;
            font-size: 17px;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 25px;
        }

        .sidebar-info {
            padding: 15px;
            border-radius: 10px;
            background: rgba(255,255,255,.09);
            font-size: 12px;
            line-height: 1.6;
            color: #F0E6EC;
        }

        .sidebar-info strong {
            display: block;
            color: var(--gold);
            margin-bottom: 4px;
        }

        .logout-button {
            width: 100%;
            margin-top: 16px;
            padding: 12px;
            background: transparent;
            color: white;
            border: 1px solid rgba(255,255,255,.3);
            border-radius: 8px;
            text-align: left;
            cursor: pointer;
            font-size: 13px;
        }

        .logout-button:hover {
            background: rgba(255,255,255,.1);
        }

        /* MAIN CONTENT */

        .main-content {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            height: 82px;
            padding: 0 35px;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .breadcrumb {
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .breadcrumb span {
            color: var(--primary);
            font-weight: 700;
        }

        .page-title {
            font-size: 21px;
            font-weight: 750;
            color: var(--primary);
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .profile-avatar {
            width: 42px;
            height: 42px;
            background: #F3E5ED;
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            font-weight: 800;
        }

        .profile-name {
            font-size: 13px;
            font-weight: 700;
        }

        .profile-role {
            font-size: 11px;
            color: var(--muted);
            margin-top: 4px;
        }

        .content {
            padding: 30px 35px 40px;
            max-width: 1600px;
            margin: 0 auto;
        }

        .welcome-section {
            margin-bottom: 25px;
        }

        .welcome-section h2 {
            color: var(--text);
            font-size: 24px;
            margin-bottom: 8px;
        }

        .welcome-section p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        /* WELCOME BANNER */

        .welcome-banner {
            background: linear-gradient(
                135deg,
                var(--primary) 0%,
                var(--primary-dark) 100%
            );
            color: var(--white);
            padding: 27px 30px;
            border-radius: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            position: relative;
            overflow: hidden;
            margin-bottom: 28px;
        }

        .welcome-banner::after {
            content: "";
            position: absolute;
            width: 190px;
            height: 190px;
            border: 28px solid rgba(241,166,31,.13);
            border-radius: 50%;
            right: 55px;
            top: -95px;
        }

        .banner-content {
            position: relative;
            z-index: 1;
        }

        .banner-label {
            color: var(--gold);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.4px;
            margin-bottom: 12px;
        }

        .banner-content h2 {
            font-size: 23px;
            margin-bottom: 10px;
        }

        .banner-content p {
            color: #E7D9E1;
            font-size: 13px;
            line-height: 1.7;
            max-width: 600px;
        }

        .banner-decoration {
            position: relative;
            z-index: 1;
            width: 76px;
            height: 76px;
            flex-shrink: 0;
            background: rgba(241,166,31,.15);
            border: 1px solid rgba(241,166,31,.45);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 35px;
        }

        /* STATISTICS */

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 17px;
        }

        .section-heading h3 {
            font-size: 17px;
            color: var(--text);
        }

        .section-heading p {
            font-size: 12px;
            color: var(--muted);
            margin-top: 5px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 21px;
            min-width: 0;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(74,20,52,.07);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .icon-maroon {
            background: #F3E5ED;
            color: var(--primary);
        }

        .icon-gold {
            background: #FFF3D8;
            color: #B87A00;
        }

        .icon-blue {
            background: #E8EFFB;
            color: var(--blue);
        }

        .icon-green {
            background: #E3F4EB;
            color: var(--success);
        }

        .stat-number {
            font-size: 29px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 9px;
        }

        .stat-description {
            font-size: 11px;
            color: var(--muted);
        }

        .stat-description strong {
            color: var(--primary-light);
        }

        /* LOWER CONTENT */

        .bottom-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.65fr) minmax(260px, 1fr);
            gap: 20px;
        }

        .panel {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            min-width: 0;
        }

        .panel-header {
            padding: 21px 23px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .panel-header h3 {
            font-size: 15px;
            color: var(--text);
        }

        .panel-header p {
            font-size: 11px;
            color: var(--muted);
            margin-top: 5px;
        }

        .view-all {
            color: var(--primary);
            font-weight: 700;
            font-size: 12px;
            white-space: nowrap;
        }

        .view-all:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
        }

        th {
            text-align: left;
            background: #FBF9FA;
            padding: 14px 20px;
            font-size: 10px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid #F0ECEF;
            font-size: 12px;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #FCF9FB;
        }

        .case-id {
            font-weight: 700;
            color: var(--primary);
        }

        .case-title {
            font-weight: 700;
            color: var(--text);
            margin-bottom: 5px;
        }

        .case-category {
            font-size: 10px;
            color: var(--muted);
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        .status::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-pending {
            background: #FFF3D8;
            color: #A66B00;
        }

        .status-process {
            background: #E8EFFB;
            color: #3765AD;
        }

        .status-complete {
            background: #E3F4EB;
            color: #25845D;
        }

        /* ACTIVITY */

        .activity-list {
            padding: 8px 22px 18px;
        }

        .activity-item {
            display: flex;
            gap: 13px;
            padding: 17px 0;
            border-bottom: 1px solid #F0ECEF;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            flex-shrink: 0;
            background: #F3E5ED;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }

        .activity-title {
            font-size: 12px;
            font-weight: 700;
            line-height: 1.5;
            margin-bottom: 5px;
        }

        .activity-description {
            font-size: 11px;
            color: var(--muted);
            line-height: 1.6;
        }

        .activity-time {
            margin-top: 7px;
            font-size: 10px;
            color: var(--muted-light);
        }

        .empty-state {
            padding: 28px 20px;
            text-align: center;
            color: var(--muted);
            font-size: 12px;
        }

        .footer {
            padding: 24px 0 0;
            text-align: center;
            color: var(--muted-light);
            font-size: 11px;
        }

        /* RESPONSIVE */

        @media (max-width: 1100px) {
            .sidebar {
                width: 220px;
                min-width: 220px;
            }

            .topbar {
                padding: 0 25px;
            }

            .content {
                padding: 25px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .bottom-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                min-width: 0;
                padding: 18px;
            }

            .brand {
                padding-bottom: 18px;
            }

            .menu-label {
                margin-top: 20px;
            }

            .menu {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .sidebar-bottom {
                margin-top: 20px;
            }

            .sidebar-info {
                display: none;
            }

            .topbar {
                height: auto;
                min-height: 75px;
                padding: 15px 18px;
            }

            .page-title {
                font-size: 17px;
            }

            .profile-name {
                max-width: 120px;
                overflow-wrap: anywhere;
            }

            .content {
                padding: 22px 16px;
            }

            .welcome-section h2 {
                font-size: 21px;
            }

            .welcome-banner {
                padding: 22px;
            }

            .banner-content h2 {
                font-size: 19px;
            }

            .banner-decoration {
                display: none;
            }

            .stats-grid {
                gap: 12px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-number {
                font-size: 25px;
            }

            .stat-icon {
                width: 35px;
                height: 35px;
                font-size: 16px;
            }

            .section-heading h3 {
                font-size: 15px;
            }
        }

        @media (max-width: 380px) {
            .menu {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .profile-avatar {
                display: none;
            }
        }
    </style>
</head>

<body>
<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="brand">
            <div class="brand-logo">E</div>
            <div>
                <div class="brand-name">E-LAW</div>
                <div class="brand-subtitle">Sistem Layanan Hukum</div>
            </div>
        </div>

        <div class="menu-label">Menu Utama</div>

        <nav class="menu">
            <a href="{{ route('tim-hukum.dashboard') }}"
               class="menu-item active">
                <span class="menu-icon">▦</span>
                <span>Dashboard</span>
            </a>

            <a href="#pengaduan" class="menu-item">
                <span class="menu-icon">▤</span>
                <span>Daftar Pengaduan</span>
            </a>

            <a href="#aktivitas" class="menu-item">
                <span class="menu-icon">◷</span>
                <span>Aktivitas Terbaru</span>
            </a>
        </nav>

        <div class="menu-label">Akun</div>

        <nav class="menu">
            <a href="#profil" class="menu-item">
                <span class="menu-icon">♙</span>
                <span>Profil Saya</span>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="sidebar-info">
                <strong>Tim Hukum</strong>
                Kelola dan pantau penanganan pengaduan mahasiswa melalui sistem E-Law.
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">
                    ↪ &nbsp; Keluar dari Akun
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOPBAR -->
        <header class="topbar">
            <div>
                <div class="breadcrumb">
                    E-Law &nbsp; / &nbsp; <span>Dashboard</span>
                </div>
                <h1 class="page-title">Dashboard Tim Hukum</h1>
            </div>

            <div class="profile">
                <div class="profile-avatar">
                    {{ strtoupper(substr(auth()->user()->nama ?? 'T', 0, 1)) }}
                </div>

                <div>
                    <div class="profile-name">
                        {{ auth()->user()->nama ?? 'Tim Hukum' }}
                    </div>
                    <div class="profile-role">Tim Hukum</div>
                </div>
            </div>
        </header>

        <div class="content">

            <!-- WELCOME -->
            <section class="welcome-section">
                <h2>Selamat Datang, Tim Hukum!</h2>
                <p>
                    Pantau pengaduan dan kelola proses penanganan kasus
                    melalui dashboard E-Law.
                </p>
            </section>

            <!-- BANNER -->
            <section class="welcome-banner">
                <div class="banner-content">
                    <div class="banner-label">E-Law · Layanan Hukum Kampus</div>
                    <h2>Penanganan Pengaduan Mahasiswa</h2>
                    <p>
                        Pastikan setiap pengaduan ditinjau dan ditangani
                        secara profesional, transparan, serta sesuai prosedur
                        yang berlaku.
                    </p>
                </div>

                <div class="banner-decoration">⚖</div>
            </section>

            <!-- STATISTICS -->
            <section>
                <div class="section-heading">
                    <div>
                        <h3>Ringkasan Pengaduan</h3>
                        <p>Informasi singkat mengenai penanganan pengaduan.</p>
                    </div>
                </div>

                <div class="stats-grid">

                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-label">Total Pengaduan</div>
                            <div class="stat-icon icon-maroon">▤</div>
                        </div>

                        <div class="stat-number">
                            {{ $totalPengaduan ?? 0 }}
                        </div>

                        <div class="stat-description">
                            Seluruh pengaduan yang tercatat
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-label">Menunggu Penanganan</div>
                            <div class="stat-icon icon-gold">◷</div>
                        </div>

                        <div class="stat-number">
                            {{ $pengaduanMenunggu ?? 0 }}
                        </div>

                        <div class="stat-description">
                            <strong>Perlu ditinjau</strong> oleh tim
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-label">Dalam Proses</div>
                            <div class="stat-icon icon-blue">↻</div>
                        </div>

                        <div class="stat-number">
                            {{ $pengaduanDiproses ?? 0 }}
                        </div>

                        <div class="stat-description">
                            Pengaduan sedang ditangani
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-label">Selesai Ditangani</div>
                            <div class="stat-icon icon-green">✓</div>
                        </div>

                        <div class="stat-number">
                            {{ $pengaduanSelesai ?? 0 }}
                        </div>

                        <div class="stat-description">
                            Pengaduan yang telah diselesaikan
                        </div>
                    </div>

                </div>
            </section>

            <!-- TABLE AND ACTIVITY -->
            <div class="bottom-grid">

                <!-- RECENT COMPLAINTS -->
                <section class="panel" id="pengaduan">
                    <div class="panel-header">
                        <div>
                            <h3>Pengaduan Terbaru</h3>
                            <p>Daftar pengaduan yang masuk ke sistem.</p>
                        </div>
                    </div>

                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID Pengaduan</th>
                                    <th>Judul Pengaduan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse(($pengaduanTerbaru ?? []) as $pengaduan)
                                    <tr>
                                        <td class="case-id">
                                            {{ $pengaduan->id_pengaduan }}
                                        </td>

                                        <td>
                                            <div class="case-title">
                                                {{ $pengaduan->judul ?? 'Tanpa Judul' }}
                                            </div>

                                            <div class="case-category">
                                                {{ $pengaduan->kategori ?? 'Umum' }}
                                            </div>
                                        </td>

                                        <td>
                                            @php
                                                $status = strtolower(
                                                    $pengaduan->status ?? 'menunggu'
                                                );
                                            @endphp

                                            @if(in_array($status, ['selesai', 'diselesaikan']))
                                                <span class="status status-complete">
                                                    Selesai
                                                </span>
                                            @elseif(in_array($status, ['diproses', 'dalam proses', 'ditangani']))
                                                <span class="status status-process">
                                                    Diproses
                                                </span>
                                            @else
                                                <span class="status status-pending">
                                                    Menunggu
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">
                                            <div class="empty-state">
                                                Belum ada data pengaduan untuk ditampilkan.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- ACTIVITY -->
                <section class="panel" id="aktivitas">
                    <div class="panel-header">
                        <div>
                            <h3>Informasi Dashboard</h3>
                            <p>Informasi untuk tim hukum.</p>
                        </div>
                    </div>

                    <div class="activity-list">

                        <div class="activity-item">
                            <div class="activity-icon">⚖</div>
                            <div>
                                <div class="activity-title">
                                    Tinjau pengaduan masuk
                                </div>
                                <div class="activity-description">
                                    Periksa detail dan bukti yang disertakan
                                    dalam setiap pengaduan.
                                </div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-icon">▤</div>
                            <div>
                                <div class="activity-title">
                                    Perbarui status penanganan
                                </div>
                                <div class="activity-description">
                                    Pastikan perkembangan penanganan tercatat
                                    di dalam sistem.
                                </div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-icon">✓</div>
                            <div>
                                <div class="activity-title">
                                    Dokumentasikan hasil penanganan
                                </div>
                                <div class="activity-description">
                                    Catat hasil dan rekomendasi setelah
                                    penanganan selesai.
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

            </div>

            <footer class="footer">
                © {{ date('Y') }} E-Law · Sistem Layanan Hukum Kampus
            </footer>

        </div>
    </main>

</div>
</body>
</html>
