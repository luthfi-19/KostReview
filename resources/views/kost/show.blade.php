<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Kos - {{ $kost->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .carousel-img { height: 400px; object-fit: cover; border-radius: 12px; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <nav class="bg-navy shadow-sm mb-4">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <a class="text-lg font-bold text-white" href="{{ route('home') }}">
                &larr; Kembali ke Pencarian
            </a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 mb-10">
        <div class="flex flex-col lg:flex-row gap-6">

            {{-- Kolom Kiri: Gambar --}}
            <div class="w-full lg:w-7/12">
                <div class="bg-white rounded-xl shadow-sm p-2">
                    @if($kost->images->isNotEmpty())
                        <div x-data="{ active: 0 }" class="relative">
                            <div class="overflow-hidden rounded-xl">
                                @foreach($kost->images as $index => $image)
                                    <img x-show="active === {{ $index }}" src="{{ asset('storage/' . $image->image_path) }}" class="w-full carousel-img" alt="Foto Kos">
                                @endforeach
                            </div>
                            @if($kost->images->count() > 1)
                                <button @click="active = active > 0 ? active - 1 : {{ $kost->images->count() - 1 }}" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full w-8 h-8 flex items-center justify-center shadow text-gray-700">&lsaquo;</button>
                                <button @click="active = active < {{ $kost->images->count() - 1 }} ? active + 1 : 0" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full w-8 h-8 flex items-center justify-center shadow text-gray-700">&rsaquo;</button>
                            @endif
                        </div>
                    @else
                        <div class="bg-gray-300 text-white flex items-center justify-center rounded-xl" style="height: 400px;">
                            <h3>Foto belum tersedia</h3>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Kolom Kanan: Info --}}
            <div class="w-full lg:w-5/12">
                <div class="bg-white rounded-xl shadow-sm h-full p-6">
                    <h2 class="text-2xl font-bold text-navy mb-1">{{ $kost->name }}</h2>
                    <h3 class="text-pink font-bold text-xl mb-4">
                        Rp {{ number_format($kost->price_per_month, 0, ',', '.') }} <span class="text-sm text-gray-400 font-normal">/ bulan</span>
                    </h3>

                    <h5 class="font-bold text-navy mt-4 mb-1 text-sm">📍 Alamat Lengkap</h5>
                    <p class="text-gray-500 text-sm">{{ $kost->address }}</p>

                    <h6 class="font-bold text-navy mt-4 mb-2 text-sm">✨ Fasilitas Tersedia</h6>
                    <div class="flex flex-wrap gap-2 mb-4">
                        @forelse($kost->facilities as $facility)
                            <span class="bg-blue-50 text-navy border border-blue-200 text-xs font-semibold px-3 py-1.5 rounded-lg">
                                ✓ {{ $facility->name }}
                            </span>
                        @empty
                            <span class="text-gray-400 italic text-xs">Belum ada informasi fasilitas.</span>
                        @endforelse
                    </div>

                    <h6 class="font-bold text-navy mt-4 mb-2 text-sm">🎓 Kampus Terdekat</h6>
                    <div class="flex flex-wrap gap-2 mb-4">
                        @forelse($kost->campuses as $campus)
                            <span class="bg-navy text-white text-xs font-semibold px-3 py-1.5 rounded-lg shadow-sm">
                                📍 {{ $campus->name }}
                            </span>
                        @empty
                            <span class="text-gray-400 italic text-xs">Belum ada informasi kampus terdekat.</span>
                        @endforelse
                    </div>

                    <h5 class="font-bold text-navy mt-4 mb-1 text-sm">📝 Deskripsi Kos</h5>
                    <p class="text-gray-500 text-sm whitespace-pre-line">{{ $kost->description }}</p>

                    <hr class="my-4 border-gray-200">

                    @if (session('success'))
                        <div class="bg-green-50 text-green-800 rounded-lg px-4 py-3 text-sm mt-3">
                            ✅ {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-50 text-red-800 rounded-lg px-4 py-3 text-sm mt-3">
                            ⚠️ {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('student.occupancy.store', $kost->id) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full bg-pink hover:bg-pink-600 text-white font-bold py-3 px-4 rounded-lg text-sm transition">
                            Ajukan Sewa / Hunian
                        </button>
                    </form>
                    <hr class="my-8 border-gray-200">

                    <h4 class="font-bold text-navy mb-4 text-base">⭐ Ulasan Penghuni</h4>

                    <div class="mb-4 space-y-3">
                        @forelse($kost->reviews as $review)
                            <div class="bg-gray-50 rounded-xl p-3">
                                <div class="flex justify-between items-center">
                                    <strong class="text-navy text-sm">{{ $review->user->name }}</strong>
                                    <span class="text-yellow-500 font-bold text-sm">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating) ★ @else ☆ @endif
                                        @endfor
                                    </span>
                                </div>
                                <p class="text-gray-500 text-xs mt-1">{{ $review->comment }}</p>
                            </div>
                        @empty
                            <p class="text-gray-400 italic text-sm">Belum ada ulasan untuk kos ini. Jadilah yang pertama!</p>
                        @endforelse
                    </div>

                    <div class="border border-pink rounded-xl p-4">
                        <h6 class="font-bold text-pink mb-3 text-sm">Tulis Ulasan Lu</h6>
                        <form action="{{ route('student.review.store', $kost->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-xs font-bold text-gray-600 mb-1">Rating Bintang (1-5)</label>
                                <select name="rating" class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="5">⭐⭐⭐⭐⭐ (Sangat Bagus)</option>
                                    <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                                    <option value="3">⭐⭐⭐ (Lumayan)</option>
                                    <option value="2">⭐⭐ (Kurang)</option>
                                    <option value="1">⭐ (Parah)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-xs font-bold text-gray-600 mb-1">Komentar</label>
                                <textarea name="comment" class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="3" placeholder="Gimana rasanya ngekos di sini?" required></textarea>
                            </div>
                            <button type="submit" class="bg-pink hover:bg-pink-600 text-white text-xs font-bold px-4 py-2 rounded-lg transition">Kirim Ulasan</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
