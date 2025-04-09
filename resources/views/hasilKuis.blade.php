<x-layout>
    <div class="container px-4 mx-auto mt-8">
        <div class="flex justify-beetween mb-3">
            <div>
                <x-button1 href="{{ route('kuis.show', $ekskul->slug) }}">
                    Kembali
                </x-button1>
            </div>
            <div class="ml-auto">
                <form method="GET" action="{{ route('kuis.hasilKuis', $ekskul->slug) }}" class="flex">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="px-4 py-2 border rounded-l-lg bg-gray-200" placeholder="Cari kuis...">
                    <button type="submit" class="px-4 py-2 bg-ekskul2 hover:bg-indigo-700 text-white rounded-r-lg">
                        Cari
                    </button>
                </form>
            </div>
        </div>
        <div class="bg-indigo-900 rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5">
            @if ($kuis->count() > 0)
                @foreach ($kuis as $item)
                    <div class="shadow-lg rounded-lg p-4 flex justify-between items-center bg-white mb-3">
                        <h3 class="text-indigo-900 font-bold">{{ $item->nama_kuis }}</h3>
                        <div class="flex gap-4">
                            <x-button1 href="{{ route('hasil_kuis.hasil', ['slug' => $item->slug]) }}">
                                Lihat Hasil
                            </x-button1>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination Links -->
                <div class="mt-6">
                    {{ $kuis->appends(['search' => request('search')])->links('pagination::tailwind') }}
                </div>
            @else
                <h1 class="text-white text-center font-semibold mb-2">Tidak ada hasil kuis tersedia untuk ekskul ini.
                </h1>
            @endif
        </div>
    </div>
</x-layout>
