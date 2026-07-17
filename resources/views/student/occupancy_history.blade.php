<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Pengajuan - KostReview</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-wa-bg font-sans antialiased text-wa-text min-h-screen">

    <nav class="bg-wa-darker border-b border-wa-border sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-wa-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        <span class="text-wa-green font-extrabold text-lg">K</span>
                        <span class="text-wa-text font-bold text-lg">KostReview</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-8">
        <h2 class="text-xl font-extrabold text-wa-text mb-5">Riwayat Pengajuan Sewa</h2>

        @if($occupancies->isEmpty())
            <div class="bg-wa-card border border-wa-border rounded-2xl p-8 text-center">
                <div class="w-12 h-12 mx-auto bg-wa-darker rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-wa-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-wa-muted text-sm">Belum ada pengajuan.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 bg-wa-green hover:bg-emerald-600 text-white font-bold px-4 py-2 rounded-xl text-xs transition mt-4">Cari Kos Sekarang</a>
            </div>
        @else
            <div class="space-y-3">
                @foreach($occupancies as $item)
                    <div class="bg-wa-card border border-wa-border rounded-2xl p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-wa-darker rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-wa-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <div>
                                <p class="text-wa-text font-bold text-sm">{{ $item->kost->name }}</p>
                                <p class="text-wa-muted text-xs">{{ $item->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full
                            {{ $item->status == 'approved' ? 'bg-wa-green/15 text-wa-green' : '' }}
                            {{ $item->status == 'pending' ? 'bg-wa-yellow/15 text-wa-yellow' : '' }}
                            {{ $item->status == 'rejected' ? 'bg-wa-red/15 text-wa-red' : '' }}">
                            {{ strtoupper($item->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
