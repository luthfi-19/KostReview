<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Kos - KostReview</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-wa-bg font-sans antialiased text-wa-text min-h-screen">

    <nav class="bg-wa-darker border-b border-wa-border sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14">
                <div class="flex items-center">
                    <a href="{{ route('owner.dashboard') }}" class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-wa-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        <span class="text-wa-green font-extrabold text-lg">K</span>
                        <span class="text-wa-text font-bold text-lg">KostReview</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 py-8 mb-10">
        <div class="bg-wa-card border border-wa-border rounded-2xl overflow-hidden">
            <div class="bg-wa-darker text-center px-6 py-5 border-b border-wa-border">
                <h4 class="text-lg font-bold text-wa-text">Daftarkan Kos Baru</h4>
                <p class="text-wa-muted text-xs mt-1">Isi data kos kamu di bawah ini.</p>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('kost.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-bold text-wa-muted mb-1.5">Nama Kos</label>
                        <input type="text" class="block w-full rounded-xl border-wa-border bg-wa-darker text-wa-text placeholder-wa-muted shadow-sm focus:border-wa-green focus:ring-wa-green/20 text-sm px-4 py-2.5" id="name" name="name" placeholder="Contoh: Kos Sakura Depok" required>
                        @error('name') <span class="text-wa-red text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="price_per_month" class="block text-sm font-bold text-wa-muted mb-1.5">Harga per Bulan (Rp)</label>
                        <input type="number" class="block w-full rounded-xl border-wa-border bg-wa-darker text-wa-text placeholder-wa-muted shadow-sm focus:border-wa-green focus:ring-wa-green/20 text-sm px-4 py-2.5" id="price_per_month" name="price_per_month" placeholder="Contoh: 1500000" required>
                        @error('price_per_month') <span class="text-wa-red text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="address" class="block text-sm font-bold text-wa-muted mb-1.5">Alamat Lengkap</label>
                        <textarea class="block w-full rounded-xl border-wa-border bg-wa-darker text-wa-text placeholder-wa-muted shadow-sm focus:border-wa-green focus:ring-wa-green/20 text-sm px-4 py-2.5" id="address" name="address" rows="3" placeholder="Masukkan alamat lengkap..." required></textarea>
                        @error('address') <span class="text-wa-red text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-5">
                        <label for="description" class="block text-sm font-bold text-wa-muted mb-1.5">Deskripsi Singkat</label>
                        <textarea class="block w-full rounded-xl border-wa-border bg-wa-darker text-wa-text placeholder-wa-muted shadow-sm focus:border-wa-green focus:ring-wa-green/20 text-sm px-4 py-2.5" id="description" name="description" rows="4" placeholder="Jelaskan keunggulan kos..." required></textarea>
                        @error('description') <span class="text-wa-red text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-wa-muted mb-2">Fasilitas Kos</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach(\App\Models\Facility::all() as $facility)
                                <label class="flex items-center gap-2 text-sm text-wa-text bg-wa-darker border border-wa-border rounded-xl px-3 py-2 cursor-pointer hover:bg-wa-hover transition">
                                    <input type="checkbox" name="facilities[]" value="{{ $facility->id }}" class="rounded border-wa-border bg-wa-darker text-wa-green focus:ring-wa-green/20">
                                    {{ $facility->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-wa-muted mb-2">Kampus Terdekat</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach(\App\Models\Campus::all() as $campus)
                                <label class="flex items-center gap-2 text-sm text-wa-text bg-wa-darker border border-wa-border rounded-xl px-3 py-2 cursor-pointer hover:bg-wa-hover transition">
                                    <input type="checkbox" name="campuses[]" value="{{ $campus->id }}" class="rounded border-wa-border bg-wa-darker text-wa-green focus:ring-wa-green/20">
                                    {{ $campus->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-5 p-4 border border-wa-border rounded-xl bg-wa-darker">
                        <label for="images" class="block text-sm font-bold text-wa-muted mb-2">Upload Foto Kos</label>
                        <input class="block w-full text-sm text-wa-muted file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-wa-green file:text-white hover:file:bg-emerald-600 file:transition" type="file" id="images" name="images[]" multiple accept="image/*">
                        <p class="text-xs text-wa-muted mt-2">JPG, JPEG, PNG. Maks 2MB per foto.</p>
                        @error('images.*') <span class="text-wa-red text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-wa-green hover:bg-emerald-600 text-white font-bold py-3 px-4 rounded-xl text-sm transition">
                        Simpan Data Kos
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
