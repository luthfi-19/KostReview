<x-guest-layout>
    <div class="bg-wa-card border border-wa-border rounded-2xl overflow-hidden">
        <div class="bg-wa-darker px-6 py-5 text-center border-b border-wa-border">
            <div class="flex items-center justify-center gap-2 mb-1">
                <span class="text-wa-green font-extrabold text-xl">K</span>
                <span class="text-wa-text font-bold text-xl">KostReview</span>
            </div>
            <p class="text-wa-muted text-xs">Verifikasi email</p>
        </div>
        <div class="p-6">
            <div class="mb-4 text-sm text-wa-muted">
                {{ __('Sebelum mulai, mohon verifikasi alamat email kamu dengan mengklik link yang kami kirimkan. Kalau belum terima, kami bisa kirim ulang.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-wa-green">
                    {{ __('Link verifikasi baru sudah dikirim ke email kamu.') }}
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-primary-button>
                        {{ __('Kirim Ulang Verifikasi') }}
                    </x-primary-button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="underline text-sm text-wa-muted hover:text-wa-text rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-wa-green transition">
                        {{ __('Keluar') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
