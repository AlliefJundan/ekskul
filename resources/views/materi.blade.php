<x-layout>
    <div class="container mx-auto mt-8 px-4">
        <div class="flex items-center mb-8">
            <a href="javascript:history.back()"
                class="flex items-center px-3 py-2 text-white rounded-lg shadow-md bg-yellow-500 hover:bg-blue-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        </div>

        <!-- Header Materi -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
            @if (auth()->check() &&
                    (auth()->user()->role === 'admin' ||
                        (optional(auth()->user()->ekskulUser)->jabatan >= 1 && optional(auth()->user()->ekskulUser)->jabatan <= 4)))
                <x-modal title="Tambah Materi" trigger="Tambah Materi">
                    <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_ekskul" value="{{ $ekskul->id_ekskul }}">
                        <input type="hidden" name="id_user" value="{{ Auth::user()->id_user }}">

                        <div class="mb-4">
                            <label class="block text-white">Isi Materi</label>
                            <textarea name="isi_materi" class="w-full border border-gray-300 rounded-md p-2" placeholder="Masukkan Materi" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-white">Lampiran (Opsional)</label>
                            <input type="file" name="lampiran_materi"
                                class="w-full text-white border border-gray-300 rounded-md p-2">
                        </div>

                        <div class="mt-6 flex justify-center">
                            <button type="submit"
                                class="bg-ekskul font-bold text-ekskul2 px-4 py-2 rounded-md hover:bg-blue-600 transition">
                                ✔ Simpan
                            </button>
                        </div>
                    </form>
                </x-modal>
            @endif

            <!-- Judul Materi -->
            <h1 class="text-2xl font-bold text-center md:flex-1">Materi untuk {{ $ekskul->slug }}</h1>

            <!-- Form Pencarian -->
            <form method="GET" action="{{ route('materi.index', $ekskul->slug) }}" class="flex w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="px-4 py-2 border rounded-l-lg bg-gray-200 w-full md:w-auto" placeholder="Cari materi...">
                <button type="submit" class="px-4 py-2 bg-ekskul2 hover:bg-indigo-700 text-white rounded-r-lg">
                    Cari
                </button>
            </form>
        </div>

        <!-- Daftar Materi -->
        <div class="grid gap-6 mt-8 grid-cols-1 md:grid-cols-3">
            <!-- Card Kecil (Jumlah Anggota) -->
            <div
                class="bg-ekskul rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5 flex flex-col justify-center items-center text-center">
                <h4 class="text-xl text-ekskul2 font-bold mb-2">Jumlah Anggota</h4>
                <p class="text-gray-700 text-bold">
                    <span class="text-xl font-bold text-indigo-900">{{ $ekskul->jml_anggota }}</span> anggota tergabung
                    dalam ekskul ini.
                </p>
            </div>

            <!-- Card Besar (Daftar Materi) - Full Width di Mobile -->
            <div class="md:col-span-2 bg-indigo-900 rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5">
                @if ($materi->count() > 0)
                    @foreach ($materi as $item)
                        <div
                            class="shadow-lg rounded-lg p-4 flex flex-col md:flex-row justify-between items-center bg-white mb-3">
                            <h3 class="text-indigo-900 font-bold">{{ $item->isi_materi }}</h3>

                            @if ($item->lampiran_materi)
                                <div class="flex flex-col md:flex-row md:space-x-4 w-full md:w-auto mt-2 md:mt-0">
                                    <a href="{{ asset('storage/' . $item->lampiran_materi) }}" target="_blank"
                                        class="text-blue-500 underline text-center">
                                        Lihat Lampiran
                                    </a>

                                    <a href="{{ route('materi.download', $item->id_materi) }}"
                                        class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600 transition text-center">
                                        Download
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <!-- Pagination Links -->
                    <div class="mt-6">
                        {{ $materi->appends(['search' => request('search')])->links('pagination::tailwind') }}
                    </div>
                @else
                    <h1 class="text-white font-semibold mb-2 text-center">Tidak ada materi tersedia untuk ekskul ini.
                    </h1>
                @endif
            </div>
        </div>
    </div>
</x-layout>
