<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="0;url={{ url('/') }}">
    <title>{{ config('app.name', 'BASDU Certificates') }}</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body class="site-shell">
    <main class="site-main">
        <div class="site-container" style="padding:3rem 1.25rem; text-align:center;">
            <p class="font-display" style="font-size:1.5rem; color:var(--brand);">BASDU</p>
            <p style="color:var(--muted); margin-top:0.75rem;">
                <a href="{{ url('/') }}" class="site-link-active">Continue to certificate registry</a>
            </p>
        </div>
    </main>
</body>
</html>
