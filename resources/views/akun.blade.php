<x-layout>
    <div class="mx-10 my-10">
        <h1 class="mb-8 text-4xl font-bold text-center">Halaman Akun</h1>
    </div>
    <div class="mx-10 my-10">
        <x-button1 href="{{ route('dashboard_admin') }}">
            Kembali
        </x-button1>
    </div>
    <div class="p-4 mx-10 my-10 mt-5 text-white rounded-lg shadow-md bg-ekskul2">

        <div class="flex items-center justify-between mb-4">
            <button onclick="openTambahModal()"
                class="px-3 py-2 font-bold text-white bg-black rounded-lg hover:bg-gray-900 ml-AU">+Tambah
                User</button>

            <form action="{{ route('akun.index') }}" method="GET" class="flex mb-4">
                <input type="text" name="search" placeholder="Cari akun..." value="{{ request('search') }}"
                    class="p-2 text-black border rounded">
                <button type="submit"
                    class="p-2 ml-2 font-bold rounded text-ekskul2 bg-ekskul hover:bg-orange-500">Cari</button>
            </form>

        </div>

        <table class="w-full text-white bg-gray-100 border border-collapse border-gray-300">
            <thead>
                <tr class="bg-gray-300">
                    <th class="p-2 text-center text-gray-800 border-gray-300">No</th>
                    <th class="p-2 text-center text-gray-800 border-gray-300">Nama</th>
                    <th class="p-2 text-center text-gray-800 border-gray-300">Username</th>
                    <th class="p-2 text-center text-gray-800 border-gray-300">Role</th>
                    <th class="p-2 text-center text-gray-800 border-gray-300">Foto</th>
                    <th class="flex justify-center p-2 text-gray-800 border-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($akun as $index => $user)
                    <tr class="text-center items-center {{ $index % 2 == 0 ? 'bg-maroon-600' : 'bg-maroon-700' }}">
                        <td class="p-2 font-bold text-gray-800 border border-gray-300">
                            {{ ($akun->currentPage() - 1) * $akun->perPage() + $index + 1 }}</td>
                        <td class="p-2 font-bold text-gray-800 border border-gray-300">{{ $user->nama }}</td>
                        <td class="p-2 font-bold text-gray-800 border border-gray-300">{{ $user->username }}</td>
                        <td class="p-2 font-bold text-gray-800 border border-gray-300">{{ $user->role }}</td>
                        <td class="p-2 border border-gray-300">
                            <div class="flex items-center justify-center">
                                <x-image-modal :img-src="$user->foto
                                    ? asset('storage/' . $user->foto)
                                    : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png'" />
                            </div>

                        </td>

                        {{-- asdasdasd --}}
                        <td class="flex justify-center gap-2 p-2 border border-gray-300">
                            <button data-modal-target="#detailModal-{{ $user->id_user }}"
                                class="px-2 py-1 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                                Detail
                            </button>
                            <!-- Modal -->
                            <div id="detailModal-{{ $user->id_user }}"
                                class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-ekskul2 rounded-lg p-6 w-1/3 text-left relative">
                                    <!-- Tombol Tutup (Pojok Kanan Atas) -->
                                    <button onclick="closeDetailModal('{{ $user->id_user }}')"
                                        class="absolute font-bold text-white top-2 right-3">✖</button>

                                    <!-- Judul Modal -->
                                    <h2 class="text-xl font-bold mb-4 text-center">Detail Pengguna</h2>

                                    <!-- Isi Modal (Rata Kiri & Sejajar) -->
                                    <div class="space-y-5">
                                        <div class="grid grid-cols-2 gap-x-2">
                                            <span><strong>ID</strong></span>
                                            <span>{{ $user->id_user }}</span>

                                            <span><strong>Nama</strong></span>
                                            <span>{{ $user->nama }}</span>

                                            <span><strong>Username</strong></span>
                                            <span>{{ $user->username }}</span>

                                            <!-- Ekskul -->
                                            <span><strong>Ekskul</strong></span>
                                            <span>
                                                @if ($user->ekskuls->isEmpty())
                                                    Tidak ada ekskul
                                                @else
                                                    {{ $user->ekskuls->pluck('nama_ekskul')->implode(', ') }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- JavaScript untuk Menutup Modal -->
                            <script>
                                function closeDetailModal(id) {
                                    document.getElementById('detailModal-' + id).classList.add('hidden');
                                }
                            </script>


                            <button
                                onclick="openUbahModal('{{ $user->id_user }}', '{{ $user->username }}', '{{ $user->nama }}', '{{ $user->role }}')"
                                class="px-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                Ubah
                            </button>
                            <form action="{{ route('akun.destroy', $user->id_user) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-2 py-1 font-bold text-white bg-red-500 rounded hover:bg-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Custom Pagination -->
        <div class="mx-2 my-3">
            {{ $akun->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    </div>

    <!-- Modal Tambah Akun -->
    <div id="modalTambahAkun" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900 bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="relative p-6 text-white bg-blue-800 rounded-lg shadow-lg w-96">
                <button onclick="closeTambahModal()" class="absolute font-bold text-white top-2 right-3">✖</button>
                <h2 class="mb-4 text-xl font-semibold text-center">Tambah User</h2>
                <form action="{{ route('akun.store') }}" method="POST">
                    @csrf
                    <div class="grid items-center grid-cols-3 gap-2 mb-3">
                        <label class="col-span-1 font-bold text-right">Nama :</label>
                        <input type="text" name="nama" placeholder="Masukan Nama"
                            class="w-full col-span-2 p-2 text-gray-800 rounded">
                    </div>
                    <div class="grid items-center grid-cols-3 gap-2 mb-3">
                        <label class="col-span-1 font-bold text-right">Username :</label>
                        <input type="text" name="username" placeholder="Masukan Username"
                            class="w-full col-span-2 p-2 text-gray-800 rounded " required>
                    </div>
                    <div class="grid items-center grid-cols-3 gap-2 mb-3">
                        <label class="col-span-1 font-bold text-right">Password :</label>
                        <div class="relative w-full col-span-2">
                            <input type="password" id="passwordInput" name="password" placeholder="Masukan Password"
                                class="w-full p-2 text-gray-800 rounded" required>
                            <button type="button" onclick="togglePassword()" class="absolute right-2 top-2">👁</button>
                        </div>
                    </div>
                    <div class="grid items-center grid-cols-3 gap-2 mb-3">
                        <label class="col-span-1 font-bold text-right">Role :</label>
                        <select name="role" class="w-full col-span-2 p-2 text-gray-800 rounded">
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" onclick="closeTambahModal()"
                            class="px-4 py-2 text-white bg-red-500 rounded">Batal</button>
                        <button type="submit" class="px-4 py-2 text-white bg-green-500 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Ubah Akun -->
    <div id="modalUbahAkun" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900 bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="relative p-6 text-white bg-blue-800 rounded-lg shadow-lg w-96">
                <button onclick="closeUbahModal()" class="absolute font-bold text-white top-2 right-3">✖</button>
                <h2 class="mb-4 text-xl font-semibold text-center">Ubah User</h2>
                <form id="formUbahAkun" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="ubahUserId" name="id_user">

                    <div class="grid items-center grid-cols-3 gap-2 mb-3">
                        <label class="col-span-1 font-bold text-right">Nama :</label>
                        <input type="text" id="ubahNama" name="nama" placeholder="Masukan Nama"
                            class="w-full col-span-2 p-2 text-gray-800 rounded">
                    </div>
                    <div class="grid items-center grid-cols-3 gap-2 mb-3">
                        <label class="col-span-1 font-bold text-right">Username :</label>
                        <input type="text" id="ubahUsername" name="username" placeholder="Masukan Username"
                            class="w-full col-span-2 p-2 text-gray-800 rounded">
                    </div>
                    <div class="grid items-center grid-cols-3 gap-2 mb-3">
                        <label class="col-span-1 font-bold text-right">Password :</label>
                        <div class="relative w-full col-span-2">
                            <input type="password" id="ubahPassword" name="password" placeholder="Masukan Password"
                                class="w-full p-2 text-gray-800 rounded">
                            <button type="button" onclick="togglePasswordUbah()"
                                class="absolute right-2 top-2">👁</button>
                        </div>
                    </div>
                    <div class="grid items-center grid-cols-3 gap-2 mb-3">
                        <label class="col-span-1 font-bold text-right">Role :</label>
                        <select id="ubahRole" name="role" class="w-full col-span-2 p-2 text-gray-800 rounded">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" onclick="closeUbahModal()"
                            class="px-4 py-2 text-white bg-red-500 rounded">Batal</button>
                        <button type="submit" class="px-4 py-2 text-white bg-green-500 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openTambahModal() {
            document.getElementById('modalTambahAkun').classList.remove('hidden');
        }

        function closeTambahModal() {
            let confirmClose = confirm("Apakah Anda yakin ingin membatalkan?");
            if (confirmClose) {
                document.getElementById('modalTambahAkun').classList.add('hidden');
            }
        }

        function togglePassword() {
            let passwordInput = document.getElementById('passwordInput');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        }
    </script>

    <script>
        function openUbahModal(id, username, nama, role) {
            document.getElementById('ubahUserId').value = id;
            document.getElementById('ubahUsername').value = username;
            document.getElementById('ubahNama').value = nama;
            document.getElementById('ubahRole').value = role;

            // Ubah action form sesuai ID user
            document.getElementById('formUbahAkun').action = `/akun/${id}`;

            document.getElementById('modalUbahAkun').classList.remove('hidden');
        }

        function closeUbahModal() {
            document.getElementById('modalUbahAkun').classList.add('hidden');
        }

        function togglePasswordUbah() {
            let passwordInput = document.getElementById('ubahPassword');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        }
    </script>

    <script>
        function filterTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.querySelector("table tbody");
            let rows = table.getElementsByTagName("tr");

            for (let i = 0; i < rows.length; i++) {
                let nama = rows[i].getElementsByTagName("td")[2].textContent.toLowerCase();
                let username = rows[i].getElementsByTagName("td")[3].textContent.toLowerCase();
                let role = rows[i].getElementsByTagName("td")[4].textContent.toLowerCase();

                if (nama.includes(input) || username.includes(input) || role.includes(input)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const openButtons = document.querySelectorAll('[data-modal-target]');
            const closeButtons = document.querySelectorAll('[data-modal-close]');

            openButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const modal = document.querySelector(button.getAttribute('data-modal-target'));
                    if (modal) modal.classList.remove('hidden');
                });
            });

            closeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const modal = document.querySelector(button.getAttribute('data-modal-close'));
                    if (modal) modal.classList.add('hidden');
                });
            });
        });
    </script>


</x-layout>
