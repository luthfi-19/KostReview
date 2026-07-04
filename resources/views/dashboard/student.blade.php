<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pencarian Kos - KostReview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #F3F4F6; font-family: 'Poppins', sans-serif; }
        .bg-navy { background-color: #1E3A8A !important; }
        .text-navy { color: #1E3A8A !important; }
        .bg-pink { background-color: #EC4899 !important; }
        .btn-pink { background-color: #EC4899; border-color: #EC4899; color: #FFFFFF; }
        .btn-pink:hover { background-color: #d63d86; border-color: #d63d86; color: #FFFFFF; }
        .card-kost { border-radius: 12px; transition: transform 0.2s; overflow: hidden; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .card-kost:hover { transform: translateY(-5px); }
        .kost-img { height: 200px; object-fit: cover; width: 100%; }
    </style>
</head>
<body class="bg-light">
    
    <nav class="navbar navbar-dark bg-navy shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">KostReview</a>
            <div class="d-flex align-items-center">
                @auth
                    <span class="text-white me-3 d-none d-md-block">Halo, {{ Auth::user()->name }} 👋</span>
                    @if(Auth::user()->role === 'owner')
                        <a href="{{ route('owner.dashboard') }}" class="btn btn-sm btn-outline-light me-2">Dashboard Owner</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-pink fw-bold">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light me-2 fw-bold">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-pink fw-bold">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        
        <div class="mb-4 text-center">
            <h2 class="fw-bold text-navy">Temukan Kos Impianmu ✨</h2>
            <p class="text-muted mb-3">Jelajahi berbagai pilihan kos terbaik di sekitar kampus.</p>
            
            @auth
                @if(Auth::user()->role === 'student')
                <a href="{{ route('student.occupancy.index') }}" class="btn btn-pink fw-bold px-4 shadow-sm mb-4">
                    Lihat Status Pengajuan Saya
                </a>
                @endif
            @endauth
        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-md-8 col-lg-6">
                <form action="{{ route('home') }}" method="GET">
                    <div class="input-group input-group-lg shadow-sm" style="border-radius: 12px; overflow: hidden; border: 2px solid #EC4899;">
                        
                        <input type="text" name="search" class="form-control border-0 w-50" 
                               placeholder="Cari nama atau lokasi kos..." 
                               value="{{ request('search') }}">
                        
                        <select name="campus_id" class="form-select border-0 border-start bg-light" style="max-width: 35%; cursor: pointer;">
                            <option value="">🏫 Semua Kampus</option>
                            @foreach($campuses as $campus)
                                <option value="{{ $campus->id }}" {{ request('campus_id') == $campus->id ? 'selected' : '' }}>
                                    Dekat {{ $campus->name }}
                                </option>
                            @endforeach
                        </select>

                        <button class="btn btn-pink fw-bold px-4" type="submit">Cari</button>
                    </div>
                </form>
                
                @if(request('search') && $kosts->isEmpty())
                    <p class="text-danger text-center mt-3 fw-bold">
                        Yah, kos dengan kata kunci "{{ request('search') }}" nggak ketemu, bang.
                    </p>
                @endif
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @forelse($kosts as $kost)
                <div class="col">
                    <div class="card card-kost h-100">
                        
                        @if($kost->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $kost->images->first()->image_path) }}" class="card-img-top kost-img" alt="Foto Kos">
                        @else
                            <div class="card-img-top kost-img bg-secondary d-flex align-items-center justify-content-center text-white">
                                <i class="fs-4">No Image Available</i>
                            </div>
                        @endif

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title fw-bold text-navy mb-0">{{ $kost->name }}</h5>
                            </div>
                            
                            <h6 class="mb-3" style="color: #EC4899; font-weight: 700;">
                                Rp {{ number_format($kost->price_per_month, 0, ',', '.') }} <span class="text-muted fw-normal" style="font-size: 0.8rem;">/ bulan</span>
                            </h6>
                            
                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit($kost->description, 80) }}
                            </p>
                            
                            <p class="card-text text-muted small mb-0">
                                📍 {{ Str::limit($kost->address, 40) }}
                            </p>
                        </div>
                        
                        <div class="card-footer bg-white border-0 p-3 pt-0">
                            <div class="d-grid">
                                <a href="{{ route('kost.show', $kost->id) }}" class="btn btn-outline-primary fw-bold" style="color: #1E3A8A; border-color: #1E3A8A;">Lihat Detail & Review</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h4 class="text-muted">Yah, belum ada kosan yang terdaftar nih 😢</h4>
                    <p>Coba kembali lagi nanti ya!</p>
                </div>
            @endforelse
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>