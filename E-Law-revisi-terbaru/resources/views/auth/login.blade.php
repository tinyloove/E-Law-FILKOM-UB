<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | E-Law</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; }

        :root {
            --plum: #6A1A4D;
            --plum-dark: #51123A;
            --gold: #F1A61F;
        }

        html, body { min-height: 100%; }

        body {
            background: #1E1E1E;
            color: #fff;
        }

        .login-page {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background:
                radial-gradient(ellipse at 30% 40%, #8A3374 0%, rgba(138,51,116,0) 55%),
                linear-gradient(135deg, #7A2B63 0%, #6A1A4D 55%, #5A1442 100%);
        }

        /* LOGO */
        .brand {
            position: absolute;
            top: 32px;
            left: 40px;
            z-index: 5;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-box {
            width: 40px;
            height: 40px;
            background: var(--gold);
            border-radius: 7px;
            padding: 5px;
            display: grid;
            place-items: center;
        }

        .logo-box img { width: 100%; height: 100%; object-fit: contain; }
        .brand-name { font-size: 16px; font-weight: bold; }
        .brand-subtitle { font-size: 9px; color: #D8C4D1; margin-top: 2px; }

        /* ILUSTRASI KIRI */
        .hero {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 56%;
            z-index: 1;
        }

        .arc {
            position: absolute;
            border: 1px solid rgba(241, 166, 31, .55);
            border-radius: 50%;
        }

        .arc.one { width: 520px; height: 520px; left: 19%; top: 6%; }
        .arc.two { width: 640px; height: 640px; left: 13%; top: 1%; border-color: rgba(241, 166, 31, .3); }

        .hero-photo {
            position: absolute;
            left: -1%;
            bottom: -4vh;
            height: 108vh;
            max-width: none;
            object-fit: contain;
            object-position: left bottom;
            z-index: 2;
            -webkit-mask-image: linear-gradient(to right, #000 86%, transparent 100%);
            mask-image: linear-gradient(to right, #000 86%, transparent 100%);
        }

        .hero-fade {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 46%;
            z-index: 3;
            background: linear-gradient(to bottom, rgba(106,26,77,0) 0%, rgba(106,26,77,.88) 62%, #6A1A4D 100%);
        }

        .hero-text {
            position: absolute;
            z-index: 4;
            left: 40px;
            bottom: 92px;
            max-width: 430px;
        }

        .hero-text h3 { color: var(--gold); font-size: 17px; font-weight: bold; margin-bottom: 4px; }
        .hero-text p { font-size: 28px; line-height: 1.22; font-weight: 400; }

        .privacy {
            position: absolute;
            z-index: 4;
            left: 40px;
            bottom: 32px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .privacy svg { width: 22px; height: 22px; flex-shrink: 0; }
        .privacy h4 { font-size: 10px; margin-bottom: 2px; }
        .privacy p { font-size: 8px; color: #E5D4DE; }

        /* KARTU LOGIN (efek kaca) */
        .card-wrap {
            position: relative;
            z-index: 6;
            min-height: 100vh;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 56px 170px 56px 0;
        }

        .login-card {
            width: min(52%, 700px);
            padding: 44px 46px 46px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .38);
            border-radius: 28px;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 18px 50px rgba(0, 0, 0, .18);
        }

        .welcome { font-size: 16px; font-weight: bold; margin-bottom: 2px; }
        .login-title { font-size: 38px; font-weight: 400; line-height: 1.1; margin-bottom: 26px; }

        .form-group { margin-bottom: 20px; }

        .form-group label,
        .role-title {
            display: block;
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            height: 54px;
            padding: 0 16px;
            font-size: 13px;
            color: #fff;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .85);
            border-radius: 9px;
            outline: none;
            transition: .2s;
        }

        .form-group input::placeholder { color: rgba(255, 255, 255, .55); }
        .form-group input:focus { border-color: var(--gold); background: rgba(255, 255, 255, .12); }

        .role-section { margin: 22px 0 22px; }

        .role-options { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
        .role-option input { display: none; }

        .role-option span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 34px;
            padding: 4px 6px;
            font-size: 10px;
            text-align: center;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .85);
            border-radius: 6px;
            cursor: pointer;
            transition: .2s;
        }

        .role-option span:hover { background: rgba(255, 255, 255, .15); }

        .role-option input:checked + span {
            background: #fff;
            color: var(--plum);
            font-weight: bold;
            border-color: #fff;
        }

        .login-button {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 7px;
            background: var(--plum);
            color: #fff;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 3px 8px rgba(0, 0, 0, .2);
            transition: .2s;
        }

        .login-button:hover { background: var(--plum-dark); }

        .error-message {
            background: rgba(254, 226, 226, .95);
            color: #B42318;
            border-radius: 7px;
            padding: 10px 12px;
            margin-bottom: 18px;
            font-size: 12px;
        }

        /* RESPONSIVE */
        @media (max-width: 1100px) {
            .hero { display: none; }
            .card-wrap { justify-content: center; padding: 100px 28px 40px; }
            .login-card { width: min(100%, 560px); }
        }

        @media (max-width: 560px) {
            .login-card { padding: 30px 22px; border-radius: 22px; }
            .login-title { font-size: 30px; }
            .role-options { grid-template-columns: repeat(2, 1fr); }
            .brand { left: 24px; top: 24px; }
        }
    </style>
</head>

<body>
<div class="login-page">

    <!-- LOGO -->
    <div class="brand">
        <div class="logo-box">
            <img src="{{ asset('images/logo-elaw.png') }}" alt="Logo E-Law">
        </div>
        <div>
            <div class="brand-name">E - Law</div>
            <div class="brand-subtitle">Fakultas Ilmu Komputer</div>
        </div>
    </div>

    <!-- ILUSTRASI KIRI -->
    <section class="hero">
        <div class="arc one"></div>
        <div class="arc two"></div>

        <img class="hero-photo"
             src="{{ asset('images/login-illustration.png') }}"
             alt="Tim layanan hukum E-Law">

        <div class="hero-fade"></div>

        <div class="hero-text">
            <h3>Layanan hukum terpadu</h3>
            <p>Ruang aman untuk menyampaikan, memantau, dan menyelesaikan.</p>
        </div>

        <div class="privacy">
            <svg viewBox="0 0 24 24" fill="none" stroke="#F1A61F" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3l7 3v5c0 4.5-3 8.2-7 10-4-1.8-7-5.5-7-10V6l7-3z"/>
                <path d="M9 12l2 2 4-4"/>
            </svg>
            <div>
                <h4>Privasi Anda terlindungi</h4>
                <p>Setiap laporan ditangani secara rahasia.</p>
            </div>
        </div>
    </section>

    <!-- KARTU LOGIN -->
    <div class="card-wrap">
        <div class="login-card">

            <div class="welcome">Selamat datang kembali!</div>
            <h1 class="login-title">Masuk ke E-Law</h1>

            @if ($errors->any())
                <div class="error-message">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="username">Email atau username</label>
                    <input type="text" id="username" name="username"
                           value="{{ old('username') }}"
                           placeholder="Masukkan email atau username"
                           autocomplete="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password"
                           placeholder="Masukkan password"
                           autocomplete="current-password" required>
                </div>

                <div class="role-section">
                    <div class="role-title">Masuk sebagai</div>

                    <div class="role-options">
                        <label class="role-option">
                            <input type="radio" name="role" value="1" {{ old('role', '1') == '1' ? 'checked' : '' }}>
                            <span>Mahasiswa</span>
                        </label>

                        <label class="role-option">
                            <input type="radio" name="role" value="2" {{ old('role') == '2' ? 'checked' : '' }}>
                            <span>Admin</span>
                        </label>

                        <label class="role-option">
                            <input type="radio" name="role" value="3" {{ old('role') == '3' ? 'checked' : '' }}>
                            <span>Tim Hukum</span>
                        </label>

                        <label class="role-option">
                            <input type="radio" name="role" value="4" {{ old('role') == '4' ? 'checked' : '' }}>
                            <span>Pimpinan Fakultas</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="login-button">Masuk</button>
            </form>

        </div>
    </div>

</div>
</body>
</html>