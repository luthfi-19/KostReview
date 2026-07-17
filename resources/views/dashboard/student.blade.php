<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pencarian Kos - KostReview</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .masonry { columns: 1; column-gap: 1.25rem; }
        .masonry > * { break-inside: avoid; margin-bottom: 1.25rem; }
        @media (min-width: 640px)  { .masonry { columns: 2; } }
        @media (min-width: 1024px) { .masonry { columns: 3; } }
    </style>
</head>
<body class="bg-wa-bg font-sans antialiased text-wa-text min-h-screen">

    {{-- NAVBAR --}}
    <nav x-data="{ mobileOpen: false }" class="bg-wa-darker border-b border-wa-border sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <span class="text-wa-green font-extrabold text-lg">K</span>
                        <span class="text-wa-text font-bold text-lg">KostReview</span>
                    </a>
                </div>
                <div class="hidden md:flex md:items-center md:gap-1">
                    @auth
                        <a href="{{ route('home') }}" class="text-wa-green bg-wa-card text-sm font-bold px-3 py-2 rounded-lg transition">Katalog</a>
                        @if(Auth::user()->role === 'student')
                            <a href="{{ route('student.occupancy.index') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Pengajuan Saya</a>
                        @endif
                        @if(Auth::user()->role === 'owner')
                            <a href="{{ route('owner.dashboard') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Dashboard</a>
                            <a href="{{ route('kost.create') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">+ Tambah Kos</a>
                        @endif
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Admin</a>
                        @endif
                        <div class="w-px h-6 bg-wa-border mx-2"></div>
                        <a href="{{ route('profile.info') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Profil</a>
                        <form method="POST" action="{{ route('logout') }}" class="ml-1">@csrf<button type="submit" class="bg-wa-red hover:bg-red-600 text-white text-sm font-bold px-4 py-2 rounded-lg transition">Keluar</button></form>
                    @else
                        <a href="{{ route('login') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-wa-green hover:bg-emerald-600 text-white text-sm font-bold px-4 py-2 rounded-lg transition ml-2">Daftar</a>
                    @endauth
                </div>
                <div class="flex items-center md:hidden">
                    <button @click="mobileOpen = !mobileOpen" class="text-wa-muted hover:text-wa-text p-2 rounded-lg hover:bg-wa-card transition">
                        <svg x-show="!mobileOpen" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileOpen" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>
        <div x-show="mobileOpen" x-cloak x-transition class="md:hidden border-t border-wa-border">
            <div class="px-4 py-3 space-y-1">
                @auth
                    <a href="{{ route('home') }}" class="block text-wa-green bg-wa-card text-sm font-bold px-3 py-2 rounded-lg transition">Katalog</a>
                    @if(Auth::user()->role === 'student')
                        <a href="{{ route('student.occupancy.index') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Pengajuan Saya</a>
                    @endif
                    @if(Auth::user()->role === 'owner')
                        <a href="{{ route('owner.dashboard') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Dashboard</a>
                        <a href="{{ route('kost.create') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">+ Tambah Kos</a>
                    @endif
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Admin</a>
                    @endif
                    <div class="border-t border-wa-border my-2"></div>
                    <a href="{{ route('profile.info') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="w-full text-left bg-wa-red hover:bg-red-600 text-white text-sm font-bold px-3 py-2 rounded-lg transition mt-1">Keluar</button></form>
                @else
                    <a href="{{ route('login') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Masuk</a>
                    <a href="{{ route('register') }}" class="block bg-wa-green hover:bg-emerald-600 text-white text-sm font-bold px-3 py-2 rounded-lg transition mt-1">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <header class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-wa-darker via-wa-bg to-wa-card"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-wa-green/5 rounded-full blur-3xl"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 text-center">
            <div class="inline-flex items-center gap-2 bg-wa-card border border-wa-border rounded-full px-4 py-1.5 mb-5">
                <span class="w-2 h-2 bg-wa-green rounded-full animate-pulse"></span>
                <span class="text-wa-muted text-xs font-medium">{{ $kosts->count() }} kos tersedia</span>
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-wa-text leading-tight">
                Temukan Kos <span class="text-wa-green">Impianmu</span>
            </h1>
            <p class="text-wa-muted text-sm sm:text-base mt-3 max-w-xl mx-auto">
                Jelajahi berbagai pilihan kos terbaik di sekitar kampus. Langsung aja cari.
            </p>

            @auth
                @if(Auth::user()->role === 'student')
                    <a href="{{ route('student.occupancy.index') }}" class="inline-flex items-center gap-2 bg-wa-card hover:bg-wa-hover border border-wa-border text-wa-text font-semibold px-5 py-2.5 rounded-xl text-sm transition mt-6">
                        Lihat Status Pengajuan Saya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endif
            @endauth
        </div>
    </header>

    {{-- SEARCH --}}
    <div class="max-w-3xl mx-auto px-4 sm:px-6 -mt-2 mb-10 relative z-10">
        <form action="{{ route('home') }}" method="GET">
            <div class="flex bg-wa-card border border-wa-border rounded-2xl overflow-hidden shadow-card focus-within:shadow-card-hover focus-within:border-wa-green/40 transition-all">
                <div class="flex-1 flex items-center px-4">
                    <svg class="w-5 h-5 text-wa-muted shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" class="flex-1 min-w-0 px-3 py-3.5 text-sm bg-transparent border-0 focus:ring-0 text-wa-text placeholder-wa-muted" placeholder="Cari nama atau lokasi kos..." value="{{ request('search') }}">
                </div>
                <select name="campus_id" class="border-l border-wa-border bg-wa-darker text-wa-text text-sm px-3 py-3 focus:ring-0 focus:border-transparent max-w-[40%]">
                    <option value="">Semua Kampus</option>
                    @foreach($campuses as $campus)
                        <option value="{{ $campus->id }}" {{ request('campus_id') == $campus->id ? 'selected' : '' }}>Dekat {{ $campus->name }}</option>
                    @endforeach
                </select>
                <button class="bg-wa-green hover:bg-emerald-600 text-white font-bold px-6 py-3 text-sm transition shrink-0" type="submit">Cari</button>
            </div>
        </form>

        @if(request('search') && $kosts->isEmpty())
            <p class="text-wa-red text-center mt-4 font-medium text-sm">
                Nggak ketemu, bos. Coba kata kunci lain.
            </p>
        @endif
    </div>

    {{-- KOST MASONRY GRID --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        @if($kosts->isEmpty())
            <div class="text-center py-20">
                <div class="w-16 h-16 mx-auto bg-wa-card border border-wa-border rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-wa-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <p class="text-wa-muted text-sm">Belum ada kos yang terdaftar.</p>
            </div>
        @else
            <div class="masonry">
                @foreach($kosts as $kost)
                    <a href="{{ route('kost.show', $kost->id) }}" class="block bg-wa-card border border-wa-border rounded-2xl overflow-hidden shadow-card hover:shadow-card-hover hover:border-wa-green/30 transition-all duration-200 group">
                        @if($kost->images->isNotEmpty())
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('storage/' . $kost->images->first()->image_path) }}" class="w-full object-cover group-hover:scale-105 transition-transform duration-300" style="min-height:180px; max-height:280px;" alt="Foto Kos">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                        @else
                            <div class="w-full bg-wa-darker flex items-center justify-center" style="min-height:180px;">
                                <svg class="w-10 h-10 text-wa-border" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                        @endif

                        <div class="p-4">
                            <h3 class="text-wa-text font-bold text-base group-hover:text-wa-green transition-colors">{{ $kost->name }}</h3>

                            <p class="text-wa-green font-bold text-sm mt-1.5">
                                Rp {{ number_format($kost->price_per_month, 0, ',', '.') }}
                                <span class="text-wa-muted font-normal text-xs">/ bulan</span>
                            </p>

                            <p class="text-wa-muted text-xs mt-2 leading-relaxed">
                                {{ Str::limit($kost->description, 100) }}
                            </p>

                            <div class="flex items-center gap-1.5 text-wa-muted text-xs mt-3 pt-3 border-t border-wa-border">
                                <svg class="w-3.5 h-3.5 shrink-0 text-wa-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>{{ Str::limit($kost->address, 50) }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>
