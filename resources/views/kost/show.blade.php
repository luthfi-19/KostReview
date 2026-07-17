<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Kos - {{ $kost->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>.carousel-img { height: 400px; object-fit: cover; border-radius: 16px; }</style>
</head>
<body class="bg-wa-bg font-sans antialiased text-wa-text min-h-screen">

    <nav class="bg-wa-darker border-b border-wa-border sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-wa-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        <span class="text-wa-green font-extrabold text-lg">K</span>
                        <span class="text-wa-text font-bold text-lg">KostReview</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 mb-10">
        <div class="flex flex-col lg:flex-row gap-6">

            {{-- Kolom Kiri: Gambar --}}
            <div class="w-full lg:w-7/12">
                <div class="bg-wa-card border border-wa-border rounded-2xl overflow-hidden">
                    @if($kost->images->isNotEmpty())
                        <div x-data="{ active: 0 }" class="relative">
                            <div class="overflow-hidden rounded-2xl">
                                @foreach($kost->images as $index => $image)
                                    <img x-show="active === {{ $index }}" src="{{ asset('storage/' . $image->image_path) }}" class="w-full carousel-img" alt="Foto Kos">
                                @endforeach
                            </div>
                            @if($kost->images->count() > 1)
                                <button @click="active = active > 0 ? active - 1 : {{ $kost->images->count() - 1 }}" class="absolute left-3 top-1/2 -translate-y-1/2 bg-wa-darker/80 hover:bg-wa-darker rounded-full w-9 h-9 flex items-center justify-center shadow text-wa-text transition">&lsaquo;</button>
                                <button @click="active = active < {{ $kost->images->count() - 1 }} ? active + 1 : 0" class="absolute right-3 top-1/2 -translate-y-1/2 bg-wa-darker/80 hover:bg-wa-darker rounded-full w-9 h-9 flex items-center justify-center shadow text-wa-text transition">&rsaquo;</button>
                                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 bg-wa-darker/80 text-wa-text text-xs font-bold px-3 py-1 rounded-full">
                                    <span x-text="active + 1"></span> / {{ $kost->images->count() }}
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="bg-wa-darker text-wa-muted flex items-center justify-center rounded-2xl" style="height: 400px;">
                            <div class="text-center">
                                <svg class="w-16 h-16 mx-auto mb-3 text-wa-border" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                Foto belum tersedia
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Kolom Kanan: Info --}}
            <div class="w-full lg:w-5/12">
                <div class="bg-wa-card border border-wa-border rounded-2xl h-full p-6">
                    <h2 class="text-2xl font-extrabold text-wa-text mb-1">{{ $kost->name }}</h2>
                    <h3 class="text-wa-green font-bold text-xl mb-4">
                        Rp {{ number_format($kost->price_per_month, 0, ',', '.') }} <span class="text-sm text-wa-muted font-normal">/ bulan</span>
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <h5 class="font-bold text-wa-muted text-xs uppercase tracking-wider mb-1">Alamat</h5>
                            <p class="text-wa-text text-sm">{{ $kost->address }}</p>
                        </div>

                        <div>
                            <h6 class="font-bold text-wa-muted text-xs uppercase tracking-wider mb-2">Fasilitas</h6>
                            <div class="flex flex-wrap gap-2">
                                @forelse($kost->facilities as $facility)
                                    <span class="bg-wa-blue/10 text-wa-blue border border-wa-blue/20 text-xs font-semibold px-3 py-1.5 rounded-xl">
                                        {{ $facility->name }}
                                    </span>
                                @empty
                                    <span class="text-wa-muted italic text-xs">Belum ada info fasilitas.</span>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <h6 class="font-bold text-wa-muted text-xs uppercase tracking-wider mb-2">Kampus Terdekat</h6>
                            <div class="flex flex-wrap gap-2">
                                @forelse($kost->campuses as $campus)
                                    <span class="bg-wa-green/10 text-wa-green border border-wa-green/20 text-xs font-semibold px-3 py-1.5 rounded-xl">
                                        {{ $campus->name }}
                                    </span>
                                @empty
                                    <span class="text-wa-muted italic text-xs">Belum ada info kampus.</span>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <h5 class="font-bold text-wa-muted text-xs uppercase tracking-wider mb-1">Deskripsi</h5>
                            <p class="text-wa-text text-sm whitespace-pre-line">{{ $kost->description }}</p>
                        </div>
                    </div>

                    <hr class="my-5 border-wa-border">

                    @if (session('success'))
                        <div class="bg-wa-green/10 border border-wa-green/30 text-wa-green rounded-xl px-4 py-3 text-sm mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-wa-red/10 border border-wa-red/30 text-wa-red rounded-xl px-4 py-3 text-sm mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('student.occupancy.store', $kost->id) }}" method="POST" class="mb-6">
                        @csrf
                        <button type="submit" class="w-full bg-wa-green hover:bg-emerald-600 text-white font-bold py-3 px-4 rounded-xl text-sm transition">
                            Ajukan Sewa / Hunian
                        </button>
                    </form>

                    <hr class="my-6 border-wa-border">

                    <h4 class="font-bold text-wa-text mb-4 text-base">Ulasan Penghuni</h4>

                    <div class="mb-4 space-y-3">
                        @forelse($kost->reviews as $review)
                            <div class="bg-wa-darker rounded-xl p-3">
                                <div class="flex justify-between items-center">
                                    <strong class="text-wa-text text-sm">{{ $review->user->name }}</strong>
                                    <span class="text-wa-yellow font-bold text-sm">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating) ★ @else ☆ @endif
                                        @endfor
                                    </span>
                                </div>
                                <p class="text-wa-muted text-xs mt-1">{{ $review->comment }}</p>
                            </div>
                        @empty
                            <p class="text-wa-muted italic text-sm">Belum ada ulasan. Jadilah yang pertama!</p>
                        @endforelse
                    </div>

                    <div class="border border-wa-border rounded-2xl p-4">
                        <h6 class="font-bold text-wa-green mb-3 text-sm">Tulis Ulasan</h6>
                        <form action="{{ route('student.review.store', $kost->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-xs font-bold text-wa-muted mb-1">Rating</label>
                                <select name="rating" class="block w-full rounded-xl border-wa-border bg-wa-darker text-wa-text text-sm focus:border-wa-green focus:ring-wa-green/20" required>
                                    <option value="5">★★★★★ (Sangat Bagus)</option>
                                    <option value="4">★★★★ (Bagus)</option>
                                    <option value="3">★★★ (Lumayan)</option>
                                    <option value="2">★★ (Kurang)</option>
                                    <option value="1">★ (Parah)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-xs font-bold text-wa-muted mb-1">Komentar</label>
                                <textarea name="comment" class="block w-full rounded-xl border-wa-border bg-wa-darker text-wa-text text-sm focus:border-wa-green focus:ring-wa-green/20" rows="3" placeholder="Gimana rasanya ngekos di sini?" required></textarea>
                            </div>
                            <button type="submit" class="bg-wa-green hover:bg-emerald-600 text-white text-xs font-bold px-4 py-2 rounded-xl transition">Kirim Ulasan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
