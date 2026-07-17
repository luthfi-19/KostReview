<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil - KostReview</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-wa-bg font-sans antialiased text-wa-text min-h-screen">
    <nav class="bg-wa-darker border-b border-wa-border sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <span class="text-wa-green font-extrabold text-lg">K</span>
                        <span class="text-wa-text font-bold text-lg">KostReview</span>
                    </a>
                </div>
                <div class="flex items-center">
                    @if(auth()->user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Kembali</a>
                    @elseif(auth()->user()->role == 'owner')
                        <a href="{{ route('owner.dashboard') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Kembali</a>
                    @else
                        <a href="{{ route('home') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Kembali</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-sm">
            <div class="bg-wa-card border border-wa-border rounded-2xl text-center overflow-hidden shadow-card">
                <div class="bg-gradient-to-br from-wa-green to-emerald-600 rounded-t-2xl h-28"></div>
                <div class="px-8 pb-8 -mt-14">
                    <div class="mb-3 inline-block">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=00A884&color=111B21&size=120&bold=true" class="w-24 h-24 rounded-full border-5 shadow-lg" alt="Avatar" style="border: 5px solid #1F2C34; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
                    </div>

                    <h3 class="text-xl font-bold text-wa-text mb-0">{{ auth()->user()->name }}</h3>
                    <p class="text-wa-muted text-sm mb-4"><i class="fa-regular fa-envelope mr-1"></i>{{ auth()->user()->email }}</p>

                    <div class="mb-4">
                        @if(auth()->user()->role == 'admin')
                            <span class="inline-flex items-center bg-wa-red/15 text-wa-red text-xs font-semibold px-4 py-2 rounded-full"><i class="fa-solid fa-crown mr-1"></i> Admin Sistem</span>
                        @elseif(auth()->user()->role == 'owner')
                            <span class="inline-flex items-center bg-wa-blue/15 text-wa-blue text-xs font-semibold px-4 py-2 rounded-full"><i class="fa-solid fa-house-user mr-1"></i> Pemilik Kos</span>
                        @else
                            <span class="inline-flex items-center bg-wa-green/15 text-wa-green text-xs font-semibold px-4 py-2 rounded-full"><i class="fa-solid fa-user-graduate mr-1"></i> Mahasiswa</span>
                        @endif
                    </div>

                    <hr class="border-wa-border mb-4">

                    <div class="flex justify-center gap-3">
                        @if(auth()->user()->role == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="bg-wa-darker border border-wa-border text-wa-text hover:bg-wa-hover rounded-xl px-4 py-2 text-sm font-medium transition">Kembali</a>
                        @elseif(auth()->user()->role == 'owner')
                            <a href="{{ route('owner.dashboard') }}" class="bg-wa-darker border border-wa-border text-wa-text hover:bg-wa-hover rounded-xl px-4 py-2 text-sm font-medium transition">Kembali</a>
                        @else
                            <a href="{{ route('home') }}" class="bg-wa-darker border border-wa-border text-wa-text hover:bg-wa-hover rounded-xl px-4 py-2 text-sm font-medium transition">Kembali</a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-wa-red hover:bg-red-600 text-white rounded-xl px-4 py-2 text-sm font-medium transition">
                                <i class="fa-solid fa-right-from-bracket mr-1"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <span class="text-wa-muted text-xs">Anggota sejak: {{ auth()->user()->created_at->translatedFormat('d F Y') }}</span>
            </div>
        </div>
    </div>
</body>
</html>
