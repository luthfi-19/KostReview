<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-pink px-6 py-4 text-center">
            <h4 class="text-xl font-bold text-white">Daftar Akun KostReview</h4>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" id="name" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-1">Daftar Sebagai</label>
                    <select class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" id="role" name="role" required>
                        <option value="student">Mahasiswa (Pencari Kos)</option>
                        <option value="owner">Pemilik Kos</option>
                    </select>
                    @error('role') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" id="password" name="password" required>
                    @error('password') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="w-full bg-pink hover:bg-pink-600 text-white font-bold py-3 px-4 rounded-lg transition text-sm">
                    Daftar Sekarang
                </button>

                <div class="mt-4 text-center text-sm">
                    <a href="{{ route('login') }}" class="text-navy hover:underline font-medium">Sudah punya akun? Login di sini</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
