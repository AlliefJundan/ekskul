<x-layout>
    <div class="container mx-auto mt-8 px-4">
        <div class="flex items-center mb-8">
            <div class="flex items-center mb-8">
                <x-button1 href="{{ route('ekskul.show', $ekskul->slug) }}">Kembali</x-button>
            </div>
        </div>
        <h1 class="text-2xl font-bold text-center md:flex-1">Materi untuk {{ $ekskul->slug }}</h1>

        <!-- Header Materi -->
        <div class="flex justify-between">
            @php
                $user = auth()->user();
                $hasJabatan =
                    $user &&
                    $user
                        ->ekskulUser()
                        ->whereBetween('jabatan', [1, 2])
                        ->exists();
            @endphp
            <!-- Tombol hanya muncul jika user memiliki jabatan 1 atau 2 -->
            @if ($hasJabatan || $user->role === 'admin')
                <x-modal title="Tambah Materi" trigger="Tambah Materi">
                    <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_ekskul" value="{{ $ekskul->id_ekskul }}">
                        <input type="hidden" name="id_user" value="{{ Auth::user()->id_user }}">

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
            @endif

            <!-- Judul Materi -->
            <h6 class="text-white"></h6>
            <!-- Form Pencarian -->
            <form method="GET" action="{{ route('materi.index', $ekskul->slug) }}" class="flex w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="px-4 py-2 border rounded-l-lg bg-gray-200 w-full md:w-auto" placeholder="Cari materi...">
                <button type="submit" class="px-4 py-2 bg-ekskul2 hover:bg-indigo-700 text-white rounded-r-lg">
                    Cari
                </button>
            </form>
        </div>

        <!-- Daftar Materi -->
        <div class="grid gap-6 mt-8 grid-cols-1 md:grid-cols-3">
            <!-- Card Kecil (Total Materi) -->
            <div
                class="bg-ekskul rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5 flex flex-col 
                justify-center items-center text-center self-start">
                <h4 class="text-xl text-ekskul2 font-bold mb-2">Total Materi</h4>
                <p class="text-gray-700 font-bold">
                    <span class="text-xl font-bold text-indigo-900">{{ $materi->count() }}</span> Materi
                </p>
            </div>

            <!-- Card Besar (Daftar Materi) -->
            <div
                class="md:col-span-2 bg-indigo-900 rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5 min-h-[400px] flex flex-col gap-3">
                @if ($materi->count() > 0)
                    @foreach ($materi as $item)
                        <div class="shadow-lg rounded-lg p-4 flex flex-col bg-white">
                            <!-- Isi Materi -->
                            <div class="mb-3">
                                <h3 class="text-indigo-900 font-bold">{{ $item->isi_materi }}</h3>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex flex-col items-end gap-2 mt-2">
                                <!-- Tombol Lihat Lampiran & Download (Paling Atas) -->
                                <div class="flex flex-wrap gap-2">
                                    @if ($item->lampiran_materi)
                                        <a href="{{ asset('storage/' . $item->lampiran_materi) }}" target="_blank"
                                            class="bg-gray-300 text-indigo-900 text-sm px-6 py-2 rounded-md font-bold text-center w-[140px] hover:bg-gray-400 transition">
                                            📄 Buka
                                        </a>
                                        <a href="{{ route('materi.download', $item->id_materi) }}"
                                            class="bg-green-500 text-white text-sm px-6 py-2 rounded-md font-bold text-center w-[140px] hover:bg-green-600 transition">
                                            ⬇ Download
                                        </a>
                                    @endif
                                </div>
                                @php
                                    $user = auth()->user();
                                    $hasJabatan =
                                        $user &&
                                        $user
                                            ->ekskulUser()
                                            ->whereBetween('jabatan', [1, 2])
                                            ->exists();
                                @endphp
                                <!-- Tombol hanya muncul jika user memiliki jabatan 1 atau 2 -->
                                @if ($hasJabatan || $user->role === 'admin')
                                    <!-- Tombol Edit & Hapus (Di Bawah, Tetap Rata Kanan) -->
                                    <div class="flex flex-wrap gap-2">
                                        <a href="javascript:void(0);"
                                            onclick="openModal({{ $item->id_materi }}, '{{ addslashes($item->isi_materi) }}', '{{ $item->lampiran_materi }}')"
                                            class="bg-blue-500 text-white text-sm px-6 py-2 rounded-md font-bold text-center w-[140px] hover:bg-blue-600 transition">
                                            ✏ Edit
                                        </a>

                                        <a href="javascript:void(0);" onclick="confirmDelete({{ $item->id_materi }})"
                                            class="bg-red-500 text-white text-sm px-6 py-2 rounded-md font-bold text-center w-[140px] hover:bg-red-600 transition">
                                            ❌ Hapus
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $materi->appends(['search' => request('search')])->links('pagination::tailwind') }}
                    </div>
                @else
                    <h1 class="text-white font-semibold mb-2 text-center">Tidak ada materi tersedia untuk ekskul ini.
                    </h1>
                @endif
            </div>
        </div>
        <!-- Modal Edit -->
        <div id="editModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-[400px]">
                <h2 class="text-xl font-bold mb-4">Edit Materi</h2>

                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Isi Materi -->
                    <div class="mb-4">
                        <label class="block font-bold">Isi Materi</label>
                        <textarea id="editIsiMateri" name="isi_materi" class="w-full border rounded p-2" rows="4" required></textarea>
                    </div>

                    <!-- Lampiran (Opsional) -->
                    <div class="mb-4">
                        <label class="block font-bold">Lampiran</label>
                        <input type="file" name="lampiran_materi" class="w-full border p-2">

                        <!-- Tampilkan Lampiran Saat Ini -->
                        <p class="text-sm mt-2">Lampiran saat ini:
                            <a id="editLampiranLink" href="#" target="_blank" class="text-blue-600">Lihat
                                Lampiran</a>
                            <span id="editLampiranNama" class="text-gray-700"></span>
                        </p>
                    </div>

                    <!-- Tombol Simpan & Batal -->
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal()"
                            class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                            Batal
                        </button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
</x-layout>

<!-- JavaScript Konfirmasi -->
<script>
    function confirmDelete(id) {
        if (confirm("Apakah Anda yakin ingin menghapus materi ini?")) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>

<script>
    function openModal(id, isiMateri, lampiran) {
        let form = document.getElementById("editForm");

        // Atur action form
        form.action = "{{ route('materi.update', '') }}/" + id;

        // Masukkan isi materi
        document.getElementById("editIsiMateri").value = isiMateri;

        // Tampilkan lampiran (jika ada)
        let lampiranLink = document.getElementById("editLampiranLink");
        let lampiranNama = document.getElementById("editLampiranNama");

        if (lampiran) {
            let fileName = lampiran.split('/').pop(); // Ambil nama file dari path
            lampiranLink.href = "/storage/" + lampiran;
            lampiranLink.textContent = "Lihat Lampiran";
            lampiranNama.textContent = ` (${fileName})`;
            lampiranLink.classList.remove("hidden");
        } else {
            lampiranLink.href = "#";
            lampiranLink.textContent = "Tidak ada lampiran";
            lampiranNama.textContent = "";
            lampiranLink.classList.add("hidden");
        }

        // Tampilkan modal
        document.getElementById("editModal").classList.remove("hidden");
    }


    function closeModal() {
        document.getElementById("editModal").classList.add("hidden");
    }
</script>
