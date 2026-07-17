<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pencarian Kos - KostReview</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    <nav class="bg-navy shadow-sm mb-4">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a class="text-lg font-bold text-white" href="{{ route('home') }}">KostReview</a>
            <div class="flex items-center gap-2">
                @auth
                    <span class="text-white text-sm hidden md:block mr-2">Halo, {{ Auth::user()->name }} 👋</span>

                    <a href="{{ route('profile.info') }}" class="border border-white/50 text-white hover:bg-white/10 text-xs font-bold px-3 py-1.5 rounded-lg transition">
                        Profil
                    </a>

                    @if(Auth::user()->role === 'owner')
                        <a href="{{ route('owner.dashboard') }}" class="border border-white/50 text-white hover:bg-white/10 text-xs px-3 py-1.5 rounded-lg transition">Dashboard Owner</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="bg-pink hover:bg-pink-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="border border-white/50 text-white hover:bg-white/10 text-xs font-bold px-3 py-1.5 rounded-lg transition">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-pink hover:bg-pink-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 mb-10">

        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-navy">Temukan Kos Impianmu ✨</h2>
            <p class="text-gray-500 text-sm mb-3">Jelajahi berbagai pilihan kos terbaik di sekitar kampus.</p>

            @auth
                @if(Auth::user()->role === 'student')
                <a href="{{ route('student.occupancy.index') }}" class="inline-block bg-pink hover:bg-pink-600 text-white font-bold px-4 py-2 rounded-lg shadow-sm text-sm transition">
                    Lihat Status Pengajuan Saya
                </a>
                @endif
            @endauth
        </div>

        <div class="flex justify-center mb-8">
            <div class="w-full max-w-xl">
                <form action="{{ route('home') }}" method="GET">
                    <div class="flex border-2 border-pink rounded-xl overflow-hidden shadow-sm">
                        <input type="text" name="search" class="flex-1 min-w-0 px-4 py-3 text-sm border-0 focus:ring-0" placeholder="Cari nama atau lokasi kos..." value="{{ request('search') }}">

                        <select name="campus_id" class="border-l border-gray-200 bg-gray-50 text-sm px-3 py-3 max-w-[35%] focus:ring-0 focus:border-transparent">
                            <option value="">🏫 Semua Kampus</option>
                            @foreach($campuses as $campus)
                                <option value="{{ $campus->id }}" {{ request('campus_id') == $campus->id ? 'selected' : '' }}>
                                    Dekat {{ $campus->name }}
                                </option>
                            @endforeach
                        </select>

                        <button class="bg-pink hover:bg-pink-600 text-white font-bold px-5 py-3 text-sm transition" type="submit">Cari</button>
                    </div>
                </form>

                @if(request('search') && $kosts->isEmpty())
                    <p class="text-red-600 text-center mt-3 font-bold text-sm">
                        Yah, kos dengan kata kunci "{{ request('search') }}" nggak ketemu, bang.
                    </p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($kosts as $kost)
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex flex-col">

                    @if($kost->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $kost->images->first()->image_path) }}" class="w-full h-48 object-cover" alt="Foto Kos">
                    @else
                        <div class="w-full h-48 bg-gray-300 flex items-center justify-center text-white text-sm">
                            No Image Available
                        </div>
                    @endif

                    <div class="p-4 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-1">
                            <h5 class="text-lg font-bold text-navy">{{ $kost->name }}</h5>
                        </div>

                        <p class="text-pink font-bold text-sm mb-2">
                            Rp {{ number_format($kost->price_per_month, 0, ',', '.') }} <span class="text-gray-400 font-normal text-xs">/ bulan</span>
                        </p>

                        <p class="text-gray-500 text-sm mb-3 flex-1">
                            {{ Str::limit($kost->description, 80) }}
                        </p>

                        <p class="text-gray-500 text-xs mb-3">
                            📍 {{ Str::limit($kost->address, 40) }}
                        </p>

                        <a href="{{ route('kost.show', $kost->id) }}" class="block text-center border border-navy text-navy hover:bg-navy hover:text-white font-bold text-sm py-2 rounded-lg transition">
                            Lihat Detail & Review
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <h4 class="text-gray-400 text-lg">Yah, belum ada kosan yang terdaftar nih 😢</h4>
                    <p class="text-gray-400 text-sm mt-1">Coba kembali lagi nanti ya!</p>
                </div>
            @endforelse
        </div>

    </div>
</body>
</html>
