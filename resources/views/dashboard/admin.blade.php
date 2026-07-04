<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - KostReview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #F8FAFC; font-family: 'Poppins', sans-serif; }
        .bg-dark-navy { background-color: #0F172A !important; }
        .text-navy { color: #1E3A8A !important; }
        .card-stat { border: none; border-radius: 12px; transition: transform 0.2s; }
        .card-stat:hover { transform: translateY(-3px); }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark bg-dark-navy shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-info" href="#">👑 KOSTREVIEW ADMIN PANEL</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3 d-none d-md-block">Mode Super Admin: <strong>{{ Auth::user()->name }}</strong> ⚙️</span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger fw-bold">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                🔥 <strong>Sistem Berhasil:</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex gap-3 mb-4">
            <a href="{{ route('admin.campuses.index') }}" class="btn btn-primary fw-bold shadow-sm">
                🎓 Kelola Data Kampus
            </a>
            <a href="{{ route('admin.facilities.index') }}" class="btn btn-info text-white fw-bold shadow-sm">
                ✨ Kelola Data Fasilitas
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-warning text-dark fw-bold shadow-sm">
                👥 Kelola Data User
            </a>
        </div>

        <div class="mb-4">
            <h2 class="fw-bold text-dark">Ringkasan Ekosistem Aplikasi 📊</h2>
            <p class="text-muted">Pantau jumlah data terdaftar dan kelola moderasi konten iklan kosan.</p>
        </div>

        <div class="row g-3 mb-5">
            <div class="col-md-3 col-6">
                <div class="card card-stat bg-primary text-white shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="text-uppercase small fw-bold opacity-75">Total Mahasiswa</h6>
                        <h2 class="fw-bold mb-0 mt-2">{{ $totalStudents }} Orang</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card card-stat bg-info text-white shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="text-uppercase small fw-bold opacity-75">Total Pemilik Kos</h6>
                        <h2 class="fw-bold mb-0 mt-2">{{ $totalOwners }} Orang</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card card-stat bg-success text-white shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="text-uppercase small fw-bold opacity-75">Total Kos Iklan</h6>
                        <h2 class="fw-bold mb-0 mt-2">{{ $totalKosts }} Kamar</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card card-stat bg-warning text-dark shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="text-uppercase small fw-bold opacity-75">Total Ulasan/Review</h6>
                        <h2 class="fw-bold mb-0 mt-2">{{ $totalReviews }} Ulasan</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
            <div class="card-header bg-dark-navy text-white py-3">
                <h5 class="mb-0 fw-bold">🛡️ Moderasi & Pengawasan Iklan Kos Global</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama Kos</th>
                                <th>Pemilik (Owner)</th>
                                <th>Harga / Bulan</th>
                                <th>Alamat</th>
                                <th>Aksi Pemblokiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kosts as $index => $kost)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($kost->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $kost->images->first()->image_path) }}" class="img-thumbnail" style="width: 55px; height: 55px; object-fit: cover; border-radius: 6px;">
                                        @else
                                            <span class="text-muted small">No Photo</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-navy">{{ $kost->name }}</td>
                                    <td><span class="badge bg-secondary">{{ $kost->user->name }}</span></td>
                                    <td class="text-success fw-bold">Rp {{ number_format($kost->price_per_month, 0, ',', '.') }}</td>
                                    <td class="text-muted small text-start" style="max-width: 250px;">{{ $kost->address }}</td>
                                    <td>
                                        <form action="{{ route('admin.kost.destroy', $kost->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Lu bertindak sebagai Admin. Yakin ingin menghapus paksa kosan ini dari aplikasi?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger fw-bold px-3">
                                                🚨 Hapus (Take Down)
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted fst-italic">Belum ada data kos yang dibuat oleh owner mana pun.</td>
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