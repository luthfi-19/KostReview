<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'KostReview') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-wa-bg font-sans antialiased text-wa-text min-h-screen">
    <div class="min-h-screen flex flex-col items-center justify-center px-4">
        <div class="text-center max-w-lg">
            <div class="flex items-center justify-center gap-3 mb-6">
                <span class="text-wa-green font-extrabold text-5xl">K</span>
                <span class="text-wa-text font-extrabold text-5xl">KostReview</span>
            </div>
            <p class="text-wa-muted text-base mb-8">Platform review dan pencarian kos terbaik untuk mahasiswa.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('home') }}" class="bg-wa-green hover:bg-emerald-600 text-white font-bold px-6 py-3 rounded-xl text-sm transition">Masuk ke Katalog</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-wa-green hover:bg-emerald-600 text-white font-bold px-6 py-3 rounded-xl text-sm transition">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-wa-card border border-wa-border text-wa-text hover:bg-wa-hover font-bold px-6 py-3 rounded-xl text-sm transition">Daftar Akun</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</body>
</html>
