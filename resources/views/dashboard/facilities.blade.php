<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Fasilitas - KostReview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background-color: #F8FAFC; font-family: 'Poppins', sans-serif; } .bg-dark-navy { background-color: #0F172A !important; }</style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark-navy shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">&larr; Kembali ke Dashboard Admin</a>
        </div>
    </nav>

    <div class="container mb-5">
        @if(session('success'))
            <div class="alert alert-success shadow-sm">✅ {{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-info text-white fw-bold">➕ Tambah Fasilitas Baru</div>
                    <div class="card-body">
                        <form action="{{ route('admin.facilities.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-muted">Nama Fasilitas</label>
                                <input type="text" name="name" class="form-control" placeholder="Contoh: Smart TV 32 Inch" required>
                            </div>
                            <button type="submit" class="btn btn-info text-white w-100 fw-bold">Simpan Fasilitas</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-dark-navy text-white fw-bold">✨ Daftar Fasilitas Kos</div>
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle text-center mb-0">
                            <thead class="table-light">
                                <tr><th>No</th><th>Nama Fasilitas</th><th>Aksi</th></tr>
                            </thead>
                            <tbody>
                                @foreach($facilities as $index => $facility)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $facility->name }}</td>
                                    <td>
                                        <form action="{{ route('admin.facilities.destroy', $facility->id) }}" method="POST" onsubmit="return confirm('Yakin hapus fasilitas ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
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