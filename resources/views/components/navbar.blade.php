<nav class="bg-indigo-900 relative shadow-lg" x-data="{ menuOpen: false, dropdownOpen: false }">
    <div class="absolute inset-x-0 bottom-0 h-2 bg-amber-400 rounded-b-lg"></div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo & Hamburger -->
            <div class="flex items-center justify-between w-full md:w-auto">
                <a href="{{ route('dashboard_admin') }}" class="shrink-0">
                    <img width="150" src="{{ asset('img/logoo.png') }}" alt="Logo">
                </a>
                <button @click="menuOpen = !menuOpen" class="md:hidden text-white focus:outline-none">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Menu (desktop) -->
            <div class="hidden md:flex md:items-center md:space-x-6">
                <a href="/" class="text-white font-semibold hover:text-amber-400">Home</a>
                <a href="/ekskul" class="text-white font-semibold hover:text-amber-400">Ekskul</a>

                @auth
                    <a href="{{ route('dashboard_admin') }}"
                        class="text-white font-semibold hover:text-amber-400">Dashboard</a>

                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('akun.index') }}" class="text-white font-semibold hover:text-amber-400">Akun</a>
                    @endif

                    <a href="{{ route('notifikasi.index') }}"
                        class="relative text-white font-semibold hover:text-amber-400">
                        <i class="fa fa-bell" aria-hidden="true"></i>
                        @php
                            $jumlahBelumDibaca = auth()->user()->notifikasiUser->where('is_read', false)->count();
                            $foto = Auth::user()->foto;
                        @endphp
                        @if ($jumlahBelumDibaca > 0)
                            <span
                                class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-1.5 py-0.5">
                                {{ $jumlahBelumDibaca }}
                            </span>
                        @endif
                    </a>

                    <!-- Dropdown -->
                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center text-sm focus:outline-none">
                            <img class="h-10 w-10 rounded-full"
                                src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png' }}"
                                alt="User Avatar">

                        </button>
                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                            <a href="/profil" class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-100">Profil</a>
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-white font-semibold hover:text-amber-400">Login</a>
                @endauth
            </div>
        </div>
    </div>

    <div x-show="menuOpen" class="md:hidden px-4 pt-4 pb-3 space-y-1">
        <a href="/"
            class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-indigo-800">Home</a>
        <a href="/ekskul"
            class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-indigo-800">Ekskul</a>

        @auth
            <a href="{{ route('dashboard_admin') }}"
                class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-indigo-800">Dashboard</a>

            @if (auth()->user()->role === 'admin')
                <a href="{{ route('akun.index') }}"
                    class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-indigo-800">Akun</a>
            @endif

            <a href="{{ route('notifikasi.index') }}"
                class="relative block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-indigo-800">

                <span class="relative">
                    <i class="fa fa-bell mr-1" aria-hidden="true"></i>

                    @if ($jumlahBelumDibaca > 0)
                        <span
                            class="absolute -top-2 -right-0.5 bg-red-600 text-white text-xs font-bold rounded-full px-1.5 py-0.5">
                            {{ $jumlahBelumDibaca }}
                        </span>
                    @endif
                </span>

                Notifikasi
            </a>


            <!-- Informasi user -->
            <div class="border-t border-gray-900 pt-8 pb-7">
                <div class="flex items-center px-5">
                    <div class="shrink-0">
                        <img class="h-10 w-10 rounded-full"
                            src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png' }}"
                            alt="User Avatar">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-white">{{ Auth::user()->nama }}</div>
                        <div class="text-sm font-medium text-gray-400">{{ Auth::user()->username }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="/profil"
                        class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-indigo-800">Profil</a>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit"
                            class="w-full text-left block rounded-md px-3 py-2 text-base font-medium text-red-500 hover:bg-indigo-800">
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}"
                class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-indigo-800">Login</a>
        @endauth
    </div>

</nav>

<!-- Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>
