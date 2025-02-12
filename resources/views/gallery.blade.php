<section id="gallery" class="container mx-auto px-6 py-12">
    <div class="relative flex justify-center">
        <a href="#" class="relative inline-flex items-center px-6 py-3 text-white bg-indigo-900 font-semibold text-lg rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
            Galeri
            <span class="absolute -bottom-1 -right-1 bg-orange-400 h-full w-full rounded-2xl -z-10"></span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
        @foreach ($ekskuls as $ekskul)
            <div class="relative bg-indigo-800 text-white max-w-sm rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-2 hover:shadow-xl">
                <span class="absolute -bottom-2 -right-2 bg-orange-400 h-full w-full rounded-lg -z-10"></span>
                
                <!-- Gambar Ekskul -->
                <img class="w-full h-48 object-cover" src="{{ asset('storage/' . $ekskul->gambar) }}" alt="{{ $ekskul->nama_ekskul }}">

                <div class="p-5">
                    <h4 class="text-xl font-semibold mb-2">{{ $ekskul->nama_ekskul }}</h4>
                    <p class="text-gray-300 text-sm">{{ $ekskul->deskripsi }}</p>
                    <button class="mt-3 bg-amber-400 text-indigo-900 px-4 py-2 rounded-lg shadow-md hover:bg-amber-500 transition">
                        Lihat Detail →
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</section>
