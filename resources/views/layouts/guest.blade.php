<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Secure Admin') }}</title>
        <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    </head>
    <body style="background:#0f2a44; margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center;">
        <div style="width:100%; max-width:28rem; padding:1.5rem;">
            <div style="text-align:center; color:#fff; margin-bottom:1.5rem;">
                <div style="font-size:0.75rem; letter-spacing:0.2em; text-transform:uppercase; color:#b8943a;">Hidden Admin Panel</div>
                <div style="margin-top:0.5rem; font-size:1.5rem; font-weight:600;">/secure-admin</div>
            </div>
            <div style="background:#fff; border-radius:0.5rem; padding:1.5rem; box-shadow:0 10px 30px rgba(0,0,0,.2);">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
