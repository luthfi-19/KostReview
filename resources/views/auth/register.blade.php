<x-guest-layout>
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">Daftar Akun KostReview</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <!-- Input Nama -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <!-- Pilihan Role (Sudah Disesuaikan dengan Database Lu) -->
                        <div class="mb-3">
                            <label for="role" class="form-label fw-bold">Daftar Sebagai</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="student">Mahasiswa (Pencari Kos)</option>
                                <option value="owner">Pemilik Kos</option>
                            </select>
                            @error('role') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <!-- Tombol Register -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Daftar Sekarang</button>
                        </div>
                        
                        <div class="mt-3 text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none">Sudah punya akun? Login di sini</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>