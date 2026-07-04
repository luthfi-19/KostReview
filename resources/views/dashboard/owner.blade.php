<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Owner Dashboard - KostReview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #F3F4F6; font-family: 'Poppins', sans-serif; }
        .bg-navy { background-color: #1E3A8A !important; }
        .text-navy { color: #1E3A8A !important; }
        .btn-pink { background-color: #EC4899; border-color: #EC4899; color: #FFFFFF; }
        .btn-pink:hover { background-color: #d63d86; border-color: #d63d86; color: #FFFFFF; }
        .card { border-radius: 12px; }
    </style>
</head>
<body class="bg-light">
    
    <nav class="navbar navbar-dark bg-navy shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">KostReview Owner</a>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="mb-0 fw-bold">🎉 {{ session('success') }}</i>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h2>Halo, {{ Auth::user()->name }}! 🏢</h2>
                <p class="text-muted mb-0">Kelola properti kosan lu dengan mudah di sini.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ route('kost.create') }}" class="btn btn-pink fw-bold px-4 py-2 shadow-sm">
                    + Tambah Data Kos Baru
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-5" style="border-left: 5px solid #EC4899 !important;">
            <div class="card-header bg-white fw-bold py-3 text-pink">
                🔔 Pengajuan Sewa Baru (Perlu Tindakan)
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4">Tanggal</th>
                                <th>Nama Calon Penghuni</th>
                                <th>Mendaftar di Kos</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($occupancies as $occupancy)
                                <tr>
                                    <td class="px-4 text-muted small">{{ $occupancy->created_at->format('d M Y') }}</td>
                                    <td><strong class="text-navy">{{ $occupancy->user->name }}</strong></td>
                                    <td>{{ $occupancy->kost->name }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <form action="{{ route('owner.occupancy.approve', $occupancy->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success fw-bold">Terima</button>
                                            </form>
                                            
                                            <form action="{{ route('owner.occupancy.reject', $occupancy->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-danger fw-bold">Tolak</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada pengajuan sewa baru saat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-navy text-white fw-bold py-3">
                Daftar Kosan Milik Lu
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                         <tr>
                             <th class="px-4" style="width: 5%">No</th>
                             <th style="width: 15%">Foto</th> <th style="width: 20%">Nama Kos</th>
                             <th style="width: 15%">Harga / Bulan</th>
                             <th style="width: 25%">Alamat</th>
                             <th class="text-center" style="width: 20%">Aksi</th>
                         </tr>
                     </thead>
                        <tbody>
                            @forelse($kosts as $index => $kost)
                                <tr>
                                    <!-- 1. Nomor -->
                                    <td>{{ $index + 1 }}</td>
                                    
                                    <!-- 2. Foto -->
                                    <td>
                                        @if($kost->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $kost->images->first()->image_path) }}" alt="Foto Kos" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <span class="text-muted small">No Image</span>
                                        @endif
                                    </td>
                                    
                                    <!-- 3. Nama Kos (Ini yang tadi hilang/kehapus) -->
                                    <td class="fw-bold text-navy">{{ $kost->name }}</td>
                                    
                                    <!-- 4. Harga / Bulan (Ini juga kayaknya hilang) -->
                                    <td class="text-pink fw-bold">Rp {{ number_format($kost->price_per_month, 0, ',', '.') }}</td>
                                    
                                    <!-- 5. Alamat -->
                                    <td>{{ Str::limit($kost->address, 50) }}</td>
                                    
                                    <!-- 6. Aksi (Tombol Edit & Hapus) -->
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('kost.edit', $kost->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                            
                                            <form action="{{ route('kost.destroy', $kost->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus data kos ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada kosan yang lu daftarin, bang.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>