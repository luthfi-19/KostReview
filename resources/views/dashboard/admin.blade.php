<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - KostReview</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                    <span class="bg-cyan-500/15 text-cyan-400 text-[10px] font-bold px-2 py-0.5 rounded-full hidden sm:inline-block">Admin</span>
                </div>
                <div class="hidden md:flex md:items-center md:gap-1">
                    <a href="{{ route('admin.dashboard') }}" class="text-wa-green bg-wa-card text-sm font-bold px-3 py-2 rounded-lg transition">Dashboard</a>
                    <a href="{{ route('admin.campuses.index') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Kampus</a>
                    <a href="{{ route('admin.facilities.index') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Fasilitas</a>
                    <a href="{{ route('admin.users.index') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Users</a>
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
                <a href="{{ route('admin.dashboard') }}" class="block text-wa-green bg-wa-card text-sm font-bold px-3 py-2 rounded-lg transition">Dashboard</a>
                <a href="{{ route('admin.campuses.index') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Kampus</a>
                <a href="{{ route('admin.facilities.index') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Fasilitas</a>
                <a href="{{ route('admin.users.index') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Users</a>
                <div class="border-t border-wa-border my-2"></div>
                <a href="{{ route('profile.info') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Profil</a>
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="w-full text-left bg-wa-red hover:bg-red-600 text-white text-sm font-bold px-3 py-2 rounded-lg transition mt-1">Keluar</button></form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- FLASH --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition class="bg-wa-green/10 border border-wa-green/30 text-wa-green px-4 py-3 rounded-xl flex items-center justify-between mb-6">
                <span class="font-medium text-sm">{{ session('success') }}</span>
                <button @click="show = false" class="text-wa-green/60 hover:text-wa-green ml-3 text-lg">&times;</button>
            </div>
        @endif

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-wa-text">Admin Panel</h1>
            <p class="text-wa-muted text-sm mt-1">Pantau dan kelola seluruh ekosistem KostReview.</p>
        </div>

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-8">
            <div class="bg-wa-card border border-wa-border rounded-2xl p-4 shadow-card">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-500/15 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-wa-muted text-xs">Mahasiswa</p>
                        <p class="text-wa-text font-bold text-xl leading-tight">{{ $totalStudents }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-wa-card border border-wa-border rounded-2xl p-4 shadow-card">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-wa-blue/15 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-wa-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-wa-muted text-xs">Pemilik Kos</p>
                        <p class="text-wa-text font-bold text-xl leading-tight">{{ $totalOwners }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-wa-card border border-wa-border rounded-2xl p-4 shadow-card">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-wa-green/15 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-wa-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <p class="text-wa-muted text-xs">Total Kos</p>
                        <p class="text-wa-text font-bold text-xl leading-tight">{{ $totalKosts }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-wa-card border border-wa-border rounded-2xl p-4 shadow-card">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-wa-yellow/15 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-wa-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </div>
                    <div>
                        <p class="text-wa-muted text-xs">Ulasan</p>
                        <p class="text-wa-text font-bold text-xl leading-tight">{{ $totalReviews }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- QUICK ACTIONS --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-8">
            <a href="{{ route('admin.campuses.index') }}" class="bg-wa-card border border-wa-border hover:border-indigo-500/40 rounded-2xl p-4 flex items-center gap-3 shadow-card hover:shadow-card-hover transition-all group">
                <div class="w-10 h-10 bg-indigo-500/15 rounded-xl flex items-center justify-center group-hover:bg-indigo-500/25 transition">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <p class="text-wa-text font-bold text-sm">Kelola Kampus</p>
                    <p class="text-wa-muted text-xs">Data universitas & institusi</p>
                </div>
            </a>
            <a href="{{ route('admin.facilities.index') }}" class="bg-wa-card border border-wa-border hover:border-wa-blue/40 rounded-2xl p-4 flex items-center gap-3 shadow-card hover:shadow-card-hover transition-all group">
                <div class="w-10 h-10 bg-wa-blue/15 rounded-xl flex items-center justify-center group-hover:bg-wa-blue/25 transition">
                    <svg class="w-5 h-5 text-wa-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <div>
                    <p class="text-wa-text font-bold text-sm">Kelola Fasilitas</p>
                    <p class="text-wa-muted text-xs">Jenis fasilitas kos</p>
                </div>
            </a>
            <a href="{{ route('admin.users.index') }}" class="bg-wa-card border border-wa-border hover:border-wa-yellow/40 rounded-2xl p-4 flex items-center gap-3 shadow-card hover:shadow-card-hover transition-all group">
                <div class="w-10 h-10 bg-wa-yellow/15 rounded-xl flex items-center justify-center group-hover:bg-wa-yellow/25 transition">
                    <svg class="w-5 h-5 text-wa-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <p class="text-wa-text font-bold text-sm">Kelola Users</p>
                    <p class="text-wa-muted text-xs">Semua pengguna terdaftar</p>
                </div>
            </a>
        </div>

        {{-- MODERATION TABLE --}}
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-wa-text flex items-center gap-2">
                    <span class="w-2 h-2 bg-wa-red rounded-full"></span>
                    Moderasi Kos
                </h2>
                @if($kosts->count() > 0)
                    <span class="bg-wa-red/15 text-wa-red text-xs font-bold px-2.5 py-1 rounded-full">{{ $kosts->count() }} total</span>
                @endif
            </div>

            @if($kosts->isEmpty())
                <div class="bg-wa-card border border-wa-border rounded-2xl p-8 text-center">
                    <div class="w-12 h-12 mx-auto bg-wa-darker rounded-xl flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-wa-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-wa-muted text-sm">Belum ada data kos untuk dimoderasi.</p>
                </div>
            @else
                {{-- Mobile card view --}}
                <div class="sm:hidden space-y-3">
                    @foreach($kosts as $kost)
                        <div class="bg-wa-card border border-wa-border rounded-2xl p-4 shadow-card">
                            <div class="flex items-start gap-3 mb-3">
                                @if($kost->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $kost->images->first()->image_path) }}" class="w-12 h-12 object-cover rounded-xl shrink-0" alt="Foto Kos">
                                @else
                                    <div class="w-12 h-12 bg-wa-darker rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-wa-border" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-wa-text font-bold text-sm truncate">{{ $kost->name }}</p>
                                    <p class="text-wa-muted text-xs">{{ $kost->user->name }} &middot; Rp {{ number_format($kost->price_per_month, 0, ',', '.') }}/bln</p>
                                </div>
                            </div>
                            <p class="text-wa-muted text-xs mb-3 line-clamp-2">{{ $kost->address }}</p>
                            <form action="{{ route('admin.kost.destroy', $kost->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kos ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full border border-wa-red/40 text-wa-red hover:bg-wa-red/10 text-xs font-bold py-2 rounded-xl transition">Hapus (Take Down)</button>
                            </form>
                        </div>
                    @endforeach
                </div>

                {{-- Desktop table view --}}
                <div class="hidden sm:block bg-wa-card border border-wa-border rounded-2xl overflow-hidden shadow-card">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-wa-border">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 text-left text-[11px] font-bold text-wa-muted uppercase tracking-wider">Kos</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-bold text-wa-muted uppercase tracking-wider">Pemilik</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-bold text-wa-muted uppercase tracking-wider">Harga/Bulan</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-bold text-wa-muted uppercase tracking-wider">Alamat</th>
                                    <th class="px-5 py-3 text-center text-[11px] font-bold text-wa-muted uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-wa-border">
                                @foreach($kosts as $kost)
                                    <tr class="hover:bg-wa-hover/50 transition-colors">
                                        <td class="px-5 py-3">
                                            <div class="flex items-center gap-3">
                                                @if($kost->images->isNotEmpty())
                                                    <img src="{{ asset('storage/' . $kost->images->first()->image_path) }}" class="w-10 h-10 object-cover rounded-xl" alt="Foto Kos">
                                                @else
                                                    <div class="w-10 h-10 bg-wa-darker rounded-xl flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-wa-border" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                                                    </div>
                                                @endif
                                                <span class="text-wa-text font-bold text-sm">{{ $kost->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3">
                                            <span class="bg-wa-darker text-wa-muted text-xs font-medium px-2.5 py-1 rounded-full">{{ $kost->user->name }}</span>
                                        </td>
                                        <td class="px-5 py-3 text-sm text-wa-green font-bold">Rp {{ number_format($kost->price_per_month, 0, ',', '.') }}</td>
                                        <td class="px-5 py-3 text-xs text-wa-muted max-w-[200px] truncate">{{ $kost->address }}</td>
                                        <td class="px-5 py-3 text-center">
                                            <form action="{{ route('admin.kost.destroy', $kost->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kos ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="border border-wa-red/40 text-wa-red hover:bg-wa-red/10 text-xs font-bold px-3 py-1.5 rounded-xl transition">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </section>

    </div>
</body>
</html>
