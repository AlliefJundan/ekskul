<x-layout>
    <div class="container px-4 mx-auto mt-8">
        <div class="flex items-center mb-8">
            <a href="javascript:history.back()"
                class="flex items-center px-3 py-2 text-white rounded-lg shadow-md bg-yellow-500 hover:bg-blue-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        </div>

        <!-- Header -->
        <h1 class="mb-8 text-4xl font-bold text-center">{{ $ekskul->nama_ekskul }}</h1>

        <!-- Navigation Links in a Single Card (Responsive) -->
        <div class="flex flex-wrap justify-center gap-4 p-6 mb-8 rounded-lg shadow-lg bg-ekskul2">
            <a href="{{ route('materi.index', $ekskul->slug) }}"
                class="w-full px-4 py-2 font-semibold text-center text-black rounded-lg shadow-md bg-ekskul hover:bg-orange-600 sm:w-auto">
                Lihat Materi
            </a>
            <a href="{{ route('kuis.show', $ekskul->slug) }}"
                class="w-full px-4 py-2 font-semibold text-center text-black rounded-lg shadow-md bg-ekskul hover:bg-orange-600 sm:w-auto">
                Lihat Kuis
            </a>
            <a href="{{ route('anggota.show', $ekskul->slug) }}"
                class="w-full px-4 py-2 font-semibold text-center text-black rounded-lg shadow-md bg-ekskul hover:bg-orange-600 sm:w-auto">
                Anggota
            </a>
            <a href="{{ route('absensi.index', $ekskul->slug) }}"
                class="px-4 py-2 font-semibold text-black rounded-lg shadow-md bg-ekskul hover:bg-orange-600">
                Lihat Absensi
            </a>
        </div>

        <!-- Smaller Content Cards -->
        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Kartu Ekskul (Lebar 1 Kolom di Layar Besar) -->
            <div class="p-3 bg-white rounded-lg shadow-lg lg:col-span-1" style="height: 580px">
                <img src="{{ asset('storage/' . $ekskul->gambar) }}" alt="Gambar Ekskul"
                    class="w-full h-60 object-cover rounded-lg">
                <h3 class="mb-2 text-xl font-bold mt-4">Ekskul {{ $ekskul->nama_ekskul }}</h3>
                <p class="font-bold text-gray-600">Deskripsi Ekskul :</p>
                <p class="mb-4 text-gray-600">
                    {{ $ekskul->deskripsi }}
                </p>
                <p class="font-bold py-2 text-gray-600">Struktur Organisasi :</p>
                <div class="grid grid-cols-2 gap-2">
                    <p class="text-gray-600">Pembina :</p>
                    <p class="text-gray-600">{{ $ekskul->pembina->user->nama ?? 'Belum ada' }}</p>
                    <p class="text-gray-600">Ketua :</p>
                    <p class="text-gray-600">{{ $ekskul->ketua->user->nama ?? 'Belum ada' }}</p>
                    <p class="text-gray-600">Sekretaris :</p>
                    <p class="text-gray-600">{{ $ekskul->sekertaris->user->nama ?? 'Belum ada' }}</p>
                    <p class="text-gray-600">Bendahara :</p>
                    <p class="text-gray-600">{{ $ekskul->bendahara->user->nama ?? 'Belum ada' }}</p>
                </div>
            </div>

            <!-- Bagian Materi (Lebar 3 Kolom di Layar Besar) -->
            <div class="grid grid-cols-1 gap-3 md:col-span-2 lg:col-span-2">
                @if ($materi->count() > 0)
                    @foreach ($materi as $item)
                        <div class="bg-white rounded-lg shadow-lg w-full hover:shadow-xl transition duration-300 p-5">
                            <!-- Judul Materi -->
                            <h3 class="text-indigo-900 font-bold text-lg mb-2 truncate">{{ $item->user->nama }}
                            </h3>
                            <p class="text-gray-500 text-sm">{{ $item->created_at->diffForHumans() }}</p>
                            <!-- Tambahkan Waktu -->
                            <hr>
                            <h3 class="text-indigo-900 font-bold mt-3 text-lg mb-2 truncate">
                                {{ $item->isi_materi }}
                            </h3>
                            <!-- Tombol Lampiran & Download -->
                            @if ($item->lampiran_materi)
                                <div class="flex justify-between items-center mt-3">
                                    <!-- Lihat Lampiran -->
                                    <a href="{{ asset('storage/' . $item->lampiran_materi) }}" target="_blank"
                                        class="text-blue-500 underline text-sm hover:text-blue-700 transition">
                                        Lihat Lampiran
                                    </a>

                                    <!-- Tombol Unduh -->
                                    <a href="{{ route('materi.download', $item->id_materi) }}"
                                        class="bg-green-500 text-white px-3 py-1 rounded-md text-sm hover:bg-green-600 transition">
                                        Download
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <!-- Pagination Links -->
                    <div class="col-span-full mt-6 flex justify-center">
                        {{ $materi->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                @else
                    <div class="col-span-full text-center">
                        <h1 class="text-gray-600 font-semibold">Tidak ada materi tersedia untuk ekskul ini.</h1>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>
