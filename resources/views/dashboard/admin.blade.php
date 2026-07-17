<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - KostReview</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    <nav class="bg-slate-900 shadow-sm mb-6">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a class="text-lg font-bold text-cyan-400" href="#">👑 KOSTREVIEW ADMIN PANEL</a>
            <div class="flex items-center gap-3">
                <span class="text-white text-sm hidden md:block">Mode Super Admin: <strong>{{ Auth::user()->name }}</strong> ⚙️</span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 mb-10">

        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000" class="bg-green-50 text-green-800 px-4 py-3 rounded-lg shadow-sm flex items-center justify-between mb-4">
                <span>🔥 <strong>Sistem Berhasil:</strong> {{ session('success') }}</span>
                <button @click="show = false" class="text-green-600 hover:text-green-800 ml-3">&times;</button>
            </div>
        @endif

        <div class="flex flex-wrap gap-3 mb-6">
            <a href="{{ route('admin.campuses.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-4 py-2 rounded-lg shadow-sm transition">🎓 Kelola Data Kampus</a>
            <a href="{{ route('admin.facilities.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-bold px-4 py-2 rounded-lg shadow-sm transition">✨ Kelola Data Fasilitas</a>
            <a href="{{ route('admin.users.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 text-sm font-bold px-4 py-2 rounded-lg shadow-sm transition">👥 Kelola Data User</a>
        </div>

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Ringkasan Ekosistem Aplikasi 📊</h2>
            <p class="text-gray-500 text-sm mt-1">Pantau jumlah data terdaftar dan kelola moderasi konten iklan kosan.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
            <div class="bg-indigo-600 text-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-4">
                    <h6 class="text-xs font-bold uppercase opacity-75">Total Mahasiswa</h6>
                    <h2 class="text-2xl font-bold mt-1">{{ $totalStudents }} Orang</h2>
                </div>
            </div>
            <div class="bg-blue-500 text-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-4">
                    <h6 class="text-xs font-bold uppercase opacity-75">Total Pemilik Kos</h6>
                    <h2 class="text-2xl font-bold mt-1">{{ $totalOwners }} Orang</h2>
                </div>
            </div>
            <div class="bg-green-600 text-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-4">
                    <h6 class="text-xs font-bold uppercase opacity-75">Total Kos Iklan</h6>
                    <h2 class="text-2xl font-bold mt-1">{{ $totalKosts }} Kamar</h2>
                </div>
            </div>
            <div class="bg-yellow-400 text-gray-900 rounded-xl shadow-sm overflow-hidden">
                <div class="p-4">
                    <h6 class="text-xs font-bold uppercase opacity-75">Total Ulasan/Review</h6>
                    <h2 class="text-2xl font-bold mt-1">{{ $totalReviews }} Ulasan</h2>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="bg-slate-900 text-white px-6 py-3">
                <h5 class="text-sm font-bold">🛡️ Moderasi & Pengawasan Iklan Kos Global</h5>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-center">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase">Foto</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase">Nama Kos</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase">Pemilik (Owner)</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase">Harga / Bulan</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase">Alamat</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase">Aksi Pemblokiran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($kosts as $index => $kost)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    @if($kost->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $kost->images->first()->image_path) }}" class="w-14 h-14 object-cover rounded-lg" alt="Foto Kos">
                                    @else
                                        <span class="text-gray-400 text-xs">No Photo</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm font-bold text-navy">{{ $kost->name }}</td>
                                <td class="px-4 py-3"><span class="bg-gray-200 text-gray-700 text-xs font-medium px-2 py-1 rounded-full">{{ $kost->user->name }}</span></td>
                                <td class="px-4 py-3 text-sm text-green-600 font-bold">Rp {{ number_format($kost->price_per_month, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-xs text-gray-500 text-left max-w-[250px]">{{ $kost->address }}</td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('admin.kost.destroy', $kost->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Lu bertindak sebagai Admin. Yakin ingin menghapus paksa kosan ini dari aplikasi?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border border-red-500 text-red-500 hover:bg-red-50 text-xs font-bold px-3 py-1.5 rounded-lg transition">
                                            🚨 Hapus (Take Down)
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-gray-400 italic text-sm">Belum ada data kos yang dibuat oleh owner mana pun.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>
