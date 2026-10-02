<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BASDU Certificates')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:500,600,700|dm-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="site-shell" x-data="{ open: false }">
    <header class="border-b border-[var(--line)] bg-white/90 backdrop-blur sticky top-0 z-40">
        <div class="site-container flex h-16 items-center justify-between">
            <a href="{{ route('home') }}" class="font-display text-2xl tracking-tight text-[var(--brand)]">
                BASDU
            </a>

            <nav class="hidden items-center gap-8 md:flex">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'site-link-active' : 'site-link' }}">Verify</a>
                <a href="{{ route('certificates.index') }}" class="{{ request()->routeIs('certificates.*') ? 'site-link-active' : 'site-link' }}">Certificates</a>
                <a href="{{ route('login') }}" class="site-link">Admin</a>
            </nav>

            <button type="button" class="md:hidden text-sm text-[var(--brand)]" @click="open = !open" aria-label="Toggle menu">
                <span x-text="open ? 'Close' : 'Menu'"></span>
            </button>
        </div>

        <div class="border-t border-[var(--line)] bg-white md:hidden" x-show="open" x-cloak>
            <div class="site-container flex flex-col gap-3 py-4">
                <a href="{{ route('home') }}" class="site-link">Verify</a>
                <a href="{{ route('certificates.index') }}" class="site-link">Certificates</a>
                <a href="{{ route('login') }}" class="site-link">Admin</a>
            </div>
        </div>
    </header>

    @if (session('success') || session('error'))
        <div class="site-container pt-4">
            @if (session('success'))
                <div class="flash border border-emerald-200 bg-emerald-50 text-emerald-800">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="flash border border-rose-200 bg-rose-50 text-rose-800">{{ session('error') }}</div>
            @endif
        </div>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="mt-auto border-t border-[var(--line)] bg-white">
        <div class="site-container flex flex-col gap-2 py-8 text-sm text-[var(--muted)] md:flex-row md:items-center md:justify-between">
            <span class="font-display text-lg text-[var(--brand)]">BASDU</span>
            <span>Security Dog Handler Certificate Registry</span>
        </div>
    </footer>
</body>
</html>
