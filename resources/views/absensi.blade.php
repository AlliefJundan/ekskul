<x-layout>

    <div class="container px-4 mx-auto mt-8">
        <div class="flex items-center mb-8">
            <x-button1 href="{{ route('ekskul.show', $ekskul->slug) }}">Kembali</x-button1>
        </div>

        <div class="my-6 text-3xl font-bold text-center">Absen</div>
        <div class="text-lg font-semibold text-center">Tanggal Hari Ini: {{ now()->translatedFormat('l, d F Y') }}</div>

        {{-- Form untuk memilih tanggal (Hanya untuk admin, ketua, atau sekretaris) --}}
        @if (auth()->user()->role === 'admin' || optional(auth()->user()->ekskulUser)->jabatan == 2)
            <div class="flex justify-center mt-6">
                <form action="{{ route('absensi.index', $ekskul->slug) }}" method="GET" class="flex items-center gap-4">
                    <input type="date" name="tanggal" value="{{ request('tanggal', now()->toDateString()) }}"
                        class="p-2 text-lg text-black border border-blue-900 rounded">
                    <button type="submit"
                        class="px-6 py-2 text-lg font-semibold text-white bg-blue-900 rounded-md shadow-md">Filter</button>
                    <a href="{{ route('absensi.index', $ekskul->slug) }}"
                        class="px-6 py-2 text-lg font-semibold text-white bg-red-600 rounded-md shadow-md">Reset</a>
                </form>
            </div>
        @endif

        <div class="flex flex-col md:flex-row gap-5 justify-center mt-5">
            <!-- Card Absensi -->
            <div class="bg-blue-900 rounded-lg shadow-lg p-6 w-full md:w-1/2 max-w-lg">
                <h2 class="text-lg font-bold mb-4 text-white">Absensi</h2>

                <div class="flex flex-col gap-2 text-white">
                    @foreach (['Hadir' => 'text-green-500', 'Sakit' => 'text-blue-500', 'Izin' => 'text-orange-500', 'Alfa' => 'text-red-500'] as $status => $color)
                        <div class="flex justify-between items-center">
                            <span class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full {{ $color }}"></span>
                                <span class="font-medium">{{ $status }}</span>
                            </span>
                            <span class="font-semibold {{ $color }}">
                                {{ $count[$status] ?? 0 }} Hari
                                ({{ number_format($count[$status] ?? 0) }})
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Card Kegiatan dengan Tombol Rekap -->
            @if (auth()->user()->role === 'admin' ||
                    in_array(optional(auth()->user()->ekskulUser->getCurrentEkskul($ekskul->id_ekskul))->jabatan, [1, 2]))
                <div class="bg-blue-900 rounded-lg shadow-lg p-6 w-full md:w-1/2 max-w-lg">
                    <h2 class="text-lg font-bold mb-4 text-white">Informasi Kegiatan</h2>

                    <div class="flex justify-center items-center text-white">
                        <div class="text-center">
                            <span class="text-blue-400 text-4xl font-bold">{{ $jumlahKegiatan }}</span>
                            <p class="text-gray-300 text-sm">Jumlah Kegiatan</p>
                            <!-- Tombol untuk membuka modal -->
                            <button onclick="openModal()"
                                class="mt-4 px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition duration-300 inline-block">
                                Lihat Rekap
                            </button>

                            <!-- Modal Pilih Bulan -->
                            <div id="modal"
                                class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
                                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                                    <h2 class="text-lg font-semibold mb-4">Pilih Bulan</h2>

                                    <!-- Dropdown Pilih Bulan -->
                                    <select id="bulan" class="text-black w-full px-4 py-2 border rounded-lg mb-4">
                                        <option value="" disabled selected>Pilih Bulan</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>

                                    <!-- Tombol Lanjut -->
                                    <button
                                        onclick="redirectToRekap('{{ route('rekap.absensi', ['slug' => $ekskul->slug]) }}')"
                                        class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                                        Lihat Rekap
                                    </button>

                                    <!-- Tombol Tutup -->
                                    <button onclick="closeModal()"
                                        class="w-full bg-gray-300 text-gray-700 px-4 py-2 mt-2 rounded-lg hover:bg-gray-400 transition">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex justify-start px-10 mt-6">
            <form action="{{ route('absensi.store') }}" method="POST" class="flex items-center gap-4">
                @csrf
                <input type="hidden" name="id_user" value="{{ Auth::user()->id_user }}">
                <button type="submit" id="btnTambah"
                    class="px-6 py-2 text-lg font-semibold text-white bg-blue-900 rounded-md shadow-md">
                    Tambah
                </button>
                <select name="kehadiran" class="p-2 text-lg text-black border border-blue-900 rounded">
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="alpa">Alfa</option>
                </select>
                <input type="hidden" name="id_ekskul" value="{{ $ekskul->id_ekskul }}">
            </form>
        </div>

        <div class="p-6 mx-10 mt-6 text-white bg-blue-900 rounded-md shadow-md">
            <!-- Card View for Verification (Mobile) -->
            <div class="block md:hidden">
                @foreach ($absensi as $absen)
                    @if ($absen->status === 'belum terverifikasi')
                        <div class="bg-blue-800 p-4 rounded-lg shadow-md mb-4">
                            <h3 class="text-white font-semibold text-xl">{{ $absen->user->nama ?? 'Tidak Diketahui' }}
                            </h3>
                            <p class="text-gray-300">Tanggal: {{ $absen->tanggal }}</p>
                            <p class="text-white">Kehadiran: {{ ucfirst($absen->kehadiran) }}</p>
                            <p class="text-gray-400">Status: {{ ucfirst($absen->status) }}</p>
                            @if (auth()->user()->role === 'admin' ||
                                    in_array(optional(auth()->user()->ekskulUser->getCurrentEkskul($ekskul->id_ekskul))->jabatan, [1, 2, 3]))
                                <form action="{{ route('absensi.verifikasi', $absen->id_absensi) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="mt-4 px-6 py-2 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-800">
                                        Verifikasi
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Tabel View for Verification (Desktop) -->
            <div class="hidden md:block">
                <table class="w-full text-lg">
                    <thead>
                        <tr class="border-b border-ekskul2">
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Nama User</th>
                            <th class="p-3">Kehadiran</th>
                            <th class="p-3">Status</th>
                            @if (auth()->user()->role === 'admin' ||
                                    in_array(optional(auth()->user()->ekskulUser->getCurrentEkskul($ekskul->id_ekskul))->jabatan, [1, 2]))
                                <th class="p-3">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absensi as $absen)
                            @if ($absen->status === 'belum terverifikasi')
                                <tr class="border-b border-ekskul2">
                                    <td class="p-3">{{ $absen->tanggal }}</td>
                                    <td class="p-3">{{ $absen->user->nama ?? 'Tidak Diketahui' }}</td>
                                    <td class="p-3">{{ ucfirst($absen->kehadiran) }}</td>
                                    <td class="p-3">{{ ucfirst($absen->status) }}</td>
                                    <td class="p-3">
                                        @if (auth()->user()->role === 'admin' ||
                                                in_array(optional(auth()->user()->ekskulUser->getCurrentEkskul($ekskul->id_ekskul))->jabatan, [1, 2, 3]))
                                            <form action="{{ route('absensi.verifikasi', $absen->id_absensi) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="px-4 py-2 text-white bg-green-600 rounded-md shadow-md hover:bg-green-800">
                                                    Verifikasi
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Script untuk Modal -->
        <script>
            function openModal() {
                document.getElementById("modal").classList.remove("hidden");
            }

            function closeModal() {
                document.getElementById("modal").classList.add("hidden");
            }

            function redirectToRekap(baseUrl) {
                let bulan = document.getElementById("bulan").value;
                if (bulan) {
                    window.location.href = baseUrl + "?bulan=" + bulan;
                } else {
                    alert("Pilih bulan terlebih dahulu!");
                }
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let waktuBerakhir =
                    "{{ $kegiatanHariIni->waktu_berakhir ?? '' }}"; // Ambil waktu berakhir dari backend
                let btnTambah = document.getElementById("btnTambah");

                if (waktuBerakhir) {
                    let sekarang = new Date();
                    let waktuBerakhirDate = new Date();
                    let [jam, menit, detik] = waktuBerakhir.split(':');

                    waktuBerakhirDate.setHours(jam, menit, detik);

                    // Jika waktu sekarang sudah lebih dari waktu berakhir, disable tombol
                    if (sekarang > waktuBerakhirDate) {
                        btnTambah.disabled = true;
                        btnTambah.classList.add("bg-gray-500", "cursor-not-allowed");
                        btnTambah.classList.remove("bg-blue-900");
                    }
                }
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('error') }}"
                });
            </script>
        @endif

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}"
                });
            </script>
        @endif

</x-layout>
