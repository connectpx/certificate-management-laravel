<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BASDU Certificates')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:500,600,700|dm-sans:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="site-shell" x-data="{ open: false }">
    <header class="site-header">
        <div class="site-container site-header-inner">
            <a href="{{ route('home') }}" class="font-display site-brand">BASDU</a>

            <nav class="site-nav">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'site-link-active' : 'site-link' }}">Verify</a>
                <a href="{{ route('certificates.index') }}" class="{{ request()->routeIs('certificates.*') ? 'site-link-active' : 'site-link' }}">Certificates</a>
                <a href="{{ route('login') }}" class="site-link">Admin</a>
            </nav>

            <button type="button" class="menu-toggle" @click="open = !open" aria-label="Toggle menu">
                <span x-text="open ? 'Close' : 'Menu'"></span>
            </button>
        </div>

        <div class="mobile-nav" :class="{ 'is-open': open }" x-cloak>
            <div class="site-container">
                <a href="{{ route('home') }}" class="site-link">Verify</a>
                <a href="{{ route('certificates.index') }}" class="site-link">Certificates</a>
                <a href="{{ route('login') }}" class="site-link">Admin</a>
            </div>
        </div>
    </header>

    @if (session('success') || session('error'))
        <div class="site-container pt-4">
            @if (session('success'))
                <div class="flash flash-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="flash flash-error">{{ session('error') }}</div>
            @endif
        </div>
    @endif

    <main class="site-main">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="site-container site-footer-inner">
            <span class="font-display text-xl" style="color: var(--brand);">BASDU</span>
            <span>Security Dog Handler Certificate Registry</span>
        </div>
    </footer>
</body>
</html>
