<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola User - KostReview</title>
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
        @if(session('error'))
            <div class="bg-red-50 text-red-800 px-4 py-3 rounded-lg shadow-sm mb-4 text-sm">⚠️ {{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="bg-yellow-400 text-gray-900 px-6 py-3">
                <h5 class="text-sm font-bold">👥 Manajemen Akun Terdaftar (Kelola User)</h5>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-center">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase text-left">Nama Lengkap</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase text-left">Email</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase">Tanggal Daftar</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase">Role / Jabatan</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase">Aksi Hapus</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $index => $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm font-bold text-left">{{ $user->name }}</td>
                                <td class="px-4 py-3 text-sm text-left">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-xs text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="flex justify-center items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" class="rounded-lg border-gray-300 text-xs shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-28" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                            <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                                            <option value="owner" {{ $user->role === 'owner' ? 'selected' : '' }}>Owner</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        @if(auth()->id() !== $user->id)
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">Save</button>
                                        @endif
                                    </form>
                                </td>
                                <td class="px-4 py-3">
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini permanen beserta semua data kos/review miliknya?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="border border-red-500 text-red-500 hover:bg-red-50 text-xs font-bold px-3 py-1.5 rounded-lg transition">Hapus</button>
                                        </form>
                                    @else
                                        <span class="bg-gray-200 text-gray-600 text-xs font-medium px-2 py-1 rounded-full">Sedang Dipakai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-400 text-sm">Belum ada user yang terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>
