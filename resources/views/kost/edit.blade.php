<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Kos - KostReview</title>
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
                
                <a href="{{ route('owner.dashboard') }}" class="btn btn-outline-secondary mb-3">
                    &larr; Kembali ke Dashboard
                </a>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-navy text-white text-center py-3">
                        <h4 class="mb-0">Edit Data Kos</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('kost.update', $kost->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold text-navy">Nama Kos</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $kost->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="price_per_month" class="form-label fw-bold text-navy">Harga per Bulan (Rp)</label>
                                <input type="number" class="form-control" id="price_per_month" name="price_per_month" value="{{ old('price_per_month', $kost->price_per_month) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label fw-bold text-navy">Alamat Lengkap</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address', $kost->address) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label fw-bold text-navy">Deskripsi Singkat</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $kost->description) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-navy">Fasilitas Kos (Bisa pilih lebih dari 1)</label>
                                <div class="row">
                                    @foreach(\App\Models\Facility::all() as $facility)
                                        <div class="col-md-4 col-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input border-pink" type="checkbox" name="facilities[]" value="{{ $facility->id }}" id="fac_{{ $facility->id }}"
                                                    {{ $kost->facilities->contains($facility->id) ? 'checked' : '' }}>
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
                                                <input class="form-check-input border-primary" type="checkbox" name="campuses[]" value="{{ $campus->id }}" id="campus_{{ $campus->id }}"
                                                    {{ $kost->campuses->contains($campus->id) ? 'checked' : '' }}>
                                                <label class="form-check-label text-muted small" for="campus_{{ $campus->id }}">
                                                    {{ $campus->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @if($kost->images->isNotEmpty())
                                <div class="mb-4 p-3 bg-light rounded border">
                                    <label class="form-label fw-bold text-navy mb-3">Foto Saat Ini (Centang untuk menghapus):</label>
                                    <div class="d-flex flex-wrap gap-3">
                                        @foreach($kost->images as $img)
                                            <div class="text-center">
                                                <img src="{{ asset('storage/' . $img->image_path) }}" class="img-thumbnail shadow-sm mb-2" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px;">
                                                <div class="form-check d-flex justify-content-center align-items-center gap-2">
                                                    <input class="form-check-input border-danger" type="checkbox" name="delete_images[]" value="{{ $img->id }}" id="delete_{{ $img->id }}" style="cursor: pointer;">
                                                    <label class="form-check-label text-danger small fw-bold" for="delete_{{ $img->id }}" style="cursor: pointer;">
                                                        Hapus Foto
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mb-4">
                                <label class="form-label fw-bold text-navy">Upload Foto Tambahan (Bisa pilih lebih dari 1)</label>
                                <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                                <small class="text-muted">Format yang didukung: JPG, JPEG, PNG. Maksimal 2MB per foto. Biarkan kosong jika tidak ingin menambah foto.</small>
                            </div>      

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-pink btn-lg fw-bold">Update Data Kos</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>