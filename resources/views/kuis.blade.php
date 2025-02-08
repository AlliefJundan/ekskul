<x-layout>
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Kuis untuk {{ $ekskul->nama_ekskul }}</h1>

        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('kuis.show', $ekskul->slug) }}" class="mb-4 flex">
            <input type="text" name="search" value="{{ request('search') }}"
                class="px-4 py-2 border rounded-l-lg w-full" placeholder="Cari kuis...">
            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-r-lg">
                Cari
            </button>
        </form>
        <div x-data="{ modalTambah: false }">
            <button @click="modalTambah = true"
                class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition">
                Tambah Kuis
            </button>

            <!-- Modal Tambah Ekskul -->
            <div x-show="modalTambah" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                @click.away="modalTambah = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90" style="display: none;">

                <div class="bg-white rounded-lg p-6 w-96 shadow-lg relative">
                    <button @click="modalTambah = false"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">
                        ✖
                    </button>
                    <h2 class="text-xl font-bold mb-4">Tambah Kuis</h2>
                    <form action="{{ route('ekskul.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700">Nama Ekskul</label>
                            <input type="text" name="nama_ekskul"
                                class="w-full border border-gray-300 rounded-md p-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Nama Pembina</label>
                            <input type="text" name="nama_pembina"
                                class="w-full border border-gray-300 rounded-md p-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Nama Ketua</label>
                            <input type="text" name="nama_ketua"
                                class="w-full border border-gray-300 rounded-md p-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Jumlah Anggota</label>
                            <input type="number" name="jml_anggota"
                                class="w-full border border-gray-300 rounded-md p-2">
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="button" @click="modalTambah = false"
                                class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                                ✖ Batal
                            </button>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2 hover:bg-blue-600 transition">
                                ✔ Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="grid gap-6 mt-8" style="grid-template-columns: auto 1fr;">
            <!-- Card Kecil (Total Kuis) -->
            <div class="bg-ekskul rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5 flex flex-col justify-center items-center"
                style="height: 200px">
                <h4 class="text-xl text-ekskul2 font-semibold mb-2">Total Kuis</h4>
                <p class="text-gray-700 text-bold">Tersedia
                    <span class="text-xl font-bold text-indigo-900">{{ $kuis->total() }}</span>
                    kuis untuk ekskul ini.
                </p>
            </div>

            <!-- Card Besar (Daftar Kuis) -->
            <div class="bg-indigo-900 rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5">
                @if ($kuis->count() > 0)
                    @foreach ($kuis as $item)
                        <div class="shadow-lg rounded-lg p-4 flex justify-between items-center bg-white mb-3">
                            <h3 class="text-indigo-900 font-bold">{{ $item->nama_kuis }}</h3>
                            <div class="flex gap-4">
                                <a href="{{ $item->isi_kuis }}" target="_blank"
                                    class="px-4 py-2 bg-amber-400 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-md">
                                    Ikuti
                                </a>
                                <a href="{{ $item->isi_kuis }}" target="_blank"
                                    class="px-4 py-2 bg-amber-400 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-md">
                                    Hasil
                                </a>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination Links -->
                    <div class="mt-6">
                        {{ $kuis->appends(['search' => request('search')])->links('pagination::tailwind') }}
                    </div>
                @else
                    <h1 class="text-white font-semibold mb-2">Tidak ada kuis tersedia untuk ekskul ini.</h1>
                @endif
            </div>
        </div>
    </div>
</x-layout>
