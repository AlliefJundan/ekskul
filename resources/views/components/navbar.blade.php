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
                        <a href="/" class="text-white font-semibold hover:text-amber-400">Home</a>
                        <a href="#gallery" class="text-white font-semibold hover:text-amber-400">Galeri</a>
                        <a href="#about" class="text-white font-semibold hover:text-amber-400">About</a>
                        <a href="/login" class="text-white font-semibold hover:text-amber-400">Login</a>
                    </div>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn btn-danger btn-sm">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
