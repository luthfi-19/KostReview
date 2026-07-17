<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Kos - KostReview</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="max-w-3xl mx-auto px-4 mt-8 mb-10">

        <a href="{{ route('owner.dashboard') }}" class="inline-block border border-gray-400 text-gray-600 hover:bg-gray-100 text-sm font-medium px-3 py-1.5 rounded-lg mb-4 transition">
            &larr; Kembali ke Dashboard
        </a>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="bg-navy text-white text-center px-6 py-4">
                <h4 class="text-lg font-bold">Edit Data Kos</h4>
            </div>
            <div class="p-6">
                <form action="{{ route('kost.update', $kost->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-bold text-navy mb-1">Nama Kos</label>
                        <input type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" id="name" name="name" value="{{ old('name', $kost->name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="price_per_month" class="block text-sm font-bold text-navy mb-1">Harga per Bulan (Rp)</label>
                        <input type="number" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" id="price_per_month" name="price_per_month" value="{{ old('price_per_month', $kost->price_per_month) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="address" class="block text-sm font-bold text-navy mb-1">Alamat Lengkap</label>
                        <textarea class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" id="address" name="address" rows="3" required>{{ old('address', $kost->address) }}</textarea>
                    </div>

                    <div class="mb-5">
                        <label for="description" class="block text-sm font-bold text-navy mb-1">Deskripsi Singkat</label>
                        <textarea class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" id="description" name="description" rows="4" required>{{ old('description', $kost->description) }}</textarea>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-navy mb-2">Fasilitas Kos (Bisa pilih lebih dari 1)</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach(\App\Models\Facility::all() as $facility)
                                <label class="flex items-center gap-2 text-sm text-gray-600">
                                    <input type="checkbox" name="facilities[]" value="{{ $facility->id }}" class="rounded border-gray-300 text-pink-500 focus:ring-pink-500"
                                        {{ $kost->facilities->contains($facility->id) ? 'checked' : '' }}>
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
                                    <input type="checkbox" name="campuses[]" value="{{ $campus->id }}" class="rounded border-gray-300 text-indigo-500 focus:ring-indigo-500"
                                        {{ $kost->campuses->contains($campus->id) ? 'checked' : '' }}>
                                    {{ $campus->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    @if($kost->images->isNotEmpty())
                        <div class="mb-5 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <label class="block text-sm font-bold text-navy mb-3">Foto Saat Ini (Centang untuk menghapus):</label>
                            <div class="flex flex-wrap gap-3">
                                @foreach($kost->images as $img)
                                    <div class="text-center">
                                        <img src="{{ asset('storage/' . $img->image_path) }}" class="w-28 h-28 object-cover rounded-lg shadow-sm mb-2">
                                        <label class="flex items-center justify-center gap-1 cursor-pointer">
                                            <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="rounded border-red-400 text-red-500 focus:ring-red-500 cursor-pointer">
                                            <span class="text-red-600 text-xs font-bold cursor-pointer">Hapus Foto</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-navy mb-1">Upload Foto Tambahan (Bisa pilih lebih dari 1)</label>
                        <input type="file" name="images[]" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-pink file:text-white hover:file:bg-pink-600" multiple accept="image/*">
                        <small class="text-gray-400 text-xs">Format yang didukung: JPG, JPEG, PNG. Maksimal 2MB per foto. Biarkan kosong jika tidak ingin menambah foto.</small>
                    </div>

                    <button type="submit" class="w-full bg-pink hover:bg-pink-600 text-white font-bold py-3 px-4 rounded-lg text-sm transition">
                        Update Data Kos
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
