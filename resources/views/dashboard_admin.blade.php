<?php use Illuminate\Support\Str; ?>
<x-layout>


    <div class="container mx-auto mt-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold">Sistem Informasi Ekstrakurikuler</h1>
            <p class="mt-4 text-xl font-bold">SMK Bakti Nusantara 666</p>
        </div>
        @if (Auth::check())
            <b>Halo {{ Auth::user()->nama }}</b>
        @endif

        @if (
            !auth()->check() ||
                (auth()->user()->role !== 'admin' &&
                    (!optional(auth()->user()->ekskulUser) ||
                        optional(auth()->user()->ekskulUser)->jabatan < 1 ||
                        optional(auth()->user()->ekskulUser)->jabatan > 4)))
            <div class="text-center mt-5">
                <h2 class="text-2xl font-bold">AYO DAFTAR ESKUL BIAR</h2>
                <h2 class="text-2xl font-bold">HIDUP KAMU GA NGEBOSENIN</h2>
            </div>
        @endif


        <!-- Tombol Tambah Ekskul -->
        <div x-data="{ modalTambah: false }">
            @if (auth()->user()->role == 'admin')
                <x-modal trigger="Tambah Ekskul" title="Tambah Ekskul"
                    buttonClass="bg-ekskul mt-4 text-white px-4 py-2 rounded-md font-bold hover:bg-ekskul3 transition">
                    <form action="{{ route('ekskul.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold">Nama Ekskul</label>
                            <input type="text" name="nama_ekskul"
                                class="w-full border border-gray-300 rounded-md p-2">
                        </div>
                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-gray-700 font-semibold">Gambar</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                name="image">
                            <!-- error message untuk title -->
                            @error('image')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700 font-semibold">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="5"
                                placeholder="Masukkan Deskripsi">{{ old('content') }}</textarea>

                            <!-- error message untuk content -->
                            @error('content')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mt-6 flex justify-center">
                            <button type="button" @click="open = false"
                                class="bg-gray-500 text-white px-4 py-2 font-semibold rounded-md hover:bg-gray-600 transition">
                                ✖ Batal
                            </button>
                            <button type="submit"
                                class="bg-ekskul text-white mx-4 font-semibold px-4 py-2 rounded-md hover:bg-ekskul3 transition">
                                ✔ Simpan
                            </button>
                        </div>
                    </form>
                </x-modal>
            @endif
        </div>
    </div>

    <!-- Grid Ekskul -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-3">
        @foreach ($ekskuls as $ekskul)
            <!-- Card -->
            <div x-data="{ open: false, editOpen: false }"
                class="cursor-pointer w-full max-w-sm mx-auto bg-white shadow-lg rounded-lg overflow-hidden flex flex-col">
                <div @click="open = true">
                    <img src="{{ asset('storage/' . $ekskul->gambar) }}" alt="Gambar Ekskul"
                        class="w-full h-60 object-cover">
                    <div class="p-6 flex-1">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $ekskul->nama_ekskul }}</h2>
                        <p>{{ $ekskul->deskripsi }}</p>
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
                        <button @click="open = false"
                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">
                            ✖
                        </button>
                        <h2 class="text-xl font-bold mb-4 text-center">Detail Ekskul</h2>
                        <img src="{{ asset('storage/' . $ekskul->gambar) }}" alt="Gambar Ekskul"
                            class="w-full h-60 object-cover">
                        <p class="mt-4"><strong>Nama Ekskul:</strong> {{ $ekskul->nama_ekskul ?? 'Belum ada' }}</p>
                        <p><strong>Nama Pembina:</strong> {{ $ekskul->pembina->user->nama ?? 'Belum ada' }}</p>
                        <p><strong>Nama Ketua:</strong> {{ $ekskul->ketua->user->nama ?? 'Belum ada' }}</p>
                        <p><strong>Jumlah Anggota:</strong> {{ $ekskul->users->count() }}</p>

                        <div class="mt-6 flex justify-between">
                            <a href="{{ route('ekskul.show', $ekskul->slug) }}"
                                class="bg-blue-500 w-full font-semibold text-center text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                                Lihat
                            </a>

                        </div>
                    </div>
                </div>

                <!-- Modal Edit Ekskul -->
                <div x-show="editOpen" @click.away="editOpen = false"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                    style="display: none;">
                    <div class="bg-white rounded-lg p-6 w-96 shadow-lg relative">
                        <button @click="editOpen = false"
                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">
                            ✖
                        </button>
                        <h2 class="text-xl font-bold mb-4">Edit Ekskul</h2>
                        <form action="{{ route('ekskul.update', $ekskul->id_ekskul) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nama_ekskul" class="block text-sm font-medium text-gray-700">Nama
                                    Ekskul</label>
                                <input type="text" name="nama_ekskul" id="nama_ekskul"
                                    class="form-input mt-1 block w-full" value="{{ $ekskul->nama_ekskul }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-input mt-1 block w-full" rows="3" required>{{ $ekskul->deskripsi }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar
                                    Ekskul</label>
                                <input type="file" name="gambar" id="gambar"
                                    class="form-input mt-1 block w-full">
                                <small class="text-gray-500">Kosongkan jika tidak ingin mengubah gambar.</small>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="submit"
                                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

</x-layout>
