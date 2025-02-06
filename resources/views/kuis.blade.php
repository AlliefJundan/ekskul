<x-layout>
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Kuis untuk {{ $ekskul->nama_ekskul }}</h1>

        <div class="grid gap-6 mt-8" style="grid-template-columns: auto 1fr;">
            <!-- Card Kecil -->
            <div class="bg-ekskul rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5" style="height: 200px">
                <h4 class="text-xl font-semibold mb-2">Kuis Pendek</h4>
                <p class="text-gray-700 text-sm">Card ini hanya memakan sedikit tempat.</p>
            </div>

            <!-- Card Besar -->
            <div class="bg-indigo-900 rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5">
                @foreach ($kuis as $item)
                    <div class="grid grid-cols-5 grid-rows-2 gap-4">
                        <div class="col-span-3">
                            <h4 class="text-xl font-semibold">{{ $item->nama_kuis }}</h4>
                        </div>
                        <div class="col-span-2 flex justify-end">
                            <a href="{{ route('kuis.index', $ekskul->id) }}"
                                class="inline-block px-4 py-2 bg-amber-400 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-md">
                                Pelajari
                            </a>
                        </div>
                        <div class="col-span-5 row-start-2">
                            <hr class="mt-4">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>
