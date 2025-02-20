<nav class="bg-indigo-900 relative shadow-lg">
    <div class="absolute inset-x-0 bottom-0 h-2 bg-amber-400 rounded-b-lg"></div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center w-full justify-between">
                <div class="shrink-0">
                    <img class="size-8"
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQbWZUP1A5Frsl8Gc3GeuB31hfIA9xib6SI2Q&s"
                        alt="Your Company">
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        @if (Request::is('kuis*') || Request::is('materi*') || Request::is('ekskul*'))
                            <!-- Navbar untuk halaman Kuis, Materi, dan Ekskul -->
                            <a href="/" class="text-white font-semibold hover:text-amber-400">Home</a>
                            <a href="/materi" class="text-white font-semibold hover:text-amber-400">Materi</a>
                            <a href="" class="text-white font-semibold hover:text-amber-400">Kuis</a>
                          

                            @auth
                                <a href="{{ route('dashboard_admin') }}" class="text-white font-semibold hover:text-amber-400">Dashboard</a>
                                 @if (auth()->user()->role == 'admin')
                                    <a href="{{ route('akun.index') }}" class="text-white font-semibold hover:text-amber-400 flex items-center">
                                        <span class="ml-2">Akun</span>
                                    </a>
                                @endif
                                <form action="{{ route('logout') }}" method="post" class="inline">
                                    @csrf
                                    <button type="submit" class="text-white hover:text-amber-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-7.5A2.25 2.25 0 003.75 5.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15m4.5-3h-13.5m0 0l3-3m-3 3l3 3"/>
                                        </svg>
                                    </button>
                                </form>
                            @endauth

                        @else
                            <!-- Navbar Default -->
                            <a href="/" class="text-white font-semibold hover:text-amber-400">Home</a>
                            <a href="#gallery" class="text-white font-semibold hover:text-amber-400">Galeri</a>
                            <a href="#about" class="text-white font-semibold hover:text-amber-400">About</a>
                            
                            @guest
                                <a href="/login" class="text-white font-semibold hover:text-amber-400">Login</a>
                            @endguest   
                            
                            @auth
                                <a href="{{ route('dashboard_admin') }}" class="text-white font-semibold hover:text-amber-400">Dashboard</a>

                                <form action="{{ route('logout') }}" method="post" class="inline">
                                    @csrf
                                    <button type="submit" class="text-white hover:text-amber-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-7.5A2.25 2.25 0 003.75 5.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15m4.5-3h-13.5m0 0l3-3m-3 3l3 3"/>
                                        </svg>
                                    </button>
                                </form>
                            @endauth
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</nav>
