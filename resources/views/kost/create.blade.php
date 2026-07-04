<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Kos - KostReview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #F3F4F6; font-family: 'Poppins', sans-serif; }
        .bg-navy { background-color: #1E3A8A !important; }
        .text-navy { color: #1E3A8A !important; }
        .btn-pink { background-color: #EC4899; border-color: #EC4899; color: #FFFFFF; }
        .btn-pink:hover { background-color: #d63d86; border-color: #d63d86; color: #FFFFFF; }
        .card { border-radius: 12px; overflow: hidden; }
    </style>
</head>
<body>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <!-- Tombol Kembali -->
                <a href="{{ route('owner.dashboard') }}" class="btn btn-outline-secondary mb-3">
                    &larr; Kembali ke Dashboard
                </a>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-navy text-white text-center py-3">
                        <h4 class="mb-0">Daftarkan Kos Baru</h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('kost.store') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Input Nama Kos -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold text-navy">Nama Kos</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: Kos Sakura Depok" required>
                                @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <!-- Input Harga per Bulan -->
                            <div class="mb-3">
                                <label for="price_per_month" class="form-label fw-bold text-navy">Harga per Bulan (Rp)</label>
                                <input type="number" class="form-control" id="price_per_month" name="price_per_month" placeholder="Contoh: 1500000" required>
                                @error('price_per_month') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <!-- Input Alamat -->
                            <div class="mb-3">
                                <label for="address" class="form-label fw-bold text-navy">Alamat Lengkap</label>
                                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Masukkan alamat lengkap kos..." required></textarea>
                                @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <!-- Input Deskripsi -->
                            <div class="mb-4">
                                <label for="description" class="form-label fw-bold text-navy">Deskripsi Singkat</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Jelaskan keunggulan kos ini (contoh: Dekat kampus, akses 24 jam, dll)..." required></textarea>
                                @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-navy">Fasilitas Kos (Bisa pilih lebih dari 1)</label>
                                <div class="row">
                                    @foreach(\App\Models\Facility::all() as $facility)
                                        <div class="col-md-4 col-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input border-pink" type="checkbox" name="facilities[]" value="{{ $facility->id }}" id="fac_{{ $facility->id }}">
                                                <label class="form-check-label text-muted" for="fac_{{ $facility->id }}">
                                                    {{ $facility->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-navy">Kampus Terdekat (Bisa pilih lebih dari 1)</label>
                                <div class="row">
                                    @foreach(\App\Models\Campus::all() as $campus)
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input border-primary" type="checkbox" name="campuses[]" value="{{ $campus->id }}" id="campus_{{ $campus->id }}">
                                                <label class="form-check-label text-muted small" for="campus_{{ $campus->id }}">
                                                    {{ $campus->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-4 p-3 border rounded bg-white">
                                <label for="images" class="form-label fw-bold text-navy">Upload Foto Kos (Bisa pilih lebih dari 1)</label>
                                <input class="form-control" type="file" id="images" name="images[]" multiple accept="image/*">
                                <div class="form-text small">Format yang didukung: JPG, JPEG, PNG. Maksimal 2MB per foto.</div>
                             @error('images.*') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <!-- Tombol Simpan -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-pink btn-lg fw-bold">Simpan Data Kos</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>