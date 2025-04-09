<nav class="bg-indigo-900 relative shadow-lg ">
    <div class="absolute inset-x-0 bottom-0 h-2 bg-amber-400 rounded-b-lg"></div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center w-full justify-between">
                <a href="{{ route('dashboard_admin') }}" class="shrink-0">
                    <img width="150" src="{{ asset('img/logoo.png') }}" alt="Your Company">
                </a>
            </div>


            <!-- Hamburger Menu Button -->
            <button id="menu-toggle" class="md:hidden text-white focus:outline-none">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Navigation Links -->
            <div id="menu"
                class="hidden md:block md:flex md:items-center md:space-x-4 w-full md:w-auto bg-indigo-900 md:bg-transparent absolute md:relative top-16 left-0 right-0 md:top-0 md:left-auto md:right-auto p-4 md:p-0 z-10">
                @if (Request::is('kuis*') || Request::is('materi*') || Request::is('ekskul*'))
                    <a href="/"
                        class="text-white font-semibold hover:text-amber-400 block md:inline-block">Home</a>
                    @auth
                        <a href="{{ route('dashboard_admin') }}"
                            class="text-white font-semibold hover:text-amber-400 block md:inline-block">Dashboard</a>
                        @if (auth()->user()->role == 'admin')
                            <a href="{{ route('akun.index') }}"
                                class="text-white font-semibold hover:text-amber-400 block md:inline-block">Akun</a>
                        @endif
                        <a href="{{ route('notifikasi.index') }}"
                            class="relative text-white font-semibold hover:text-amber-400 block md:inline-block">
                            <i class="fa fa-bell" aria-hidden="true"></i>

                            @php
                                $jumlahBelumDibaca = auth()->user()->notifikasiUser->where('is_read', false)->count();
                            @endphp

                            @if ($jumlahBelumDibaca > 0)
                                <span
                                    class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-1.5 py-0.5">
                                    {{ $jumlahBelumDibaca }}
                                </span>
                            @endif
                        </a>


                        <form action="{{ route('logout') }}" method="post" class="inline">
                            @csrf
                            <button type="submit"
                                class="text-white hover:text-amber-400  block md:inline-block flex items-center">
                                <i class="fa fa-sign-out" aria-hidden="true">Logout</i>

                            </button>
                        </form>
                    @endauth
                @else
                    <a href="/"
                        class="text-white font-semibold hover:text-amber-400 block md:inline-block">Home</a>
                    <a href="ekskul"
                        class="text-white font-semibold hover:text-amber-400 block md:inline-block">Ekskul</a>

                    @guest
                        <a href="/login"
                            class="text-white font-semibold hover:text-amber-400 block md:inline-block">Login</a>
                    @endguest

                    @auth
                        <a href="{{ route('dashboard_admin') }}"
                            class="text-white font-semibold hover:text-amber-400 block md:inline-block">Dashboard</a>
                        <a href="{{ route('notifikasi.index') }}"
                            class="relative text-white font-semibold hover:text-amber-400 block md:inline-block">
                            <i class="fa fa-bell" aria-hidden="true"></i>

                            @php
                                $jumlahBelumDibaca = auth()->user()->notifikasiUser->where('is_read', false)->count();
                            @endphp

                            @if ($jumlahBelumDibaca > 0)
                                <span
                                    class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-1.5 py-0.5">
                                    {{ $jumlahBelumDibaca }}
                                </span>
                            @endif
                        </a>

                        <form action="{{ route('logout') }}" method="post" class="inline">
                            @csrf
                            <button type="submit" class="text-white  hover:text-amber-400 block md:inline-block ">
                                <i class="fa fa-sign-out" aria-hidden="true">Logout</i>

                            </button>
                        </form>
                    @endauth
                @endif
            </div>
        </div>
    </div>
    </div>
</nav>

<script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
        document.getElementById('menu').classList.toggle('hidden');
    });
</script>
