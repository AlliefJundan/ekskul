<x-layout>
    <div class="p-4 text-white rounded-lg shadow-md bg-maroon-700">
        <h2 class="mb-4 text-xl font-semibold">Halaman Akun</h2>
        <div class="flex items-center justify-between mb-4">
            <input type="text" id="searchInput" placeholder="Cari" onkeyup="filterTable()"
                class="w-auto p-2 text-black border rounded">

            <button onclick="openTambahModal()" class="ml-AU px-3 py-2 text-white font-bold bg-black rounded-lg">+Tambah
                User</button>
        </div>

        <table class="w-full text-white border border-collapse border-gray-300 bg-ekskul">
            <thead>
                <tr class="bg-maroon-800">
                    <th class="p-2 text-gray-800 border-gray-300">No</th>
                    <th class="p-2 text-gray-800 border-gray-300">User ID</th>
                    <th class="p-2 text-gray-800 border-gray-300">Nama</th>
                    <th class="p-2 text-gray-800 border-gray-300">Username</th>
                    <th class="p-2 text-gray-800 border-gray-300">Role</th>
                    <th class="p-2 text-gray-800 border-gray-300 flex justify-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($akun as $index => $user)
                    <tr class="text-center {{ $index % 2 == 0 ? 'bg-maroon-600' : 'bg-maroon-700' }}">
                        <td class="p-2 text-gray-800 border border-gray-300 font-bold">{{ $index + 1 }}</td>
                        <td class="p-2 text-gray-800 border border-gray-300 font-bold">{{ $user->id_user }}</td>
                        <td class="p-2 text-gray-800 border border-gray-300 font-bold">{{ $user->nama }}</td>
                        <td class="p-2 text-gray-800 border border-gray-300 font-bold">{{ $user->username }}</td>
                        <td class="p-2 text-gray-800 border border-gray-300 font-bold">{{ $user->role }}</td>
                        <td class="flex justify-center gap-2 p-2 border border-gray-300">
                            <button
                                onclick="openDetailModal('{{ $user->id_user }}', '{{ $user->username }}', '{{ $user->nama }}', '{{ $user->ekskul }}', '{{ $user->jabatan }}')"
                                class="px-2 py-1 text-white bg-green-500 rounded font-bold">
                                Detail
                            </button>

                            <button
                                onclick="openUbahModal('{{ $user->id_user }}', '{{ $user->username }}', '{{ $user->nama }}', '{{ $user->role }}')"
                                class="px-2 text-white bg-blue-500 rounded font-bold">
                                Ubah
                            </button>

                            <form action="{{ route('akun.destroy', $user->id_user) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-2 py-1 text-white bg-red-500 rounded font-bold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Akun -->
    <div id="modalTambahAkun" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900 bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-blue-800 p-6 rounded-lg shadow-lg w-96 text-white relative">
                <button onclick="closeTambahModal()" class="absolute top-2 right-3 text-white font-bold">✖</button>
                <h2 class="mb-4 text-xl font-semibold text-center">Tambah User</h2>
                <form action="{{ route('akun.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-3 gap-2 items-center mb-3">
                        <label class="font-bold col-span-1 text-right">Nama :</label>
                        <input type="text" name="nama" placeholder="Masukan Nama"
                            class="col-span-2 w-full p-2 rounded text-gray-800">
                    </div>
                    <div class="grid grid-cols-3 gap-2 items-center mb-3">
                        <label class="font-bold col-span-1 text-right">Username :</label>
                        <input type="text" name="username" placeholder="Masukan Username"
                            class="col-span-2 w-full p-2 rounded text-gray-800 " required>
                    </div>
                    <div class="grid grid-cols-3 gap-2 items-center mb-3">
                        <label class="font-bold col-span-1 text-right">Password :</label>
                        <div class="relative col-span-2 w-full">
                            <input type="password" id="passwordInput" name="password" placeholder="Masukan Password"
                                class="w-full p-2 rounded text-gray-800" required>
                            <button type="button" onclick="togglePassword()" class="absolute right-2 top-2">👁</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 items-center mb-3">
                        <label class="font-bold col-span-1 text-right">Role :</label>
                        <select name="role" class="col-span-2 w-full p-2 rounded text-gray-800">
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" onclick="closeTambahModal()"
                            class="px-4 py-2 bg-red-500 text-white rounded">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Akun -->
    <div id="modalDetailAkun" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900 bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-blue-800 p-6 rounded-lg shadow-lg w-96 text-white relative">
                <button onclick="closeDetailModal()" class="absolute top-2 right-3 text-white font-bold">✖</button>
                <h2 class="mb-4 text-xl font-semibold text-center">DETAIL</h2>
                <div class="grid grid-cols-2 gap-2">
                    <span class="font-bold">User ID</span> <span>: <span id="detailId"></span></span>
                    <span class="font-bold">Username</span> <span>: <span id="detailUsername"></span></span>
                    <span class="font-bold">Nama</span> <span>: <span id="detailNama"></span></span>
                    <span class="font-bold">Ekskul</span> <span>: <span id="detailEkskul"></span></span>
                    <span class="font-bold">Jabatan</span> <span>: <span id="detailJabatan"></span></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Akun -->
    <div id="modalUbahAkun" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900 bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-blue-800 p-6 rounded-lg shadow-lg w-96 text-white relative">
                <button onclick="closeUbahModal()" class="absolute top-2 right-3 text-white font-bold">✖</button>
                <h2 class="mb-4 text-xl font-semibold text-center">Ubah User</h2>
                <form id="formUbahAkun" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="ubahUserId" name="id_user">

                    <div class="grid grid-cols-3 gap-2 items-center mb-3">
                        <label class="font-bold col-span-1 text-right">Nama :</label>
                        <input type="text" id="ubahNama" name="nama" placeholder="Masukan Nama"
                            class="col-span-2 w-full p-2 rounded text-gray-800">
                    </div>
                    <div class="grid grid-cols-3 gap-2 items-center mb-3">
                        <label class="font-bold col-span-1 text-right">Username :</label>
                        <input type="text" id="ubahUsername" name="username" placeholder="Masukan Username"
                            class="col-span-2 w-full p-2 rounded text-gray-800">
                    </div>
                    <div class="grid grid-cols-3 gap-2 items-center mb-3">
                        <label class="font-bold col-span-1 text-right">Password :</label>
                        <div class="relative col-span-2 w-full">
                            <input type="password" id="ubahPassword" name="password" placeholder="Masukan Password"
                                class="w-full p-2 rounded text-gray-800">
                            <button type="button" onclick="togglePasswordUbah()"
                                class="absolute right-2 top-2">👁</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 items-center mb-3">
                        <label class="font-bold col-span-1 text-right">Role :</label>
                        <select id="ubahRole" name="role" class="col-span-2 w-full p-2 rounded text-gray-800">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" onclick="closeUbahModal()"
                            class="px-4 py-2 bg-red-500 text-white rounded">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Simpan</button>
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
        function openDetailModal(id, username, nama, ekskul, jabatan) {
            document.getElementById('detailId').innerText = id;
            document.getElementById('detailUsername').innerText = username;
            document.getElementById('detailNama').innerText = nama;

            // Pastikan ekskul adalah array, lalu ubah ke format teks
            let ekskulList = "-"; // Default jika tidak ada ekskul
            if (Array.isArray(ekskul)) {
                ekskulList = ekskul.map(e => e.nama_ekskul).join(", ");
            }
            document.getElementById('detailEkskul').innerText = ekskulList;

            // Tampilkan jabatan atau "-"
            document.getElementById('detailJabatan').innerText = jabatan ? jabatan : "-";

            document.getElementById('modalDetailAkun').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('modalDetailAkun').classList.add('hidden');
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

</x-layout>
