
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Law | Ruang Aman Untuk Didengar</title>

    <style>
        :root {
            --purple: #6A1A4D;
            --deep-purple: #4C0031;
            --yellow: #F1A61F;
            --cream: #F0E7DE;
            --white: #FFF9F6;
            --text: #3D2636;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            background: var(--cream);
            color: var(--text);
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        /* NAVIGATION */

        .navbar {
            position: sticky;
            top: 18px;
            z-index: 100;
            width: min(1120px, calc(100% - 48px));
            min-height: 62px;
            margin: 18px auto -24px;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            border-radius: 40px;
            background: rgba(255, 249, 246, .97);
            box-shadow: 0 8px 28px rgba(64, 26, 48, .12);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
            color: var(--purple);
        }

        .brand img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }

        .brand-name {
            font-size: 23px;
            font-weight: 800;
        }

        .brand-subtitle {
            margin-top: 1px;
            font-size: 10px;
            font-weight: 400;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-links > a:not(.nav-login) {
            color: #493642;
            font-size: 13px;
            transition: color .2s;
        }

        .nav-links > a:not(.nav-login):hover {
            color: var(--purple);
        }

        .nav-login {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 9px;
            min-width: 112px;
            min-height: 44px;
            padding: 12px 22px;
            border-radius: 12px;
            background: var(--purple);
            color: #fff !important;
            font-size: 14px;
            font-weight: 700;
            transition: background .2s, transform .2s;
        }

        .nav-login:hover {
            background: var(--deep-purple);
            transform: translateY(-1px);
        }

        /* HERO */

        .hero {
            position: relative;
            isolation: isolate;
            display: flex;
            align-items: center;
            width: calc(100% - 72px);
            max-width: 1500px;
            min-height: 620px;
            margin: 0 auto;
            padding: 110px 6% 190px;
            overflow: hidden;
            border-radius: 28px;
            background-color: var(--purple);
            background-image:
                linear-gradient(
                    100deg,
                    rgba(106, 26, 77, .94) 0%,
                    rgba(106, 26, 77, .82) 48%,
                    rgba(76, 0, 49, .76) 100%
                ),
                url("{{ asset('assets/Hero Image.png') }}");
            background-size: cover;
            background-position: center;
            color: white;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            width: 58%;
            max-width: 700px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            margin-bottom: 30px;
            padding: 12px 19px;
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 30px;
            background: rgba(255, 255, 255, .12);
            color: var(--yellow);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .hero h1 {
            max-width: 690px;
            margin-bottom: 25px;
            color: #fff;
            font-size: clamp(44px, 5.3vw, 76px);
            font-weight: 800;
            line-height: 1.08;
            letter-spacing: -2.8px;
        }

        .hero h1 span {
            color: var(--yellow);
        }

        .hero-description {
            max-width: 600px;
            margin-bottom: 30px;
            color: rgba(255, 255, 255, .9);
            font-size: 16px;
            line-height: 1.85;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 52px;
            padding: 14px 25px;
            border: 1px solid transparent;
            border-radius: 11px;
            font-size: 14px;
            font-weight: 800;
            transition: .2s;
        }

        .btn-yellow {
            background: var(--yellow);
            color: #321324;
        }

        .btn-yellow:hover {
            background: #ffba32;
            transform: translateY(-2px);
        }

        .btn-outline {
            border-color: rgba(255, 255, 255, .55);
            color: white;
            background: rgba(255, 255, 255, .04);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, .14);
        }

        /* HERO INFORMATION PANEL */

        .hero-info {
            position: absolute;
            z-index: 3;
            right: 0;
            bottom: 0;
            left: 0;
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            align-items: center;
            gap: 28px;
            min-height: 150px;
            padding: 28px 6%;
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 22px 22px 0 0;
            background: rgba(76, 0, 49, .58);
            backdrop-filter: blur(8px);
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, .88);
            font-size: 13px;
        }

        .info-icon {
            color: var(--yellow);
            font-size: 22px;
        }

        .privacy-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 18px;
            background: rgba(255, 255, 255, .14);
        }

        .privacy-card .shield {
            color: var(--yellow);
            font-size: 30px;
        }

        .privacy-card strong {
            display: block;
            margin-bottom: 4px;
            color: white;
            font-size: 12px;
        }

        .privacy-card p {
            color: rgba(255, 255, 255, .8);
            font-size: 9px;
        }

        /* GENERAL SECTIONS */

        .section {
            width: min(1200px, calc(100% - 64px));
            margin: 0 auto;
            padding: 100px 0;
        }

        .section-heading {
            max-width: 700px;
            margin: 0 auto 55px;
            text-align: center;
        }

        .section-label {
            display: inline-block;
            margin-bottom: 15px;
            color: var(--purple);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 4px;
        }

        .section-heading h2 {
            margin-bottom: 18px;
            color: var(--purple);
            font-size: clamp(32px, 4vw, 48px);
            line-height: 1.15;
        }

        .section-heading p {
            color: #746471;
            font-size: 15px;
            line-height: 1.85;
        }

        /* ABOUT */

        .about-layout {
            display: grid;
            grid-template-columns: .9fr 1.1fr;
            align-items: center;
            gap: 75px;
        }

        .about-title h2 {
            max-width: 450px;
            margin-bottom: 20px;
            color: var(--purple);
            font-size: clamp(36px, 4vw, 52px);
            line-height: 1.12;
        }

        .about-title p {
            color: #746471;
            font-size: 15px;
            line-height: 1.9;
        }

        .about-details {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 28px;
        }

        .about-item {
            padding: 25px 0;
            border-top: 2px solid rgba(106, 26, 77, .18);
        }

        .about-item .icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            margin-bottom: 20px;
            border-radius: 14px;
            background: #e8d5e0;
            color: var(--purple);
            font-size: 24px;
        }

        .about-item h3 {
            margin-bottom: 12px;
            color: var(--purple);
            font-size: 18px;
        }

        .about-item p {
            color: #746471;
            font-size: 13px;
            line-height: 1.85;
        }

        /* PROCESS */

        .process-section {
            width: 100%;
            padding: 90px max(32px, calc((100% - 1200px) / 2));
            background: linear-gradient(130deg, var(--purple), var(--deep-purple));
        }

        .process-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 65px;
        }

        .process-image {
            width: 100%;
            max-height: 470px;
            border-radius: 22px;
            object-fit: cover;
        }

        .process-content .section-label {
            color: var(--yellow);
        }

        .process-content h2 {
            margin-bottom: 18px;
            color: white;
            font-size: clamp(34px, 4vw, 46px);
            line-height: 1.15;
        }

        .process-content > p {
            margin-bottom: 30px;
            color: rgba(255, 255, 255, .78);
            font-size: 14px;
            line-height: 1.85;
        }

        .process-step {
            display: flex;
            gap: 20px;
            padding: 20px 0;
            border-top: 1px solid rgba(255, 255, 255, .2);
        }

        .process-step .number {
            flex-shrink: 0;
            color: var(--yellow);
            font-size: 26px;
            font-weight: 800;
        }

        .process-step h3 {
            margin-bottom: 8px;
            color: white;
            font-size: 17px;
        }

        .process-step p {
            color: rgba(255, 255, 255, .75);
            font-size: 13px;
            line-height: 1.75;
        }

        /* TESTIMONIALS */

        .testimonials-section {
            padding-top: 100px;
            padding-bottom: 110px;
        }

        .testimonials {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
        }

        .testimonial-card {
            padding: 30px;
            border: 1px solid #e8dce3;
            border-radius: 20px;
            background: #fffaf7;
            box-shadow: 0 8px 24px rgba(72, 17, 55, .04);
            transition: transform .2s, box-shadow .2s;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 30px rgba(72, 17, 55, .09);
        }

        .quote-mark {
            margin-bottom: 16px;
            color: var(--yellow);
            font-size: 44px;
            font-weight: 800;
            line-height: 1;
        }

        .testimonial-text {
            min-height: 105px;
            margin-bottom: 25px;
            color: #665563;
            font-size: 14px;
            line-height: 1.9;
        }

        .testimonial-person {
            display: flex;
            align-items: center;
            gap: 13px;
            padding-top: 20px;
            border-top: 1px solid #eee2e9;
        }

        .testimonial-person img {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            border: 2px solid #ead4e1;
            border-radius: 50%;
            object-fit: cover;
        }

        .person-name {
            margin-bottom: 5px;
            color: var(--purple);
            font-size: 13px;
            font-weight: 800;
        }

        .person-role {
            color: #897987;
            font-size: 11px;
        }

        /* REPORT CTA */

        .report-section {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 420px;
            padding: 80px 32px;
            overflow: hidden;
            background-color: var(--purple);
            background-image:
                linear-gradient(
                    100deg,
                    rgba(76, 0, 49, .94),
                    rgba(106, 26, 77, .82)
                ),
                url("{{ asset('assets/Report Section Image.png') }}");
            background-position: center;
            background-size: cover;
            text-align: center;
        }

        .report-content {
            position: relative;
            z-index: 1;
            max-width: 700px;
        }

        .report-content h2 {
            margin-bottom: 20px;
            color: white;
            font-size: clamp(34px, 4vw, 48px);
        }

        .report-content p {
            margin-bottom: 30px;
            color: rgba(255, 255, 255, .84);
            font-size: 15px;
            line-height: 1.9;
        }

        /* FOOTER */

        footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 18px;
            padding: 28px max(32px, calc((100% - 1200px) / 2));
            background: var(--deep-purple);
            color: rgba(255, 255, 255, .8);
            font-size: 12px;
        }

        .footer-brand {
            color: white;
            font-weight: 800;
            font-size: 15px;
        }

        /* RESPONSIVE */

        @media (max-width: 900px) {
            .navbar {
                gap: 15px;
                padding: 10px 17px;
            }

            .nav-links {
                gap: 17px;
            }

            .nav-links > a:not(.nav-login) {
                font-size: 12px;
            }

            .hero {
                min-height: 650px;
                padding: 100px 6% 190px;
            }

            .hero-content {
                width: 75%;
            }

            .hero-info {
                grid-template-columns: 1fr 1fr;
                gap: 18px;
                padding: 24px 5%;
            }

            .privacy-card {
                grid-column: 1 / -1;
                width: fit-content;
            }

            .about-layout,
            .process-layout {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .about-details {
                gap: 20px;
            }

            .process-image {
                max-height: 350px;
            }

            .testimonials {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 600px) {
            .navbar {
                position: sticky;
                top: 8px;
                width: calc(100% - 24px);
                margin-top: 8px;
                margin-bottom: -15px;
                padding: 12px 15px;
                border-radius: 24px;
            }

            .brand {
                gap: 7px;
            }

            .brand img {
                width: 27px;
                height: 27px;
            }

            .brand-name {
                font-size: 18px;
            }

            .brand-subtitle {
                font-size: 8px;
            }

            .nav-links {
                gap: 0;
            }

            .nav-links > a:not(.nav-login) {
                display: none;
            }

            .nav-login {
                min-width: auto;
                min-height: 38px;
                padding: 10px 16px;
                font-size: 12px;
            }

            .hero {
                width: calc(100% - 24px);
                min-height: 730px;
                padding: 90px 25px 265px;
                border-radius: 22px;
                background-position: center;
            }

            .hero-content {
                width: 100%;
            }

            .eyebrow {
                margin-bottom: 22px;
                padding: 10px 13px;
                font-size: 9px;
                letter-spacing: .6px;
            }

            .hero h1 {
                margin-bottom: 20px;
                font-size: clamp(39px, 11vw, 57px);
                letter-spacing: -1.8px;
            }

            .hero-description {
                font-size: 13px;
                line-height: 1.8;
            }

            .hero-actions {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn {
                min-height: 47px;
                padding: 12px 18px;
                font-size: 12px;
            }

            .hero-info {
                grid-template-columns: 1fr;
                gap: 14px;
                min-height: 230px;
                padding: 22px;
                border-radius: 18px 18px 0 0;
            }

            .info-item {
                font-size: 12px;
            }

            .privacy-card {
                grid-column: auto;
                width: 100%;
            }

            .section {
                width: calc(100% - 40px);
                padding: 70px 0;
            }

            .section-heading {
                margin-bottom: 35px;
            }

            .section-heading h2 {
                font-size: 32px;
            }

            .about-layout {
                gap: 25px;
            }

            .about-title h2 {
                font-size: 37px;
            }

            .about-details {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .about-item {
                padding: 22px 0;
            }

            .process-section {
                padding: 65px 22px;
            }

            .process-layout {
                gap: 32px;
            }

            .process-content h2 {
                font-size: 34px;
            }

            .testimonials {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .testimonial-card {
                padding: 25px;
            }

            .testimonial-text {
                min-height: auto;
            }

            .report-section {
                min-height: 380px;
                padding: 65px 24px;
            }

            .report-content h2 {
                font-size: 34px;
            }

            footer {
                padding: 25px 22px;
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="#beranda" class="brand">
            <img src="{{ asset('images/logo-elaw.png') }}" alt="Logo E-Law">

            <div>
                <div class="brand-name">E-Law</div>
                <div class="brand-subtitle">Fakultas Ilmu Komputer</div>
            </div>
        </a>

        <div class="nav-links">
            <a href="#tentang">Tentang</a>
            <a href="#alur">Alur Pengaduan</a>
            <a href="#testimoni">Testimoni</a>

            <a href="{{ route('login') }}" class="nav-login">
                Masuk <span aria-hidden="true">➜</span>
            </a>
        </div>
    </nav>

    <main>

        <!-- HERO -->
        <section class="hero" id="beranda">
            <div class="hero-content">
                <span class="eyebrow">
                    LAYANAN HUKUM FAKULTAS ILMU KOMPUTER
                </span>

                <h1>
                    Ruang Aman<br>
                    Untuk <span>Didengar.</span>
                </h1>

                <p class="hero-description">
                    Sampaikan pengaduan, pantau proses penanganannya,
                    dan dapatkan akses layanan hukum dalam satu tempat.
                    Suara kamu penting dan berhak mendapatkan perhatian.
                </p>

                <div class="hero-actions">
                    <a href="{{ route('login') }}" class="btn btn-yellow">
                        Mulai Pengaduan <span aria-hidden="true">→</span>
                    </a>

                    <a href="#alur" class="btn btn-outline">
                        Pelajari Alurnya
                    </a>
                </div>
            </div>

            <!-- Panel informasi di bagian bawah hero -->
            <div class="hero-info">
                <div class="info-item">
                    <span class="info-icon" aria-hidden="true">♧</span>
                    <span>Data Terenkripsi</span>
                </div>

                <div class="info-item">
                    <span class="info-icon" aria-hidden="true">◷</span>
                    <span>Respons Maksimal 2×24 Jam</span>
                </div>

                <div class="privacy-card">
                    <span class="shield" aria-hidden="true">♢</span>
                    <div>
                        <strong>Privasi Anda terlindungi</strong>
                        <p>Setiap laporan ditangani secara rahasia.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ABOUT US -->
        <section class="section" id="tentang">
            <div class="about-layout">
                <div class="about-title">
                    <span class="section-label">ABOUT US</span>

                    <h2>Pengaduan yang mudah, aman, dan terarah.</h2>

                    <p>
                        E-Law adalah kanal pengaduan internal Fakultas
                        Ilmu Komputer untuk mahasiswa, dosen, dan tenaga
                        kependidikan dalam menyampaikan permasalahan
                        melalui proses yang lebih terstruktur.
                    </p>
                </div>

                <div class="about-details">
                    <article class="about-item">
                        <div class="icon" aria-hidden="true">♡</div>
                        <h3>Ruang Aman</h3>
                        <p>
                            Memberikan ruang untuk menyampaikan pengaduan
                            dengan perhatian terhadap privasi pelapor.
                        </p>
                    </article>

                    <article class="about-item">
                        <div class="icon" aria-hidden="true">↗</div>
                        <h3>Proses Terarah</h3>
                        <p>
                            Setiap laporan dapat ditinjau dan diteruskan
                            kepada pihak yang berwenang.
                        </p>
                    </article>

                    <article class="about-item">
                        <div class="icon" aria-hidden="true">◎</div>
                        <h3>Pantau Progres</h3>
                        <p>
                            Pelapor dapat memantau status penanganan
                            melalui sistem.
                        </p>
                    </article>

                    <article class="about-item">
                        <div class="icon" aria-hidden="true">♧</div>
                        <h3>Privasi Terjaga</h3>
                        <p>
                            Informasi pengaduan perlu diakses dan
                            ditangani sesuai kewenangan masing-masing.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <!-- ALUR PENGADUAN -->
        <section class="process-section" id="alur">
            <div class="process-layout">
                <img
                    class="process-image"
                    src="{{ asset('assets/Process Section Image.png') }}"
                    alt="Ilustrasi proses pengaduan E-Law"
                    loading="lazy"
                >

                <div class="process-content">
                    <span class="section-label">ALUR PENGADUAN</span>

                    <h2>Setiap langkah punya arah.</h2>

                    <p>
                        Ikuti proses pengaduan melalui sistem E-Law,
                        mulai dari penyampaian laporan sampai memantau
                        perkembangan penanganannya.
                    </p>

                    <article class="process-step">
                        <div class="number">01</div>
                        <div>
                            <h3>Masuk ke Sistem</h3>
                            <p>
                                Login menggunakan akun yang sudah
                                terdaftar untuk mengakses layanan.
                            </p>
                        </div>
                    </article>

                    <article class="process-step">
                        <div class="number">02</div>
                        <div>
                            <h3>Kirim Pengaduan</h3>
                            <p>
                                Lengkapi informasi, kronologi, kategori,
                                dan bukti pendukung jika diperlukan.
                            </p>
                        </div>
                    </article>

                    <article class="process-step">
                        <div class="number">03</div>
                        <div>
                            <h3>Pantau Penanganan</h3>
                            <p>
                                Periksa status dan perkembangan
                                pengaduan melalui dashboard.
                            </p>
                        </div>
                    </article>

                    <a href="{{ route('login') }}" class="btn btn-yellow">
                        Mulai Pengaduan <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- TESTIMONIALS -->
        <section class="section testimonials-section" id="testimoni">
            <div class="section-heading">
                <span class="section-label">TESTIMONI</span>

                <h2>Suara yang Perlu Didengar</h2>

                <p>
                    Setiap pengalaman penting. E-Law dirancang untuk
                    membantu proses penyampaian dan pemantauan pengaduan.
                </p>
            </div>

            <div class="testimonials">
                <article class="testimonial-card">
                    <div class="quote-mark">“</div>

                    <p class="testimonial-text">
                        Aku ingin punya tempat untuk menyampaikan
                        permasalahan dan mengetahui bagaimana
                        prosesnya ditangani.
                    </p>

                    <div class="testimonial-person">
                        <img
                            src="{{ asset('assets/Testimonial Avatar.png') }}"
                            alt="Ilustrasi pengguna pertama"
                            loading="lazy"
                        >

                        <div>
                            <div class="person-name">Harapan Pengguna</div>
                            <div class="person-role">Mahasiswa</div>
                        </div>
                    </div>
                </article>

                <article class="testimonial-card">
                    <div class="quote-mark">“</div>

                    <p class="testimonial-text">
                        Informasi alur yang jelas membantu pengguna
                        memahami langkah yang perlu dilakukan.
                    </p>

                    <div class="testimonial-person">
                        <img
                            src="{{ asset('assets/Testimonial Avatar-1.png') }}"
                            alt="Ilustrasi pengguna kedua"
                            loading="lazy"
                        >

                        <div>
                            <div class="person-name">Harapan Pengguna</div>
                            <div class="person-role">Mahasiswa</div>
                        </div>
                    </div>
                </article>

                <article class="testimonial-card">
                    <div class="quote-mark">“</div>

                    <p class="testimonial-text">
                        Kemudahan memantau status membuat proses
                        pengaduan terasa lebih terarah.
                    </p>

                    <div class="testimonial-person">
                        <img
                            src="{{ asset('assets/Testimonial Avatar-2.png') }}"
                            alt="Ilustrasi pengguna ketiga"
                            loading="lazy"
                        >

                        <div>
                            <div class="person-name">Harapan Pengguna</div>
                            <div class="person-role">Mahasiswa</div>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <!-- REPORT CTA -->
        <section class="report-section">
            <div class="report-content">
                <span class="section-label" style="color: var(--yellow);">
                    E-LAW
                </span>

                <h2>Suaramu Layak Didengar.</h2>

                <p>
                    Mulai langkahmu dengan menyampaikan pengaduan
                    melalui sistem E-Law. Sampaikan laporan dan pantau
                    proses penanganannya melalui satu tempat.
                </p>

                <a href="{{ route('login') }}" class="btn btn-yellow">
                    Masuk ke E-Law <span aria-hidden="true">→</span>
                </a>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer>
        <span class="footer-brand">E-Law — Fakultas Ilmu Komputer</span>
        <span>Ruang aman untuk didengar.</span>
    </footer>

</body>
</html>
