<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola User - KostReview</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-wa-bg font-sans antialiased text-wa-text min-h-screen">

    <nav class="bg-wa-darker border-b border-wa-border sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-wa-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        <span class="text-wa-green font-extrabold text-lg">K</span>
                        <span class="text-wa-text font-bold text-lg">KostReview</span>
                    </a>
                    <span class="bg-cyan-500/15 text-cyan-400 text-[10px] font-bold px-2 py-0.5 rounded-full ml-2 hidden sm:inline-block">Admin</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-10">
        @if(session('success'))
            <div class="bg-wa-green/10 border border-wa-green/30 text-wa-green px-4 py-3 rounded-xl flex items-center justify-between mb-6">
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-wa-red/10 border border-wa-red/30 text-wa-red px-4 py-3 rounded-xl flex items-center justify-between mb-6">
                <span class="font-medium text-sm">{{ session('error') }}</span>
            </div>
        @endif

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-extrabold text-wa-text">Kelola Users</h1>
            <span class="bg-wa-yellow/15 text-wa-yellow text-xs font-bold px-2.5 py-1 rounded-full">{{ $users->count() }} user</span>
        </div>

        {{-- Mobile card view --}}
        <div class="sm:hidden space-y-3 mb-6">
            @foreach($users as $index => $user)
                <div class="bg-wa-card border border-wa-border rounded-2xl p-4 shadow-card">
                    <div class="flex items-start gap-3 mb-3">
                        <div class="w-10 h-10 bg-wa-darker rounded-full flex items-center justify-center text-wa-green font-bold text-sm shrink-0">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-wa-text font-bold text-sm truncate">{{ $user->name }}</p>
                            <p class="text-wa-muted text-xs truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mb-3">
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="flex items-center gap-2 flex-1">
                            @csrf @method('PUT')
                            <select name="role" class="flex-1 rounded-xl border-wa-border bg-wa-darker text-wa-text text-xs px-3 py-2 focus:border-wa-green focus:ring-wa-green/20" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                                <option value="owner" {{ $user->role === 'owner' ? 'selected' : '' }}>Owner</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @if(auth()->id() !== $user->id)
                                <button type="submit" class="bg-wa-green hover:bg-emerald-600 text-white text-xs font-bold px-3 py-2 rounded-xl transition shrink-0">Save</button>
                            @endif
                        </form>
                    </div>
                    @if(auth()->id() !== $user->id)
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full border border-wa-red/40 text-wa-red hover:bg-wa-red/10 text-xs font-bold py-2 rounded-xl transition">Hapus</button>
                        </form>
                    @else
                        <span class="block text-center bg-wa-darker text-wa-muted text-xs font-medium px-2 py-2 rounded-xl">Akun Aktif</span>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Desktop table view --}}
        <div class="hidden sm:block bg-wa-card border border-wa-border rounded-2xl overflow-hidden shadow-card">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-wa-border">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 text-left text-[11px] font-bold text-wa-muted uppercase tracking-wider">User</th>
                            <th class="px-5 py-3 text-left text-[11px] font-bold text-wa-muted uppercase tracking-wider">Email</th>
                            <th class="px-5 py-3 text-left text-[11px] font-bold text-wa-muted uppercase tracking-wider">Tanggal</th>
                            <th class="px-5 py-3 text-center text-[11px] font-bold text-wa-muted uppercase tracking-wider">Role</th>
                            <th class="px-5 py-3 text-center text-[11px] font-bold text-wa-muted uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-wa-border">
                        @foreach($users as $index => $user)
                            <tr class="hover:bg-wa-hover/50 transition-colors">
                                <td class="px-5 py-3">
                                    <span class="text-wa-text font-bold text-sm">{{ $user->name }}</span>
                                </td>
                                <td class="px-5 py-3 text-sm text-wa-muted">{{ $user->email }}</td>
                                <td class="px-5 py-3 text-xs text-wa-muted">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-5 py-3">
                                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="flex justify-center items-center gap-2">
                                        @csrf @method('PUT')
                                        <select name="role" class="rounded-xl border-wa-border bg-wa-darker text-wa-text text-xs px-3 py-1.5 focus:border-wa-green focus:ring-wa-green/20 w-28" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                            <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                                            <option value="owner" {{ $user->role === 'owner' ? 'selected' : '' }}>Owner</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        @if(auth()->id() !== $user->id)
                                            <button type="submit" class="bg-wa-green hover:bg-emerald-600 text-white text-xs font-bold px-3 py-1.5 rounded-xl transition">Save</button>
                                        @endif
                                    </form>
                                </td>
                                <td class="px-5 py-3 text-center">
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="border border-wa-red/40 text-wa-red hover:bg-wa-red/10 text-xs font-bold px-3 py-1.5 rounded-xl transition">Hapus</button>
                                        </form>
                                    @else
                                        <span class="bg-wa-darker text-wa-muted text-xs font-medium px-2.5 py-1 rounded-full">Aktif</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
