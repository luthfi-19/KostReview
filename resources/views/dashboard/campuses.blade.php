<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Kampus - KostReview</title>
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
                    <div class="card-header bg-primary text-white fw-bold">➕ Tambah Kampus Baru</div>
                    <div class="card-body">
                        <form action="{{ route('admin.campuses.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-muted">Nama Kampus Lengkap</label>
                                <input type="text" name="name" class="form-control" placeholder="Contoh: Universitas Brawijaya" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan Kampus</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-dark-navy text-white fw-bold">🎓 Daftar Kampus Terdaftar</div>
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle text-center mb-0">
                            <thead class="table-light">
                                <tr><th>No</th><th>Nama Kampus</th><th>Aksi</th></tr>
                            </thead>
                            <tbody>
                                @foreach($campuses as $index => $campus)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $campus->name }}</td>
                                    <td>
                                        <form action="{{ route('admin.campuses.destroy', $campus->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kampus ini?');">
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