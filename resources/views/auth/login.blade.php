<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-navy px-6 py-4 text-center">
            <h4 class="text-xl font-bold text-white">Masuk ke KostReview</h4>
        </div>
        <div class="p-6">

            @if (session('status'))
                <div class="bg-green-50 text-green-800 rounded-lg px-4 py-3 mb-4 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" id="password" name="password" required>
                    @error('password') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6 flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" id="remember_me" name="remember">
                    <label class="ml-2 text-sm text-gray-600" for="remember_me">Ingat Saya</label>
                </div>

                <button type="submit" class="w-full bg-navy hover:bg-blue-900 text-white font-bold py-3 px-4 rounded-lg transition text-sm">
                    Login
                </button>

                <div class="mt-4 text-center text-sm">
                    <a href="{{ route('register') }}" class="text-navy hover:underline font-medium">Belum punya akun? Daftar di sini</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
