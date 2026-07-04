<x-guest-layout>
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0">Masuk ke KostReview</h4>
                </div>
                <div class="card-body p-4">
                    
                    <!-- Alert jika ada pesan dari sistem -->
                    @if (session('status'))
                        <div class="alert alert-success mb-3">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <!-- Input Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <!-- Fitur Ingat Saya -->
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                            <label class="form-check-label" for="remember_me">Ingat Saya</label>
                        </div>

                        <!-- Tombol Login -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">Login</button>
                        </div>
                        
                        <div class="mt-3 text-center">
                            <a href="{{ route('register') }}" class="text-decoration-none">Belum punya akun? Daftar di sini</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>