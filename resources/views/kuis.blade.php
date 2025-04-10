<x-layout>
    <div class="container mx-auto mt-8 px-4">
        <div class="flex items-center mb-8">
            <x-button1 href="{{ route('ekskul.show', $ekskul->slug) }}">Kembali</x-button>
        </div>
        <h1 class="mb-8 text-4xl font-bold text-center">Kuis ekskul {{ $ekskul->nama_ekskul }}</h1>
        <!-- Header & Form Pencarian -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
            <div class="w-full md:w-auto">
                @php
                    $currentEkskul = (new \App\Models\EkskulUser())->getCurrentEkskul($ekskul->id_ekskul);
                    $canManageKuis =
                        auth()->check() &&
                        (auth()->user()->role === 'admin' ||
                            (optional($currentEkskul)->jabatan >= 1 && optional($currentEkskul)->jabatan < 4));
                @endphp

                @if ($canManageKuis)
                    <div class="flex flex-wrap items-center gap-3">
                        <x-modal title="Tambah Kuis" trigger="Tambah Kuis">
                            <form action="{{ route('kuis.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_ekskul" value="{{ $ekskul->id_ekskul }}">
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold">Nama Kuis</label>
                                    <input type="text" name="nama_kuis"
                                        class="w-full border border-gray-300 rounded-md p-2"
                                        placeholder="Masukan Nama Kuis" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold">Link Kuis</label>
                                    <input type="text" name="isi_kuis"
                                        class="w-full border border-gray-300 rounded-md p-2"
                                        placeholder="Masukan Link Kuis" required>
                                </div>
                                <div class="mt-6 flex justify-center">
                                    <button type="submit"
                                        class="bg-ekskul font-bold text-ekskul2 px-4 py-2 rounded-md hover:bg-blue-600 transition">✔
                                        Simpan</button>
                                </div>
                            </form>
                        </x-modal>

                        <a href="{{ route('kuis.hasilKuis', $ekskul->slug) }}"
                            class="px-4 py-2 font-semibold text-black rounded-lg shadow-md bg-ekskul hover:bg-orange-600">
                            Lihat Hasil Kuis
                        </a>
                    </div>
                @endif
            </div>

            <h1 class="text-2xl font-bold text-center md:flex-1"></h1>

            <form method="GET" action="{{ route('kuis.show', $ekskul->slug) }}" class="w-full md:w-auto flex">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="px-4 py-2 border rounded-l-lg bg-gray-200 w-full md:w-auto" placeholder="Cari kuis...">
                <button type="submit"
                    class="px-4 py-2 bg-ekskul2 hover:bg-indigo-700 text-white rounded-r-lg">Cari</button>
            </form>
        </div>

        <!-- Daftar Kuis -->
        <div class="grid gap-6 mt-8 grid-cols-1 md:grid-cols-3">
            <!-- Card Kecil (Total Kuis) -->
            <div
                class="bg-ekskul rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5 flex flex-col 
                justify-center items-center text-center self-start">
                <h4 class="text-xl text-ekskul2 font-bold mb-2">Total Kuis</h4>
                <p class="text-gray-700 font-bold">
                    <span class="text-xl font-bold text-indigo-900">{{ $kuis->total() }}</span> kuis tersedia.
                </p>
            </div>

            <!-- Card Besar (Daftar Kuis) -->
            <div class="md:col-span-2 bg-indigo-900 rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5">
                @if ($kuis->count() > 0)
                    @foreach ($kuis as $item)
                        @php
                            $sudahMengirim = in_array($item->id_kuis, $hasilKuis);
                        @endphp

                        <div
                            class="shadow-lg rounded-lg p-4 flex flex-col md:flex-row justify-between items-center bg-white mb-3">
                            <h3 class="text-indigo-900 font-bold">{{ $item->nama_kuis }}</h3>
                            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto mt-2 md:mt-0">
                                <!-- Tombol Ikuti -->
                                <a href="{{ $item->isi_kuis }}" target="_blank"
                                    class="px-4 py-2 bg-ekskul hover:bg-orange-600 text-indigo-900 font-bold rounded-lg shadow-md text-center 
                {{ $sudahMengirim ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}">
                                    Ikuti
                                </a>

                                <!-- Modal Tambah Hasil -->
                                <x-modal title="Masukan Hasil Kuis" trigger="Tambah Hasil"
                                    buttonClass="bg-ekskul text-ekskul2 px-4 py-2 w-full sm:w-auto rounded-md font-bold hover:bg-orange-600 transition text-center 
                {{ $sudahMengirim ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}">
                                    <form action="{{ route('kuis.hasil') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id_kuis" value="{{ $item->id_kuis }}">
                                        <input type="hidden" name="id_user" value="{{ Auth::user()->id_user }}">
                                        <input type="hidden" name="id_ekskul" value="{{ $ekskul->id_ekskul }}">

                                        <div class="mb-4">
                                            <label class="block text-gray-700 font-semibold ">Score</label>
                                            <input type="number" name="skor"
                                                class="w-full border border-gray-300 rounded-md p-2"
                                                placeholder="Masukan score" required>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-gray-700 font-semibold">Bukti</label>
                                            <input type="file" name="bukti" accept=".jpg,.jpeg,.png,.pdf"
                                                class="w-full border border-gray-300 rounded-md p-2 bg-gray-100">
                                        </div>

                                        <div class="mt-6 flex justify-center">
                                            <button type="submit"
                                                class="bg-ekskul text-ekskul2 font-bold px-4 py-2 rounded-md hover:bg-blue-600 transition">
                                                ✔ Simpan
                                            </button>
                                        </div>
                                    </form>
                                </x-modal>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-6">
                        {{ $kuis->appends(['search' => request('search')])->links('pagination::tailwind') }}
                    </div>
                @else
                    <h1 class="text-white font-semibold text-center">Tidak ada kuis tersedia.</h1>
                @endif
            </div>
        </div>
    </div>
</x-layout>
