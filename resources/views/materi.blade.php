<x-layout>
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Materi untuk {{ $ekskul->slug }}</h1>

        <!-- Form Pencarian -->
        <div class="flex justify-between mb-4">
            <div>
                <x-modal title="Tambah Materi" trigger="Tambah Materi">
                    <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_ekskul" value="{{ $ekskul->id_ekskul }}">

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
            </div>

            <div class="ml-auto">
                <form method="GET" action="{{ route('materi.index', $ekskul->slug) }}" class="flex">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="px-4 py-2 border rounded-l-lg bg-gray-200" placeholder="Cari materi...">
                    <button type="submit" class="px-4 py-2 bg-ekskul2 hover:bg-indigo-700 text-white rounded-r-lg">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar Materi -->
        <div class="grid gap-6 mt-8" style="grid-template-columns: auto 1fr;">
            <!-- Card Kecil (Jumlah Anggota) -->
            <div class="bg-ekskul rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5 flex flex-col justify-center items-center"
                style="height: 200px">
                <h4 class="text-xl text-ekskul2 font-bold mb-2">Jumlah Anggota</h4>
                <p class="text-gray-700 text-bold">
                    <span class="text-xl font-bold text-indigo-900">{{ $ekskul->jml_anggota }}</span>
                    anggota tergabung dalam ekskul ini.
                </p>
            </div>

            <!-- Card Besar (Daftar Materi) -->
            <div class="bg-indigo-900 rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5">
                @if ($materi->count() > 0)
                    @foreach ($materi as $item)
                        <div class="shadow-lg rounded-lg p-4 flex justify-between items-center bg-white mb-3">
                            <h3 class="text-indigo-900 font-bold">{{ $item->isi_materi }}</h3>

                            @if ($item->lampiran_materi)
                                <div class="flex space-x-4">
                                    <!-- Lihat Lampiran -->
                                    <a href="{{ asset('storage/' . $item->lampiran_materi) }}" target="_blank"
                                        class="text-blue-500 underline">
                                        Lihat Lampiran
                                    </a>

                                    <!-- Tombol Unduh -->
                                    <a href="{{ route('materi.download', $item->id_materi) }}"
                                        class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600 transition">
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
                    <h1 class="text-white font-semibold mb-2">Tidak ada materi tersedia untuk ekskul ini.</h1>
                @endif
            </div>
        </div>
    </div>
</x-layout>
