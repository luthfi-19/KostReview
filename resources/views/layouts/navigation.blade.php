<nav x-data="{ mobileOpen: false }" class="bg-wa-darker border-b border-wa-border sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-14">

            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-wa-green font-extrabold text-lg tracking-tight">K</span>
                    <span class="text-wa-text font-bold text-lg tracking-tight">KostReview</span>
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex md:items-center md:gap-1">
                @auth
                    <a href="{{ route('home') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">
                        Katalog
                    </a>

                    @if(Auth::user()->role === 'student')
                        <a href="{{ route('student.occupancy.index') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">
                            Pengajuan Saya
                        </a>
                    @endif

                    @if(Auth::user()->role === 'owner')
                        <a href="{{ route('owner.dashboard') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">
                            Dashboard
                        </a>
                        <a href="{{ route('kost.create') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">
                            + Tambah Kos
                        </a>
                    @endif

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">
                            Admin
                        </a>
                    @endif

                    <div class="w-px h-6 bg-wa-border mx-2"></div>

                    <a href="{{ route('profile.info') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">
                        Profil
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="ml-1">
                        @csrf
                        <button type="submit" class="bg-wa-red hover:bg-red-600 text-white text-sm font-bold px-4 py-2 rounded-lg transition">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-wa-green hover:bg-emerald-600 text-white text-sm font-bold px-4 py-2 rounded-lg transition ml-2">Daftar</a>
                @endauth
            </div>

            {{-- Mobile hamburger --}}
            <div class="flex items-center md:hidden">
                <button @click="mobileOpen = !mobileOpen" class="text-wa-muted hover:text-wa-text p-2 rounded-lg hover:bg-wa-card transition">
                    <svg x-show="!mobileOpen" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileOpen" x-cloak x-transition class="md:hidden border-t border-wa-border">
        <div class="px-4 py-3 space-y-1">
            @auth
                <a href="{{ route('home') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Katalog</a>

                @if(Auth::user()->role === 'student')
                    <a href="{{ route('student.occupancy.index') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Pengajuan Saya</a>
                @endif

                @if(Auth::user()->role === 'owner')
                    <a href="{{ route('owner.dashboard') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Dashboard</a>
                    <a href="{{ route('kost.create') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">+ Tambah Kos</a>
                @endif

                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Admin</a>
                @endif

                <div class="border-t border-wa-border my-2"></div>

                <a href="{{ route('profile.info') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Profil</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left bg-wa-red hover:bg-red-600 text-white text-sm font-bold px-3 py-2 rounded-lg transition mt-1">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-wa-muted hover:text-wa-text hover:bg-wa-card text-sm font-medium px-3 py-2 rounded-lg transition">Masuk</a>
                <a href="{{ route('register') }}" class="block bg-wa-green hover:bg-emerald-600 text-white text-sm font-bold px-3 py-2 rounded-lg transition mt-1">Daftar</a>
            @endauth
        </div>
    </div>
</nav>
