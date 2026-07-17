<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Kampus - KostReview</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <nav class="bg-slate-900 shadow-sm mb-6">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <a class="text-lg font-bold text-white" href="{{ route('admin.dashboard') }}">&larr; Kembali ke Dashboard Admin</a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 mb-10">
        @if(session('success'))
            <div class="bg-green-50 text-green-800 px-4 py-3 rounded-lg shadow-sm mb-4 text-sm">✅ {{ session('success') }}</div>
        @endif

        <div class="flex flex-col md:flex-row gap-6">
            <div class="w-full md:w-1/3">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="bg-indigo-600 text-white px-5 py-3 text-sm font-bold">➕ Tambah Kampus Baru</div>
                    <div class="p-5">
                        <form action="{{ route('admin.campuses.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm text-gray-500 mb-1">Nama Kampus Lengkap</label>
                                <input type="text" name="name" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Contoh: Universitas Brawijaya" required>
                            </div>
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 rounded-lg transition">Simpan Kampus</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-2/3">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="bg-slate-900 text-white px-5 py-3 text-sm font-bold">🎓 Daftar Kampus Terdaftar</div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-center">
                            <thead class="bg-gray-50">
                                <tr><th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase">No</th><th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase">Nama Kampus</th><th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase">Aksi</th></tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($campuses as $index => $campus)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm font-bold">{{ $campus->name }}</td>
                                    <td class="px-4 py-3">
                                        <form action="{{ route('admin.campuses.destroy', $campus->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kampus ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
