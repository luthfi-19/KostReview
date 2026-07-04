<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Kos - {{ $kost->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #F3F4F6; font-family: 'Poppins', sans-serif; }
        .bg-navy { background-color: #1E3A8A !important; }
        .text-navy { color: #1E3A8A !important; }
        .text-pink { color: #EC4899 !important; }
        .btn-pink { background-color: #EC4899; border-color: #EC4899; color: #FFFFFF; }
        .btn-pink:hover { background-color: #d63d86; border-color: #d63d86; color: #FFFFFF; }
        .carousel-item img { height: 400px; object-fit: cover; border-radius: 12px; }
        .card { border-radius: 12px; border: none; }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-dark bg-navy shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                &larr; Kembali ke Pencarian
            </a>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row">
            
            <div class="col-lg-7 mb-4">
                <div class="card shadow-sm p-2">
                    @if($kost->images->isNotEmpty())
                        <div id="kostCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($kost->images as $index => $image)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" class="d-block w-100" alt="Foto Kos">
                                    </div>
                                @endforeach
                            </div>
                            @if($kost->images->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#kostCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#kostCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 400px; border-radius: 12px;">
                            <h3>Foto belum tersedia</h3>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm h-100">
                    <div class="card-body p-4">
                        <h2 class="fw-bold text-navy mb-2">{{ $kost->name }}</h2>
                        <h3 class="text-pink fw-bold mb-4">
                            Rp {{ number_format($kost->price_per_month, 0, ',', '.') }} <span class="fs-6 text-muted fw-normal">/ bulan</span>
                        </h3>
                        
                        <h5 class="fw-bold text-navy mt-4 mb-2">📍 Alamat Lengkap</h5>
                        <p class="text-muted">{{ $kost->address }}</p>

                       <h6 class="fw-bold text-navy mt-4 mb-3">✨ Fasilitas Tersedia</h6>
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @forelse($kost->facilities as $facility)
                                <span class="badge px-3 py-2 text-navy border border-primary" style="background-color: #F0F4FF; font-weight: 600; font-size: 0.85rem; border-radius: 8px;">
                                    ✓ {{ $facility->name }}
                                </span>
                            @empty
                                <span class="text-muted fst-italic small">Belum ada informasi fasilitas.</span>
                            @endforelse
                        </div>

                        <h6 class="fw-bold text-navy mt-4 mb-3">🎓 Kampus Terdekat</h6>
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @forelse($kost->campuses as $campus)
                                <span class="badge bg-navy px-3 py-2 text-white shadow-sm" style="font-weight: 600; font-size: 0.85rem; border-radius: 8px;">
                                    📍 {{ $campus->name }}
                                </span>
                            @empty
                                <span class="text-muted fst-italic small">Belum ada informasi kampus terdekat.</span>
                            @endforelse
                        </div>

                        <h5 class="fw-bold text-navy mt-4 mb-2">📝 Deskripsi Kos</h5>
                        <p class="text-muted" style="white-space: pre-line;">{{ $kost->description }}</p>

                        <hr class="my-4">
                        
                       @if (session('success'))
                            <div class="alert alert-success mt-3 shadow-sm border-0">
                                ✅ {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger mt-3 shadow-sm border-0">
                                ⚠️ {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('student.occupancy.store', $kost->id) }}" method="POST" class="mt-4">
                            @csrf
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-pink btn-lg fw-bold">Ajukan Sewa / Hunian</button>
                            </div>
                        </form>
                        <hr class="my-5">
                        
                        <h4 class="fw-bold text-navy mb-4">⭐ Ulasan Penghuni</h4>
                        
                        <div class="mb-4">
                            @forelse($kost->reviews as $review)
                                <div class="card bg-light border-0 mb-3 shadow-sm">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between">
                                            <strong class="text-navy">{{ $review->user->name }}</strong>
                                            <span class="text-warning fw-bold">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating) ★ @else ☆ @endif
                                                @endfor
                                            </span>
                                        </div>
                                        <p class="text-muted small mb-0 mt-2">{{ $review->comment }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted fst-italic">Belum ada ulasan untuk kos ini. Jadilah yang pertama!</p>
                            @endforelse
                        </div>

                        <div class="card border border-pink shadow-sm">
                            <div class="card-body">
                                <h6 class="fw-bold text-pink mb-3">Tulis Ulasan Lu</h6>
                                <form action="{{ route('student.review.store', $kost->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Rating Bintang (1-5)</label>
                                        <select name="rating" class="form-select form-select-sm" required>
                                            <option value="5">⭐⭐⭐⭐⭐ (Sangat Bagus)</option>
                                            <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                                            <option value="3">⭐⭐⭐ (Lumayan)</option>
                                            <option value="2">⭐⭐ (Kurang)</option>
                                            <option value="1">⭐ (Parah)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Komentar</label>
                                        <textarea name="comment" class="form-control form-control-sm" rows="3" placeholder="Gimana rasanya ngekos di sini?" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-pink fw-bold px-3">Kirim Ulasan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>