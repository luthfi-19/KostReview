<x-guest-layout>
    <div class="bg-wa-card border border-wa-border rounded-2xl overflow-hidden">
        <div class="bg-wa-darker px-6 py-5 text-center border-b border-wa-border">
            <div class="flex items-center justify-center gap-2 mb-1">
                <span class="text-wa-green font-extrabold text-xl">K</span>
                <span class="text-wa-text font-bold text-xl">KostReview</span>
            </div>
            <p class="text-wa-muted text-xs">Buat akun baru</p>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold text-wa-muted mb-1.5">Nama Lengkap</label>
                    <input type="text" class="block w-full rounded-xl border-wa-border bg-wa-darker text-wa-text placeholder-wa-muted shadow-sm focus:border-wa-green focus:ring-wa-green/20 text-sm px-4 py-2.5" id="name" name="name" value="{{ old('name') }}" placeholder="Nama kamu" required autofocus>
                    @error('name') <span class="text-wa-red text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-wa-muted mb-1.5">Alamat Email</label>
                    <input type="email" class="block w-full rounded-xl border-wa-border bg-wa-darker text-wa-text placeholder-wa-muted shadow-sm focus:border-wa-green focus:ring-wa-green/20 text-sm px-4 py-2.5" id="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required>
                    @error('email') <span class="text-wa-red text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-sm font-semibold text-wa-muted mb-1.5">Daftar Sebagai</label>
                    <select class="block w-full rounded-xl border-wa-border bg-wa-darker text-wa-text shadow-sm focus:border-wa-green focus:ring-wa-green/20 text-sm px-4 py-2.5" id="role" name="role" required>
                        <option value="student">Mahasiswa (Pencari Kos)</option>
                        <option value="owner">Pemilik Kos</option>
                    </select>
                    @error('role') <span class="text-wa-red text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-wa-muted mb-1.5">Password</label>
                    <input type="password" class="block w-full rounded-xl border-wa-border bg-wa-darker text-wa-text placeholder-wa-muted shadow-sm focus:border-wa-green focus:ring-wa-green/20 text-sm px-4 py-2.5" id="password" name="password" placeholder="Buat password" required>
                    @error('password') <span class="text-wa-red text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-semibold text-wa-muted mb-1.5">Konfirmasi Password</label>
                    <input type="password" class="block w-full rounded-xl border-wa-border bg-wa-darker text-wa-text placeholder-wa-muted shadow-sm focus:border-wa-green focus:ring-wa-green/20 text-sm px-4 py-2.5" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                </div>

                <button type="submit" class="w-full bg-wa-green hover:bg-emerald-600 text-white font-bold py-3 px-4 rounded-xl transition text-sm">
                    Daftar Sekarang
                </button>

                <div class="mt-4 text-center text-sm">
                    <a href="{{ route('login') }}" class="text-wa-green hover:text-emerald-400 font-medium transition">Sudah punya akun? Masuk di sini</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
