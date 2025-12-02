<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/style.css'])
    </head>

    <body class="auth-body">
<body class="font-sans text-gray-900 antialiased">
    <div class="auth-container">
        <div class="auth-left-panel">
            <img src="{{ asset('images/auth-hero.png') }}" alt="We Care Logo">
            <h1>Selamat Datang di We Care</h1>
            <p>Platform kesehatan terpadu untuk Anda dan keluarga. Daftar sekarang untuk memulai pengalaman terbaik Anda.</p>
        </div>

        <div class="auth-right-panel">
            <div class="auth-form-container">
                {{ $slot }} </div>
        </div>
    </div>
    </body>
</html>