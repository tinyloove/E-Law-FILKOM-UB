<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Law') | E-Law</title>
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}">
</head>
<body>
<div class="app-container">

    @include('partials.sidebar')

    <main class="main-content">
        <header class="topbar">
            @hasSection('topbar_search')
                <div class="topbar-search">
                    <input type="search" id="globalSearch" placeholder="@yield('topbar_search')" autocomplete="off">
                    <span>⌕</span>
                </div>
            @endif
        </header>

        <section class="content">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </section>
    </main>
</div>

@stack('scripts')
</body>
</html>