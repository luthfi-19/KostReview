<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Kos - KostReview</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="max-w-3xl mx-auto px-4 mt-8 mb-10">

        <a href="{{ route('owner.dashboard') }}" class="inline-block border border-gray-400 text-gray-600 hover:bg-gray-100 text-sm font-medium px-3 py-1.5 rounded-lg mb-4 transition">
            &larr; Kembali ke Dashboard
        </a>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="bg-navy text-white text-center px-6 py-4">
                <h4 class="text-lg font-bold">Daftarkan Kos Baru</h4>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('kost.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-bold text-navy mb-1">Nama Kos</label>
                        <input type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" id="name" name="name" placeholder="Contoh: Kos Sakura Depok" required>
                        @error('name') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="price_per_month" class="block text-sm font-bold text-navy mb-1">Harga per Bulan (Rp)</label>
                        <input type="number" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" id="price_per_month" name="price_per_month" placeholder="Contoh: 1500000" required>
                        @error('price_per_month') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="address" class="block text-sm font-bold text-navy mb-1">Alamat Lengkap</label>
                        <textarea class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" id="address" name="address" rows="3" placeholder="Masukkan alamat lengkap kos..." required></textarea>
                        @error('address') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-5">
                        <label for="description" class="block text-sm font-bold text-navy mb-1">Deskripsi Singkat</label>
                        <textarea class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" id="description" name="description" rows="4" placeholder="Jelaskan keunggulan kos ini (contoh: Dekat kampus, akses 24 jam, dll)..." required></textarea>
                        @error('description') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-navy mb-2">Fasilitas Kos (Bisa pilih lebih dari 1)</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach(\App\Models\Facility::all() as $facility)
                                <label class="flex items-center gap-2 text-sm text-gray-600">
                                    <input type="checkbox" name="facilities[]" value="{{ $facility->id }}" class="rounded border-gray-300 text-pink-500 focus:ring-pink-500">
                                    {{ $facility->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-navy mb-2">Kampus Terdekat (Bisa pilih lebih dari 1)</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach(\App\Models\Campus::all() as $campus)
                                <label class="flex items-center gap-2 text-sm text-gray-600">
                                    <input type="checkbox" name="campuses[]" value="{{ $campus->id }}" class="rounded border-gray-300 text-indigo-500 focus:ring-indigo-500">
                                    {{ $campus->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-5 p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <label for="images" class="block text-sm font-bold text-navy mb-2">Upload Foto Kos (Bisa pilih lebih dari 1)</label>
                        <input class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-pink file:text-white hover:file:bg-pink-600" type="file" id="images" name="images[]" multiple accept="image/*">
                        <p class="text-xs text-gray-400 mt-2">Format yang didukung: JPG, JPEG, PNG. Maksimal 2MB per foto.</p>
                        @error('images.*') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-pink hover:bg-pink-600 text-white font-bold py-3 px-4 rounded-lg text-sm transition">
                        Simpan Data Kos
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
