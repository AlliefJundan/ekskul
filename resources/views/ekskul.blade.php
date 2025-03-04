<x-layout>
    <div class="container px-4 mx-auto mt-8">
        <div class="flex items-center mb-8">
            <x-button1 href="{{ route('dashboard_admin') }}">Kembali</x-button1>
        </div>

        <!-- Header -->
        <h1 class="mb-8 text-4xl font-bold text-center">{{ $ekskul->nama_ekskul }}</h1>

        <div class="p-6 bg-white rounded-lg shadow-lg">
            <!-- Nama Ekskul (Tengah) -->
            <h3
                class="text-2xl font-bold text-center mb-4 flex justify-center bg-ekskul text-black px-4 py-2 rounded-lg inline-block">
                Ekskul {{ $ekskul->nama_ekskul }}
            </h3>
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


            <a href="{{ route('absensi.index', $ekskul->slug) }}"
                class="items-center w-full text-center px-4 py-2 text-white bg-ekskul font-semibold rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-transform duration-300 sm:w-auto">
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
                        <div class="bg-white rounded-lg shadow-lg w-full hover:shadow-2xl transition duration-300 p-5">
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
                    <div class="col-span-full md-5 mt-6 flex justify-center">
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
