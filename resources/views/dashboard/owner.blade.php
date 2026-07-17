<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Owner Dashboard - KostReview</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    <nav class="bg-navy shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a class="text-lg font-bold text-white" href="#">KostReview Owner</a>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="border border-white/50 text-white hover:bg-white/10 text-xs px-3 py-1.5 rounded-lg transition">Logout</button>
            </form>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 mt-8">

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="bg-green-50 text-green-800 px-4 py-3 rounded-lg shadow-sm flex items-center justify-between mb-4">
                <span class="font-bold">🎉 {{ session('success') }}</span>
                <button @click="show = false" class="text-green-600 hover:text-green-800 ml-3">&times;</button>
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Halo, {{ Auth::user()->name }}! 🏢</h2>
                <p class="text-gray-500 text-sm mt-1">Kelola properti kosan lu dengan mudah di sini.</p>
            </div>
            <div class="mt-3 md:mt-0">
                <a href="{{ route('kost.create') }}" class="inline-block bg-pink hover:bg-pink-600 text-white font-bold px-4 py-2 rounded-lg shadow-sm text-sm transition">
                    + Tambah Data Kos Baru
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm mb-8 border-l-4 border-pink">
            <div class="px-6 py-3 border-b border-gray-100">
                <span class="text-sm font-bold text-pink">🔔 Pengajuan Sewa Baru (Perlu Tindakan)</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Calon Penghuni</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mendaftar di Kos</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($occupancies as $occupancy)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 text-sm text-gray-500">{{ $occupancy->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-3 text-sm font-bold text-navy">{{ $occupancy->user->name }}</td>
                                <td class="px-6 py-3 text-sm">{{ $occupancy->kost->name }}</td>
                                <td class="px-6 py-3 text-center">
                                    <div class="flex justify-center gap-2">
                                        <form action="{{ route('owner.occupancy.approve', $occupancy->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">Terima</button>
                                        </form>
                                        <form action="{{ route('owner.occupancy.reject', $occupancy->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="border border-red-500 text-red-500 hover:bg-red-50 text-xs font-bold px-3 py-1.5 rounded-lg transition">Tolak</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada pengajuan sewa baru saat ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm">
            <div class="bg-navy text-white px-6 py-3 text-sm font-bold">
                Daftar Kosan Milik Lu
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[5%]">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[15%]">Foto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[20%]">Nama Kos</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[15%]">Harga / Bulan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[25%]">Alamat</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase w-[20%]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($kosts as $index => $kost)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    @if($kost->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $kost->images->first()->image_path) }}" alt="Foto Kos" class="w-14 h-14 object-cover rounded-lg">
                                    @else
                                        <span class="text-gray-400 text-xs">No Image</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm font-bold text-navy">{{ $kost->name }}</td>
                                <td class="px-4 py-3 text-sm text-pink font-bold">Rp {{ number_format($kost->price_per_month, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ Str::limit($kost->address, 50) }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('kost.edit', $kost->id) }}" class="border border-indigo-500 text-indigo-500 hover:bg-indigo-50 text-xs font-medium px-3 py-1.5 rounded-lg transition">Edit</a>
                                        <form action="{{ route('kost.destroy', $kost->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus data kos ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="border border-red-500 text-red-500 hover:bg-red-50 text-xs font-medium px-3 py-1.5 rounded-lg transition">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-400 text-sm">Belum ada kosan yang lu daftarin, bang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>
