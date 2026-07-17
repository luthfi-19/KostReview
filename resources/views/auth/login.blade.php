<x-guest-layout>
    <div class="bg-wa-card border border-wa-border rounded-2xl overflow-hidden">
        <div class="bg-wa-darker px-6 py-5 text-center border-b border-wa-border">
            <div class="flex items-center justify-center gap-2 mb-1">
                <span class="text-wa-green font-extrabold text-xl">K</span>
                <span class="text-wa-text font-bold text-xl">KostReview</span>
            </div>
            <p class="text-wa-muted text-xs">Masuk ke akun kamu</p>
        </div>
        <div class="p-6">

            @if (session('status'))
                <div class="bg-wa-green/10 border border-wa-green/30 text-wa-green rounded-xl px-4 py-3 mb-4 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-wa-muted mb-1.5">Alamat Email</label>
                    <input type="email" class="block w-full rounded-xl border-wa-border bg-wa-darker text-wa-text placeholder-wa-muted shadow-sm focus:border-wa-green focus:ring-wa-green/20 text-sm px-4 py-2.5" id="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required autofocus>
                    @error('email') <span class="text-wa-red text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-wa-muted mb-1.5">Password</label>
                    <input type="password" class="block w-full rounded-xl border-wa-border bg-wa-darker text-wa-text placeholder-wa-muted shadow-sm focus:border-wa-green focus:ring-wa-green/20 text-sm px-4 py-2.5" id="password" name="password" placeholder="Masukkan password" required>
                    @error('password') <span class="text-wa-red text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6 flex items-center">
                    <input type="checkbox" class="rounded border-wa-border bg-wa-darker text-wa-green focus:ring-wa-green/20" id="remember_me" name="remember">
                    <label class="ml-2 text-sm text-wa-muted" for="remember_me">Ingat Saya</label>
                </div>

                <button type="submit" class="w-full bg-wa-green hover:bg-emerald-600 text-white font-bold py-3 px-4 rounded-xl transition text-sm">
                    Masuk
                </button>

                <div class="mt-4 text-center text-sm">
                    <a href="{{ route('register') }}" class="text-wa-green hover:text-emerald-400 font-medium transition">Belum punya akun? Daftar di sini</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
