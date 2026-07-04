<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Riwayat Pengajuan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background-color: #F3F4F6; }</style>
</head>
<body class="p-4">
    <div class="container">
        <h2 class="fw-bold mb-4">Riwayat Pengajuan Sewa</h2>
        <div class="card shadow-sm border-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Kos</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($occupancies as $item)
                    <tr>
                        <td>{{ $item->kost->name }}</td>
                        <td>
                            <span class="badge 
                                {{ $item->status == 'approved' ? 'bg-success' : '' }}
                                {{ $item->status == 'pending' ? 'bg-warning' : '' }}
                                {{ $item->status == 'rejected' ? 'bg-danger' : '' }}">
                                {{ strtoupper($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center">Belum ada pengajuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <a href="{{ route('home') }}" class="btn btn-secondary m-3">Kembali</a>
        </div>
    </div>
</body>
</html>