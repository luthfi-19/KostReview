<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola User - KostReview</title>
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
        @if(session('error'))
            <div class="alert alert-danger shadow-sm">⚠️ {{ session('error') }}</div>
        @endif

        <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
            <div class="card-header bg-warning text-dark py-3">
                <h5 class="mb-0 fw-bold">👥 Manajemen Akun Terdaftar (Kelola User)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Tanggal Daftar</th>
                                <th>Role / Jabatan</th>
                                <th>Aksi Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold text-start">{{ $user->name }}</td>
                                    <td class="text-start">{{ $user->email }}</td>
                                    <td class="small text-muted">{{ $user->created_at->format('d M Y') }}</td>
                                    <td>
                                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="d-flex justify-content-center gap-2">
                                            @csrf
                                            @method('PUT')
                                            <select name="role" class="form-select form-select-sm" style="width: 120px;" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                                <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                                                <option value="owner" {{ $user->role === 'owner' ? 'selected' : '' }}>Owner</option>
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            @if(auth()->id() !== $user->id)
                                                <button type="submit" class="btn btn-sm btn-success fw-bold">Save</button>
                                            @endif
                                        </form>
                                    </td>
                                    <td>
                                        @if(auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini permanen beserta semua data kos/review miliknya?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger fw-bold">Hapus</button>
                                            </form>
                                        @else
                                            <span class="badge bg-secondary">Sedang Dipakai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Belum ada user yang terdaftar.</td>
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