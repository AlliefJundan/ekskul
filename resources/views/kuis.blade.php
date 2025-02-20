<x-layout>
    <div class="container mx-auto mt-8">
        <div class="flex items-center mb-8">
            <a href="javascript:history.back()" class="flex items-center px-3 py-2 text-white rounded-lg shadow-md bg-yellow-500 hover:bg-blue-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        </div>
        <!-- Form Pencarian -->
        <div class="flex justify-between items-center mb-4">
            <div>
                @if (auth()->check() && (auth()->user()->role === 'admin' || (optional(auth()->user()->ekskulUser)->jabatan >= 1 && optional(auth()->user()->ekskulUser)->jabatan <= 4)))
                    <x-modal title="Tambah Kuis" trigger="Tambah Kuis">
                        <form action="{{ route('kuis.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_ekskul" value="{{ $ekskul->id_ekskul }}">
                            <div class="mb-4">
                                <label class="block text-white">Nama Kuis</label>
                                <input type="text" name="nama_kuis"
                                    class="w-full border border-gray-300 rounded-md p-2" placeholder="Masukan Nama Kuis"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-white">Link Kuis</label>
                                <input type="text" name="isi_kuis"
                                    class="w-full border border-gray-300 rounded-md p-2" placeholder="Masukan Link Kuis"
                                    required>
                            </div>
                            <div class="mt-6 flex justify-center items-end">
                                <button type="submit"
                                    class="bg-ekskul font-bold text-ekskul2 px-4 py-2 rounded-md ml-2 hover:bg-blue-600 transition">
                                    ✔ Simpan
                                </button>
                            </div>
                        </form>
                    </x-modal>
                @endif
            </div>

            <!-- Judul Kuis dipindahkan ke tengah -->
            <h1 class="text-2xl font-bold text-center flex-1">Kuis untuk {{ $ekskul->nama_ekskul }}</h1>

            <div class="ml-auto">
                <form method="GET" action="{{ route('kuis.show', $ekskul->slug) }}" class="flex">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="px-4 py-2 border rounded-l-lg bg-gray-200" placeholder="Cari kuis...">
                    <button type="submit" class="px-4 py-2 bg-ekskul2 hover:bg-indigo-700 text-white rounded-r-lg">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        <div class="grid gap-6 mt-8" style="grid-template-columns: auto 1fr;">
            <!-- Card Kecil (Total Kuis) -->
            <div class="bg-ekskul rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5 flex flex-col justify-center items-center"
                style="height: 200px">
                <h4 class="text-xl text-ekskul2 font-bold mb-2">Total Kuis</h4>
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
                                    class="px-4 py-2 bg-ekskul hover:bg-orange-600 text-indigo-900 font-bold rounded-lg shadow-md">
                                    Ikuti
                                </a>
                                <x-modal title="Masukan Hasil Kuis" trigger="Tambah Hasil"
                                    buttonClass="bg-ekskul text-ekskul2 px-4 py-2 rounded-md font-bold hover:bg-orange-600 transition">
                                    <form action="{{ route('kuis.hasil') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id_kuis" value="{{ $item->id_kuis }}">
                                        <input type="hidden" name="id_user" value="{{ Auth::user()->id_user }}">
                                        <input type="hidden" name="id_ekskul" value="{{ $ekskul->id_ekskul }}">
                                        <div class="mb-4">
                                            <label class="block text-white">Score</label>
                                            <input type="number" name="skor"
                                                class="w-full border border-gray-300 rounded-md p-2"
                                                placeholder="Masukan score yang didapat" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-white">Bukti</label>
                                            <input type="file" name="bukti" accept=".jpg,.jpeg,.png,.pdf"
                                                class="w-full border border-gray-300 rounded-md p-2 bg-gray-100">
                                        </div>
                                        <div class="mt-6 flex justify-center items-end">
                                            <button type="submit"
                                                class="bg-ekskul text-ekskul2 font-bold px-4 py-2 rounded-md ml-2 hover:bg-blue-600 transition">
                                                ✔ Simpan
                                            </button>
                                        </div>
                                    </form>
                                </x-modal>
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
