<x-layout>
    <div class="container px-4 mx-auto mt-8">
        <div class="flex items-center mb-8">
            <x-button1 href="{{ route('dashboard_admin') }}">Kembali</x-button1>
        </div>

        <!-- Header -->
        <h1 class="mb-8 text-4xl font-bold text-center">{{ $ekskul->nama_ekskul }}</h1>

        <div class="p-6 bg-wite rounded-lg shadow-lg">
            <!-- Nama Ekskul (Tengah) -->
            <div class="flex items-center justify-between mb-4 bg-ekskul text-black px-4 py-2 rounded-lg">
                <div></div>
                <h3 class="text-2xl font-bold text-center">Ekskul {{ $ekskul->nama_ekskul }}</h3>
                <div class="relative ml-3" x-data="{ isOpen: false }">
                    <div>
                        <button type="button" @click="isOpen = !isOpen" @keydown.escape.window="isOpen = false"
                            class="relative flex items-center justify-center w-10 h-10 rounded-full bg-[#F78903] text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-[#F78903] focus:outline-none hover:bg-[#d97802]"
                            id="user-menu-button" :aria-expanded="isOpen.toString()" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <!-- Ikon elipsis vertikal -->
                            <svg class="w-6 h-6" fill="none" stroke="black" stroke-width="4" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6h.01M12 12h.01M12 18h.01">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <!-- Dropdown menu -->
                    <div x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75 transform"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        @click.away="isOpen = false"
                        class="absolute right-0 z-10 mt-2 w-auto origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button">
                        @if (auth()->user()->role === 'admin' || optional(auth()->user()->ekskulUser)->jabatan == 2)
                            <!-- Tombol Edit -->
                            <div x-data="{ editOpen: false }">
                                <!-- Tombol Edit -->
                                <button @click="editOpen = true"
                                    class="block px-4 py-2 text-sl font-semibold w-full text-start text-red-700">
                                    Edit
                                </button>

                                <!-- Modal Edit Ekskul -->
                                <div x-show="editOpen" @click.away="editOpen = false"
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 scale-90"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-90" style="display: none;">
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
                                                <label for="nama_ekskul"
                                                    class="block text-sm font-medium text-gray-700">Nama Ekskul</label>
                                                <input type="text" name="nama_ekskul" id="nama_ekskul"
                                                    class="form-input mt-1 block w-full"
                                                    value="{{ $ekskul->nama_ekskul }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="deskripsi"
                                                    class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                                <textarea name="deskripsi" id="deskripsi" class="form-input mt-1 block w-full" rows="3" required>{{ $ekskul->deskripsi }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="gambar"
                                                    class="block text-sm font-medium text-gray-700">Gambar
                                                    Ekskul</label>
                                                <input type="file" name="gambar" id="gambar"
                                                    class="form-input mt-1 block w-full">
                                                <small class="text-gray-500">Kosongkan jika tidak ingin mengubah
                                                    gambar.</small>
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


                            <!-- Tombol Hapus -->
                            <x-modal trigger="Hapus" role="menuitem"
                                title="Apakah Anda yakin ingin menghapus ekskul {{ $ekskul->nama_ekskul }}"
                                buttonClass="block px-4 py-2 w-full text-start text-sl 2-full font-semibold  text-red-700">
                                <form action="{{ route('ekskul.destroy', $ekskul->id_ekskul) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin untuk menghapus ekskul {{ $ekskul->nama_ekskul }}? Ingat dengan menekan tombol OK ekskul beserta seluruh data yang terkait akan dihapus dan tidak dapat dikembalikan lagi.')">
                                    @csrf
                                    @method('DELETE')
                                    <div class="flex justify-center">
                                        <a @click="open = false" class="btn btn-secondary font-semibold">
                                            Batal
                                        </a>
                                        <button type="submit" class="btn btn-danger font-semibold mx-3">
                                            Hapus
                                        </button>
                                    </div>
                                </form>
                            </x-modal>
                        @endif


                        @if ($tanpaJabatan)
                            <x-modal trigger="keluar" role="menuitem"
                                title="Apakah anda yakin ingin keluar dari ekskul ini?"
                                buttonClass="block px-4 py-2 text-sl w-full text-start font-semibold text-red-700">
                                <form method="POST" action="{{ route('anggota.keluar', $ekskul->slug) }}"
                                    onsubmit="return confirm('Anda yakin ingin keluar dari Ekskul {{ $ekskul->nama_ekskul }}? ')">
                                    @csrf
                                    <input type="hidden" name="id_ekskul" value="{{ $ekskul->id_ekskul }}">
                                    <div class="px-4 py-2 text-sm text-gray-700 flex justify-center">
                                        <a @click="open = false"
                                            class="btn btn-secondary font-semibold mx-3">Batal</a>
                                        <button type="submit" class="btn btn-danger font-semibold">Keluar</button>
                                    </div>
                                </form>
                            </x-modal>
                        @endif
                    </div>
                </div>

            </div>
            <!-- Bagian Konten -->
            <div class="flex flex-col lg:flex-row items-center lg:items-start space-y-6 lg:space-y-0 lg:space-x-6">
                <!-- Logo Ekskul (Kiri) -->
                <div class="w-40 h-40 flex-shrink-0 shadow-lg shadow-ekskul bg-white lg:mr-6">
                    <img src="{{ asset('storage/' . $ekskul->gambar) }}" alt="Gambar Ekskul"
                        class="w-full h-full object-cover rounded-lg">
                </div>

                <!-- Deskripsi & Struktur Organisasi -->
                <div class="flex-1 flex flex-col lg:flex-row w-full lg:justify-between">
                    <!-- Bagian Deskripsi -->
                    <div class="lg:w-1/2 w-full">
                        <p class="font-bold text-gray-600">Deskripsi Ekskul :</p>
                        <p class="text-gray-600">
                            {{ $ekskul->deskripsi }}
                        </p>
                    </div>

                    <!-- Bagian Struktur Organisasi -->
                    <div class="lg:w-1/2 w-full">
                        <p class="font-bold text-gray-600">Struktur Organisasi :</p>
                        <div class="grid grid-cols-2 gap-2">
                            <p class="text-gray-600">Pembina {{ $ekskul->nama_ekskul }}:</p>
                            <p class="text-gray-600">{{ $ekskul->pembina->user->nama ?? 'Belum ada' }}</p>
                            <p class="text-gray-600">Ketua {{ $ekskul->nama_ekskul }}:</p>
                            <p class="text-gray-600">{{ $ekskul->ketua->user->nama ?? 'Belum ada' }}</p>
                            <p class="text-gray-600">Sekretaris {{ $ekskul->nama_ekskul }}:</p>
                            <p class="text-gray-600">{{ $ekskul->sekertaris->user->nama ?? 'Belum ada' }}</p>
                            <p class="text-gray-600">Bendahara {{ $ekskul->nama_ekskul }}:</p>
                            <p class="text-gray-600">{{ $ekskul->bendahara->user->nama ?? 'Belum ada' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <!-- Navigation Links in a Single Card (Responsive) -->
        <div class="flex flex-wrap justify-center gap-4 p-6 mb-8 rounded-lg shadow-lg bg-ekskul2">
            <a href="{{ route('materi.index', $ekskul->slug) }}"
                class="items-center w-full text-center px-4 py-2 text-white bg-ekskul font-semibold rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-transform duration-300 sm:w-auto">
                Lihat Materi
            </a>
            <a href="{{ route('kuis.show', $ekskul->slug) }}"
                class="items-center w-full text-center px-4 py-2 text-white bg-ekskul font-semibold rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-transform duration-300 sm:w-auto">
                Lihat Kuis
            </a>
            <a href="{{ route('anggota.show', $ekskul->slug) }}"
                class="items-center w-full text-center px-4 py-2 text-white bg-ekskul font-semibold rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-transform duration-300 sm:w-auto">
                Anggota
            </a>

            @if (auth()->user()->role === 'admin' || in_array(optional(auth()->user()->ekskulUser)->jabatan, [1, 2, 3]))
                <button onclick="cekKegiatan('{{ route('kegiatan.konfirmasi', $ekskul->slug) }}')"
                    class="items-center w-full text-center px-4 py-2 text-white bg-ekskul font-semibold rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-transform duration-300 sm:w-auto">
                    Lihat Absensi
                </button>
            @else
                <a href="{{ route('absensi.index', $ekskul->slug) }}"
                    class="items-center w-full text-center px-4 py-2 text-white bg-ekskul font-semibold rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-transform duration-300 sm:w-auto">
                    Lihat Absensi
                </a>
            @endif

        </div>
        <!-- Smaller Content Cards -->
        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Kartu Ekskul dengan Carousel -->
            <div class="p-3 bg-white rounded-lg shadow-lg lg:col-span-1" style="height: 580px">
                <!-- Carousel Bootstrap -->
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($ekskul->gambarList as $index => $gambar)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $gambar->gambar) }}" class="d-block w-100"
                                    alt="Gambar Ekskul">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>


                <!-- Konten Ekskul -->
                <h3 class="mb-2 text-xl font-bold mt-4">Ekskul {{ $ekskul->nama_ekskul }}</h3>
                <p class="font-bold text-gray-600">Deskripsi Ekskul :</p>
                <p class="mb-4 text-gray-600">
                    {{ $ekskul->deskripsi }}
                </p>
                @if (auth()->user()->role === 'admin' || optional(auth()->user()->ekskulUser)->jabatan == 2)
                    <!-- Tombol untuk membuka modal Tambah Gambar -->
                    <!-- Tombol untuk membuka modal Tambah Gambar -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalTambahGambar">
                        Tambah Gambar
                    </button>

                    <!-- Tombol Hapus Gambar -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#modalHapusGambar">
                        Hapus Gambar
                    </button>
                @endif


                <!-- Modal Tambah Gambar -->
                <div class="modal fade" id="modalTambahGambar" tabindex="-1"
                    aria-labelledby="modalTambahGambarLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahGambarLabel">Tambah Gambar</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('ekskul.tambahGambar', ['id' => $ekskul->id_ekskul]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Pilih Gambar</label>
                                        <input type="file" class="form-control" name="image" required>
                                    </div>
                                    <button type="submit" class="btn btn-success">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Hapus Gambar -->
                <div class="modal fade" id="modalHapusGambar" tabindex="-1" aria-labelledby="modalHapusGambarLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalHapusGambarLabel">Hapus Gambar</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('ekskul.hapusGambar', ['id' => $ekskul->id_ekskul]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="mb-3">
                                        <label for="gambar_id" class="form-label">Pilih Gambar yang akan
                                            dihapus</label>
                                        <select name="gambar_id" class="form-control" required>
                                            @foreach ($ekskul->gambarList as $gambar)
                                                <option value="{{ $gambar->id }}">{{ $gambar->gambar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Materi (Lebar 3 Kolom di Layar Besar) -->
            <div class="grid col-span-2 gap-2">
                @if ($materi->count() > 0)
                    @foreach ($materi as $item)
                        <div
                            class="bg-white rounded-lg shadow-lg w-full hover:shadow-2xl transition duration-300 p-5 h-auto pb-2">
                            <!-- Judul Materi -->
                            <h3 class="text-indigo-900 font-bold text-lg mb-2 truncate">{{ $item->user->nama }}
                            </h3>
                            <p class="text-gray-500 text-sm">{{ $item->created_at->diffForHumans() }}</p>
                            <hr>

                            <!-- Isi Materi -->
                            <h3 class="text-indigo-900 font-bold mt-3 text-lg mb-2">
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
                    <div class="col-span-full md-5 mt-6 flex justify-center">
                        {{ $materi->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                @else
                    <div class="col-span-full text-center">
                        <h1 class="text-gray-600 font-semibold"> Tidak ada materi tersedia untuk ekskul ini.</h1>
                    </div>
                @endif
            </div>

        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function cekKegiatan(url) {
            Swal.fire({
                title: "Apakah ada kegiatan hari ini?",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Ya",
                denyButtonText: "Tidak"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Masukkan Waktu Kegiatan",
                        html: `
                        <input type="time" id="mulai" class="swal2-input" placeholder="Mulai">
                        <input type="time" id="berakhir" class="swal2-input" placeholder="Berakhir">
                    `,
                        focusConfirm: false,
                        preConfirm: () => {
                            const mulai = document.getElementById('mulai').value;
                            const berakhir = document.getElementById('berakhir').value;
                            if (!mulai || !berakhir) {
                                Swal.showValidationMessage('Harap isi semua kolom waktu');
                            }
                            return {
                                mulai,
                                berakhir
                            };
                        }
                    }).then((timeResult) => {
                        if (timeResult.isConfirmed) {
                            window.location.href =
                                `${url}?mulai=${timeResult.value.mulai}&berakhir=${timeResult.value.berakhir}`;
                        }
                    });
                } else {
                    window.location.href = url;
                }
            });
        }
    </script>

</x-layout>
