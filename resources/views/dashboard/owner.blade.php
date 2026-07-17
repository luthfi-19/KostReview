<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Owner Dashboard - KostReview</title>
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
                <div class="flex items-center gap-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <span class="text-wa-green font-extrabold text-lg">K</span>
                        <span class="text-wa-text font-bold text-lg">KostReview</span>
                    </a>
                    <span class="bg-pink/20 text-pink text-[10px] font-bold px-2 py-0.5 rounded-full hidden sm:inline-block">Owner</span>
                </div>
                <div class="hidden md:flex md:items-center md:gap-1">
                    <a href="{{ route('home') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Katalog</a>
                    <a href="{{ route('owner.dashboard') }}" class="text-wa-green bg-wa-card text-sm font-bold px-3 py-2 rounded-lg transition">Dashboard</a>
                    <a href="{{ route('kost.create') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">+ Tambah Kos</a>
                    <div class="w-px h-6 bg-wa-border mx-2"></div>
                    <a href="{{ route('profile.info') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Profil</a>
                    <form method="POST" action="{{ route('logout') }}" class="ml-1">@csrf<button type="submit" class="bg-wa-red hover:bg-red-600 text-white text-sm font-bold px-4 py-2 rounded-lg transition">Keluar</button></form>
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
                <a href="{{ route('home') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Katalog</a>
                <a href="{{ route('owner.dashboard') }}" class="block text-wa-green bg-wa-card text-sm font-bold px-3 py-2 rounded-lg transition">Dashboard</a>
                <a href="{{ route('kost.create') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">+ Tambah Kos</a>
                <div class="border-t border-wa-border my-2"></div>
                <a href="{{ route('profile.info') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Profil</a>
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="w-full text-left bg-wa-red hover:bg-red-600 text-white text-sm font-bold px-3 py-2 rounded-lg transition mt-1">Keluar</button></form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- FLASH --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition class="bg-wa-green/10 border border-wa-green/30 text-wa-green px-4 py-3 rounded-xl flex items-center justify-between mb-6">
                <span class="font-medium text-sm">{{ session('success') }}</span>
                <button @click="show = false" class="text-wa-green/60 hover:text-wa-green ml-3 text-lg">&times;</button>
            </div>
        @endif

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-wa-text">Dashboard</h1>
                <p class="text-wa-muted text-sm mt-1">Selamat datang kembali, {{ Auth::user()->name }}.</p>
            </div>
            <a href="{{ route('kost.create') }}" class="inline-flex items-center gap-2 bg-wa-green hover:bg-emerald-600 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition shadow-card">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kos Baru
            </a>
        </div>

        {{-- STAT RINGKASAN --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-8">
            <div class="bg-wa-card border border-wa-border rounded-2xl p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-wa-green/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-wa-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <p class="text-wa-muted text-xs">Total Kos</p>
                        <p class="text-wa-text font-bold text-lg leading-tight">{{ $kosts->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-wa-card border border-wa-border rounded-2xl p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-wa-yellow/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-wa-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <div>
                        <p class="text-wa-muted text-xs">Menunggu</p>
                        <p class="text-wa-text font-bold text-lg leading-tight">{{ $occupancies->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- PENDING OCCUPANCIES --}}
        <section class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-wa-text flex items-center gap-2">
                    <span class="w-2 h-2 bg-wa-yellow rounded-full"></span>
                    Pengajuan Baru
                </h2>
                @if($occupancies->count() > 0)
                    <span class="bg-wa-yellow/15 text-wa-yellow text-xs font-bold px-2.5 py-1 rounded-full">{{ $occupancies->count() }} menunggu</span>
                @endif
            </div>

            @if($occupancies->isEmpty())
                <div class="bg-wa-card border border-wa-border rounded-2xl p-8 text-center">
                    <div class="w-12 h-12 mx-auto bg-wa-darker rounded-xl flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-wa-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-wa-muted text-sm">Belum ada pengajuan baru.</p>
                </div>
            @else
                <div class="masonry">
                    @foreach($occupancies as $occupancy)
                        <div class="bg-wa-card border border-wa-border rounded-2xl p-5 shadow-card">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-wa-green/10 rounded-full flex items-center justify-center text-wa-green font-bold text-sm">
                                        {{ substr($occupancy->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-wa-text font-bold text-sm">{{ $occupancy->user->name }}</p>
                                        <p class="text-wa-muted text-xs">{{ $occupancy->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <span class="bg-wa-yellow/15 text-wa-yellow text-[10px] font-bold px-2 py-0.5 rounded-full">BARU</span>
                            </div>
                            <div class="bg-wa-darker rounded-xl px-3 py-2 mb-4">
                                <p class="text-wa-muted text-xs">Mendaftar di</p>
                                <p class="text-wa-text font-semibold text-sm">{{ $occupancy->kost->name }}</p>
                            </div>
                            <div class="flex gap-2">
                                <form action="{{ route('owner.occupancy.approve', $occupancy->id) }}" method="POST" class="flex-1">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="w-full bg-wa-green hover:bg-emerald-600 text-white text-xs font-bold py-2 rounded-xl transition">Terima</button>
                                </form>
                                <form action="{{ route('owner.occupancy.reject', $occupancy->id) }}" method="POST" class="flex-1">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="w-full border border-wa-red/40 text-wa-red hover:bg-wa-red/10 text-xs font-bold py-2 rounded-xl transition">Tolak</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- KOST LISTING --}}
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-wa-text flex items-center gap-2">
                    <span class="w-2 h-2 bg-wa-green rounded-full"></span>
                    Kos Saya
                </h2>
                <a href="{{ route('kost.create') }}" class="text-wa-green hover:text-emerald-400 text-xs font-bold transition">+ Tambah Baru</a>
            </div>

            @if($kosts->isEmpty())
                <div class="bg-wa-card border border-wa-border rounded-2xl p-8 text-center">
                    <div class="w-12 h-12 mx-auto bg-wa-darker rounded-xl flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-wa-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <p class="text-wa-muted text-sm mb-3">Belum ada kos yang terdaftar.</p>
                    <a href="{{ route('kost.create') }}" class="inline-flex items-center gap-1.5 bg-wa-green hover:bg-emerald-600 text-white font-bold px-4 py-2 rounded-xl text-xs transition">Tambah Kos Sekarang</a>
                </div>
            @else
                <div class="masonry">
                    @foreach($kosts as $kost)
                        <div class="bg-wa-card border border-wa-border rounded-2xl overflow-hidden shadow-card group">
                            @if($kost->images->isNotEmpty())
                                <div class="relative overflow-hidden">
                                    <img src="{{ asset('storage/' . $kost->images->first()->image_path) }}" class="w-full object-cover group-hover:scale-105 transition-transform duration-300" style="min-height:160px; max-height:240px;" alt="Foto Kos">
                                </div>
                            @else
                                <div class="w-full bg-wa-darker flex items-center justify-center" style="min-height:120px;">
                                    <svg class="w-8 h-8 text-wa-border" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                            @endif

                            <div class="p-4">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="text-wa-text font-bold text-sm leading-tight">{{ $kost->name }}</h3>
                                </div>
                                <p class="text-wa-green font-bold text-sm">Rp {{ number_format($kost->price_per_month, 0, ',', '.') }} <span class="text-wa-muted font-normal text-xs">/ bln</span></p>
                                <p class="text-wa-muted text-xs mt-1.5 flex items-center gap-1">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    {{ Str::limit($kost->address, 40) }}
                                </p>
                                <div class="flex gap-2 mt-4 pt-3 border-t border-wa-border">
                                    <a href="{{ route('kost.edit', $kost->id) }}" class="flex-1 text-center border border-wa-blue/40 text-wa-blue hover:bg-wa-blue/10 text-xs font-bold py-2 rounded-xl transition">Edit</a>
                                    <form action="{{ route('kost.destroy', $kost->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus kos ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-full border border-wa-red/40 text-wa-red hover:bg-wa-red/10 text-xs font-bold py-2 rounded-xl transition">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

    </div>
</body>
</html>
