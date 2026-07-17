<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Pengajuan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased p-4">
    <div class="max-w-4xl mx-auto mt-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Riwayat Pengajuan Sewa</h2>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kos</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($occupancies as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 text-sm">{{ $item->kost->name }}</td>
                            <td class="px-6 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $item->status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $item->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $item->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ strtoupper($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada pengajuan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                <a href="{{ route('home') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg transition">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
