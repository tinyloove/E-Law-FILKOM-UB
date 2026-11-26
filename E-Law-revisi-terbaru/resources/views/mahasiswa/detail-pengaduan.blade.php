<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengaduan | E-Law</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #F7F5F6;
            color: #222;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 35px 25px;
        }

        .back-link {
            display: inline-block;
            color: #6A1A4D;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .heading {
            margin-bottom: 25px;
        }

        .heading p {
            color: #6A1A4D;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }

        .heading h1 {
            font-size: 28px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .heading span {
            color: #8290A3;
            font-size: 13px;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: 9px;
            margin-bottom: 20px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, .08);
        }

        .card h2 {
            font-size: 16px;
            margin-bottom: 20px;
            color: #6A1A4D;
        }

        .information {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        .info-item label {
            display: block;
            font-size: 11px;
            color: #8793A3;
            margin-bottom: 7px;
        }

        .info-item p {
            font-size: 13px;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            background: #FFF2E2;
            color: #B96C00;
            border-radius: 20px;
            font-size: 11px;
        }

        .description {
            font-size: 13px;
            line-height: 1.8;
            color: #555;
            white-space: pre-line;
        }

        .chronology {
            font-size: 13px;
            line-height: 1.8;
            color: #555;
            white-space: pre-line;
        }

        .evidence-item,
        .history-item {
            padding: 13px;
            border: 1px solid #E5E5E5;
            border-radius: 7px;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .evidence-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .evidence-description,
        .history-date {
            color: #8793A3;
            margin-top: 6px;
        }

        .evidence-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .evidence-link {
            padding: 9px 13px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
        }

        .evidence-view {
            background: #6A1A4D;
            color: white;
        }

        .evidence-download {
            background: #F1A61F;
            color: #222;
        }

        .empty {
            color: #8793A3;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            .information {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 25px 15px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="{{ route('mahasiswa.dashboard') }}" class="back-link">
            ← Kembali ke Dashboard
        </a>

        <div class="heading">
            <p>PORTAL MAHASISWA</p>
            <h1>Detail Pengaduan</h1>
            <span>Informasi lengkap mengenai pengaduan yang telah kamu ajukan.</span>
        </div>

        @if (session('success'))
            <div class="card" role="status">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if ($pengaduan->status === 'Perlu Dilengkapi/Diperbaiki')
            <div class="card">
                <h2>Pengaduan Perlu Diperbaiki</h2>
                <p class="description">
                    Admin telah meminta perbaikan. Buka formulir untuk melihat catatan
                    dan memperbarui pengaduanmu.
                </p>

                <a
                    href="{{ route('mahasiswa.pengaduan.perbaikan', $pengaduan->id_pengaduan) }}"
                    class="evidence-link evidence-view"
                    style="display: inline-block; margin-top: 15px;"
                >
                    Lihat Catatan dan Perbaiki
                </a>
            </div>
        @endif

        <!-- INFORMASI PENGADUAN -->
        <div class="card">
            <h2>Informasi Pengaduan</h2>

            <div class="information">
                <div class="info-item">
                    <label>Nomor Pengaduan</label>
                    <p>{{ $pengaduan->nomor_pengaduan }}</p>
                </div>

                <div class="info-item">
                    <label>Kategori</label>
                    <p>{{ $pengaduan->kategori }}</p>
                </div>

                <div class="info-item">
                    <label>Judul Pengaduan</label>
                    <p>{{ $pengaduan->judul_pengaduan ?: '-' }}</p>
                </div>

                <div class="info-item">
                    <label>Tanggal Pengajuan</label>
                    <p>
                        {{ \Carbon\Carbon::parse($pengaduan->tanggal_pengajuan)->translatedFormat('d F Y') }}
                    </p>
                </div>

                <div class="info-item">
                    <label>Status Pengaduan</label>
                    <span class="status">{{ $pengaduan->status }}</span>
                </div>
            </div>
        </div>

        <!-- INFORMASI PERMASALAHAN -->
        <div class="card">
            <h2>Informasi Permasalahan</h2>

            <p class="description">
                {{ $pengaduan->informasi_permasalahan ?: 'Tidak ada informasi permasalahan yang dicantumkan.' }}
            </p>
        </div>

        <!-- KRONOLOGI -->
        <div class="card">
            <h2>Kronologi Pengaduan</h2>

            <p class="chronology">
                {{ $pengaduan->kronologi }}
            </p>
        </div>

        <!-- BUKTI PENGADUAN -->
        <div class="card">
            <h2>Bukti Pengaduan</h2>

            @forelse ($pengaduan->buktiPengaduan as $bukti)
                <div class="evidence-item">
                    <div>
                        <strong>📄 {{ $bukti->nama_file }}</strong>
                        <p class="evidence-description">
                            Dokumen bukti pengaduan
                        </p>
                    </div>

                    <div class="evidence-actions">
                        <a
                            href="{{ route('mahasiswa.bukti.lihat', [
                                'pengaduanId' => $pengaduan->id_pengaduan,
                                'buktiId' => $bukti->id_bukti
                            ]) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="evidence-link evidence-view"
                        >
                            Lihat Bukti
                        </a>

                        <a
                            href="{{ route('mahasiswa.bukti.unduh', [
                                'pengaduanId' => $pengaduan->id_pengaduan,
                                'buktiId' => $bukti->id_bukti
                            ]) }}"
                            class="evidence-link evidence-download"
                        >
                            Unduh Bukti
                        </a>
                    </div>
                </div>
            @empty
                <p class="empty">Belum ada bukti yang dilampirkan.</p>
            @endforelse
        </div>

        <!-- RIWAYAT STATUS PENGADUAN -->
        <div class="card">
            <h2>Riwayat Status Pengaduan</h2>

            @forelse ($pengaduan->riwayatPengaduan->sortByDesc('waktu_perubahan') as $riwayat)
                <div class="history-item">
                    <strong>{{ $riwayat->status_baru }}</strong>

                    <p class="history-date">
                        {{ \Carbon\Carbon::parse($riwayat->waktu_perubahan)->format('d-m-Y H:i') }}
                    </p>
                </div>
            @empty
                <p class="empty">Belum ada riwayat status pengaduan.</p>
            @endforelse
        </div>
    </div>
</body>
</html>