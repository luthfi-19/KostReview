<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Informasi Akun - KostReview</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-sm">
            <div class="bg-white rounded-2xl shadow-lg text-center overflow-hidden">

                <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-t-2xl h-28"></div>

                <div class="px-8 pb-8 -mt-14">
                    <div class="mb-3 inline-block">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=EC4899&color=fff&size=120&bold=true" class="w-24 h-24 rounded-full border-5 border-white shadow-lg" alt="Avatar" style="border: 5px solid white; box-shadow: 0 10px 20px rgba(236,72,153,0.2);">
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-0">{{ auth()->user()->name }}</h3>
                    <p class="text-gray-500 text-sm mb-4"><i class="fa-regular fa-envelope mr-1"></i>{{ auth()->user()->email }}</p>

                    <div class="mb-4">
                        @if(auth()->user()->role == 'admin')
                            <span class="inline-flex items-center bg-red-100 text-red-700 text-xs font-semibold px-4 py-2 rounded-full shadow-sm"><i class="fa-solid fa-crown mr-1"></i> Admin Sistem</span>
                        @elseif(auth()->user()->role == 'owner')
                            <span class="inline-flex items-center bg-indigo-100 text-indigo-700 text-xs font-semibold px-4 py-2 rounded-full shadow-sm"><i class="fa-solid fa-house-user mr-1"></i> Pemilik Kos</span>
                        @else
                            <span class="inline-flex items-center bg-green-100 text-green-700 text-xs font-semibold px-4 py-2 rounded-full shadow-sm"><i class="fa-solid fa-user-graduate mr-1"></i> Mahasiswa</span>
                        @endif
                    </div>

                    <hr class="border-gray-200 mb-4">

                    <div class="flex justify-center gap-3">
                        @if(auth()->user()->role == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-full px-4 py-2 text-sm font-medium shadow-sm transition">Kembali</a>
                        @elseif(auth()->user()->role == 'owner')
                            <a href="{{ route('owner.dashboard') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-full px-4 py-2 text-sm font-medium shadow-sm transition">Kembali</a>
                        @else
                            <a href="{{ route('home') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-full px-4 py-2 text-sm font-medium shadow-sm transition">Kembali</a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-pink hover:bg-pink-600 text-white rounded-full px-4 py-2 text-sm font-medium shadow-sm transition">
                                <i class="fa-solid fa-right-from-bracket mr-1"></i> Keluar
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            <div class="text-center mt-4">
                <span class="text-gray-400 text-xs">Anggota terdaftar sejak: {{ auth()->user()->created_at->translatedFormat('d F Y') }}</span>
            </div>
        </div>
    </div>

</body>
</html>
