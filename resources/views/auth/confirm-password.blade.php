<x-guest-layout>
    <div class="bg-wa-card border border-wa-border rounded-2xl overflow-hidden">
        <div class="bg-wa-darker px-6 py-5 text-center border-b border-wa-border">
            <div class="flex items-center justify-center gap-2 mb-1">
                <span class="text-wa-green font-extrabold text-xl">K</span>
                <span class="text-wa-text font-bold text-xl">KostReview</span>
            </div>
            <p class="text-wa-muted text-xs">Konfirmasi password</p>
        </div>
        <div class="p-6">
            <div class="mb-4 text-sm text-wa-muted">
                {{ __('Ini adalah area aman. Mohon masukkan password sebelum melanjutkan.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-4">
                    <x-primary-button>
                        {{ __('Konfirmasi') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
