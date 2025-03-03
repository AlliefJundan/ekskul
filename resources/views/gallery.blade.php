<section id="gallery" class="container mx-auto px-6 py-12" x-data="{ modalOpen: false, selectedEkskul: null }">
    <div class="relative flex justify-center">
        <a href="#"
            class="relative inline-flex items-center px-6 py-3 text-white bg-indigo-900 font-semibold text-lg rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
            Galeri
            <span class="absolute -bottom-1 -right-1 bg-orange-400 h-full w-full rounded-2xl -z-10"></span>
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
        @foreach ($ekskuls as $ekskul)
            <div
                class="relative bg-indigo-800 text-white max-w-sm rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-2 hover:shadow-xl">
                <span class="absolute -bottom-2 -right-2 bg-orange-400 h-full w-full rounded-lg -z-10"></span>

                <!-- Gambar Ekskul -->
                <img class="w-full h-60 object-cover" src="{{ asset('storage/' . $ekskul->gambar) }}"
                    alt="{{ $ekskul->nama_ekskul }}">

                <div class="p-5">
                    <h4 class="text-xl font-semibold mb-2">{{ $ekskul->nama_ekskul }}</h4>
                    <p class="text-gray-300 text-sm">{{ $ekskul->deskripsi }}</p>
                    <button
                        @click="modalOpen = true; selectedEkskul = { 
                        nama: '{{ $ekskul->nama_ekskul }}',
                        deskripsi: '{{ $ekskul->deskripsi }}',
                        pembina: '{{ $ekskul->pembina->user->nama ?? 'Belum ada' }}',
                        ketua: '{{ $ekskul->ketua->user->nama ?? 'Belum ada' }}',
                        jumlah_anggota: '{{ $ekskul->users->count() }}',
                        gambar: '{{ asset('storage/' . $ekskul->gambar) }}'
                    }"
                        class="mt-3 bg-amber-400 text-indigo-900 font-semibold px-4 py-2 rounded-lg shadow-md hover:bg-amber-500 transition">
                        Lihat Detail →
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Detail -->
    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        @click.away="modalOpen = false" x-transition>
        <div class="bg-white rounded-lg p-6 w-96 shadow-lg relative">
            <button @click="modalOpen = false"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">✖</button>
            <h2 class="text-xl font-bold mb-4 text-gray-900" x-text="selectedEkskul?.nama"></h2>
<<<<<<< HEAD
            <img class="w-full h-60 object-cover rounded-md mb-4" :src="selectedEkskul?.gambar" alt="Gambar Ekskul">
=======
            <img class="w-full h-48 object-cover rounded-md mb-4" :src="selectedEkskul?.gambar" alt="Gambar Ekskul">

            <p><strong>Nama Ekskul:</strong> <span x-text="selectedEkskul?.nama ?? 'Belum ada'"></span></p>
            <p><strong>Nama Pembina:</strong> <span x-text="selectedEkskul?.pembina ?? 'Belum ada'"></span></p>
            <p><strong>Nama Ketua:</strong> <span x-text="selectedEkskul?.ketua ?? 'Belum ada'"></span></p>
            <p><strong>Jumlah Anggota:</strong> <span x-text="selectedEkskul?.jumlah_anggota ?? '0'"></span></p>
>>>>>>> 1db534ea073811588263634b98960e8a9c0d6583

            <p><strong>Nama Ekskul:</strong> <span x-text="selectedEkskul?.nama ?? 'Belum ada'"></span></p>
            <p><strong>Nama Pembina:</strong> <span x-text="selectedEkskul?.pembina ?? 'Belum ada'"></span></p>
            <p><strong>Nama Ketua:</strong> <span x-text="selectedEkskul?.ketua ?? 'Belum ada'"></span></p>
            <p><strong>Jumlah Anggota:</strong> <span x-text="selectedEkskul?.jumlah_anggota ?? '0'"></span></p>

            <!-- button daftar -->
            <div class="flex justify-center mt-8" x-data="{ openConfirm: false, openModal: false }">
                @if (auth()->check())
                    <button @click="openConfirm = true"
                        class="relative inline-flex items-center px-6 py-3 bg-amber-400 text-indigo-900 font-semibold text-lg rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
                        Daftar Sekarang!
                        <span class="absolute -bottom-1 -right-1 bg-orange-500 h-full w-full rounded-2xl -z-10"></span>
                    </button>
                @else
                    <a href="{{ route('login') }}"
                        class="relative inline-flex items-center px-6 py-3 bg-amber-400 text-indigo-900 font-semibold text-lg rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
                        Daftar Sekarang!
                        <span class="absolute -bottom-1 -right-1 bg-orange-500 h-full w-full rounded-2xl -z-10"></span>
                    </a>
                @endif

                <!-- Modal Konfirmasi -->
                <div x-show="openConfirm"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                    @click.away="openConfirm = false" x-transition>
                    <div class="bg-white rounded-lg p-6 w-96 shadow-lg relative">
                        <h2 class="text-xl font-bold mb-4 text-gray-900 text-center">Yakin mau masuk?</h2>
<<<<<<< HEAD
                        @if (auth()->check())
                            <form method="POST" action="/pendaftaran/store">
                                @csrf
                                <input type="hidden" name='id_user' id='id_user'
                                    value="{{ Auth::user()->id_user }}">
                                <input type="hidden" name="id_ekskul" id="id_ekskul" value="{{ $ekskul->id_ekskul }}">
                                <button @click="openConfirm = true"
                                    class="relative inline-flex items-center px-6 py-3 bg-amber-400 text-indigo-900 font-semibold text-lg rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
                                    Daftar Sekarang!
                                    <span
                                        class="absolute -bottom-1 -right-1 bg-orange-500 h-full w-full rounded-2xl -z-10"></span>
                                </button>
                            @else
                                <button disabled
                                    class="relative inline-flex items-center px-6 py-3 bg-gray-400 text-gray-700 font-semibold text-lg rounded-2xl shadow-md cursor-not-allowed">
                                    Daftar Sekarang!
                                    <span
                                        class="absolute -bottom-1 -right-1 bg-gray-500 h-full w-full rounded-2xl -z-10"></span>
                                </button>
                        @endif

                    </div>
                    </form>
                </div>
            </div>

            <!-- Modal Tunggu ACC -->
            <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                @click.away="openModal = false" x-transition>
                <div class="bg-white rounded-lg p-6 w-96 shadow-lg relative">
                    <button @click="openModal = false"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">✖
                    </button>
                    <h1 class="text-xl text-center font-bold mb-4 text-gray-900">Tunggu ya sabar gess</h1>
                    <h1 class="text-center font-bold">Tunggu ketua ACC</h1>
                </div>
            </div>
        </div>
    </div>
=======
                        <div class="flex justify-center gap-4 mt-4">
                            <button @click="openConfirm = false"
                                class="bg-danger text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-400 transition">
                                Tidak
                            </button>
                            <button @click="openConfirm = false; openModal = true"
                                class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600 transition">
                                Ya
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal Tunggu ACC -->
                <div x-show="openModal"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                    @click.away="openModal = false" x-transition>
                    <div class="bg-white rounded-lg p-6 w-96 shadow-lg relative">
                        <button @click="openModal = false"
                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">✖
                        </button>
                        <h1 class="text-xl text-center font-bold mb-4 text-gray-900">Tunggu ya sabar gess</h1>
                        <h1 class="text-center font-bold">Tunggu ketua ACC</h1>
                    </div>
                </div>
            </div>


        </div>
>>>>>>> 1db534ea073811588263634b98960e8a9c0d6583
    </div>
</section>
