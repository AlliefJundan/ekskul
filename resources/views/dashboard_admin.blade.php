<?php use Illuminate\Support\Str; ?>
<x-layout>


    <div class="container mx-auto mt-8">
        @if (Auth::check())
            <b>Haloo admin {{ Auth::user()->nama }}</b>
        @endif
        <h1 class="text-2xl font-bold mb-4">Daftar Ekskul</h1>

        <!-- Tombol Tambah Ekskul -->
        <div x-data="{ modalTambah: false }">
            @if (auth()->user()->jabatan)
                <button @click="modalTambah = true"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition">
                    Tambah Ekskul
                </button>
            @endif

            <!-- Modal Tambah Ekskul -->
            <div x-show="modalTambah" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                @click.away="if (!document.querySelector('.select2-container--open')) modalTambah = false"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                style="display: none;">

                <div class="bg-white rounded-lg p-6 w-96 shadow-lg relative">
                    <button @click="modalTambah = false"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">
                        ✖
                    </button>
                    <h2 class="text-xl font-bold mb-4">Tambah Ekskul</h2>
                    <form action="{{ route('ekskul.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700">Nama Ekskul</label>
                            <input type="text" name="nama_ekskul"
                                class="w-full border border-gray-300 rounded-md p-2">
                        </div>
                        <div class="mb-4">
                            <?php $jabatans = App\Models\Jabatan::all(); ?>
                            <label class="block text-gray-700">Nama Pembina</label>
                            <select name="id_pembina" class="w-full border border-gray-300 rounded-md p-2">
                                @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id_jabatan }}">{{ $jabatan->user }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Nama Ketua</label>
                            <input type="text" name="nama_ekskul"
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

    </div>

    <!-- Grid Ekskul -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-5">
        @foreach ($ekskuls as $ekskul)
            <!-- Card -->
            <div x-data="{ open: false }"
                class="cursor-pointer w-full max-w-sm mx-auto bg-white shadow-lg rounded-lg overflow-hidden flex flex-col">
                <div @click="open = true">
                    <img src="https://via.placeholder.com/400x200" alt="Card Image" class="w-full h-48 object-cover">
                    <div class="p-6 flex-1">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $ekskul->nama_ekskul }}</h2>
                        <p class="text-gray-600 mt-2">Klik untuk melihat detail</p>
                    </div>
                </div>

                <!-- Modal Detail Ekskul -->
                <div x-show="open" @click.away="open = false"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                    style="display: none;">
                    <div class="bg-white rounded-lg p-6 w-96 shadow-lg relative">
                        <!-- Tombol Close di pojok kanan atas -->
                        <button @click="open = false"
                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">
                            ✖
                        </button>
                        <h2 class="text-xl font-bold mb-4">Detail Ekskul</h2>
                        <p><strong>Nama Ekskul:</strong> {{ $ekskul->nama_ekskul ?? 'Belum ada' }}</p>
                        <p><strong>Nama Pembina:</strong> {{ $ekskul->pembina->nama ?? 'Belum ada' }}</p>
                        <p><strong>Nama Ketua:</strong> {{ $ekskul->nama_ketua ?? 'Belum ada' }}</p>
                        <p><strong>Jumlah Anggota:</strong> {{ $ekskul->jml_anggota ?? 'Belum ada' }}</p>


                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('ekskul.show', $ekskul->slug) }}"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                                Lihat
                            </a>


                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    </div>

</x-layout>
