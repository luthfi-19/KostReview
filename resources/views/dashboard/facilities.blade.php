<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Fasilitas - KostReview</title>
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

        <h1 class="text-2xl font-extrabold text-wa-text mb-6">Kelola Fasilitas</h1>

        <div class="flex flex-col md:flex-row gap-6">
            <div class="w-full md:w-1/3">
                <div class="bg-wa-card border border-wa-border rounded-2xl overflow-hidden shadow-card">
                    <div class="bg-wa-blue/15 text-wa-blue px-5 py-3 text-sm font-bold border-b border-wa-border">Tambah Fasilitas Baru</div>
                    <div class="p-5">
                        <form action="{{ route('admin.facilities.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm text-wa-muted mb-1.5">Nama Fasilitas</label>
                                <input type="text" name="name" class="block w-full rounded-xl border-wa-border bg-wa-darker text-wa-text placeholder-wa-muted text-sm px-4 py-2.5 focus:border-wa-green focus:ring-wa-green/20" placeholder="Contoh: Smart TV 32 Inch" required>
                            </div>
                            <button type="submit" class="w-full bg-wa-blue hover:bg-blue-600 text-white text-sm font-bold py-2.5 rounded-xl transition">Simpan Fasilitas</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-2/3">
                <div class="bg-wa-card border border-wa-border rounded-2xl overflow-hidden shadow-card">
                    <div class="bg-wa-darker text-wa-text px-5 py-3 text-sm font-bold border-b border-wa-border">Daftar Fasilitas ({{ $facilities->count() }})</div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-wa-border">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 text-left text-[11px] font-bold text-wa-muted uppercase tracking-wider w-[8%]">No</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-bold text-wa-muted uppercase tracking-wider">Nama Fasilitas</th>
                                    <th class="px-5 py-3 text-center text-[11px] font-bold text-wa-muted uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-wa-border">
                                @foreach($facilities as $index => $facility)
                                <tr class="hover:bg-wa-hover/50 transition-colors">
                                    <td class="px-5 py-3 text-sm text-wa-muted">{{ $index + 1 }}</td>
                                    <td class="px-5 py-3 text-sm font-bold text-wa-text">{{ $facility->name }}</td>
                                    <td class="px-5 py-3 text-center">
                                        <form action="{{ route('admin.facilities.destroy', $facility->id) }}" method="POST" onsubmit="return confirm('Yakin hapus fasilitas ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="border border-wa-red/40 text-wa-red hover:bg-wa-red/10 text-xs font-bold px-3 py-1.5 rounded-xl transition">Hapus</button>
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
