<x-layout>
    <div class="container p-6 mx-auto">
        <div class="p-4 text-white rounded-lg shadow-md bg-maroon-700">
            <h2 class="mb-4 text-xl font-semibold">Halaman Akun</h2>
            <div class="flex justify-between mb-4">
                <input type="text" placeholder="Cari" class="w-full p-2 text-black border border-gray-300 rounded">
                <button @click="openModal = true" class="px-4 py-2 ml-4 text-white bg-blue-500 rounded-lg">
                    + Tambah Akun
                </button>
            </div>

            <table class="w-full text-white border border-collapse border-gray-300">
                <thead>
                    <tr class="bg-maroon-800">
                        <th class="p-2 text-black border-gray-300">No</th>
                        <th class="p-2 text-black border-gray-300">User ID</th>
                        <th class="p-2 text-black border-gray-300">Nama</th>
                        <th class="p-2 text-black border-gray-300">Username</th>
                        <th class="p-2 text-black border-gray-300">Role</th>
                        <th class="p-2 text-black border-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($akun as $index => $user)
                        <tr class="text-center {{ $index % 2 == 0 ? 'bg-maroon-600' : 'bg-maroon-700' }}">
                            <td class="p-2 text-black border border-gray-300">{{ $index + 1 }}</td>
                            <td class="p-2 text-black border border-gray-300">{{ $user->id_user }}</td>
                            <td class="p-2 text-black border border-gray-300">{{ $user->nama }}</td>
                            <td class="p-2 text-black border border-gray-300">{{ $user->username }}</td>
                            <td class="p-2 text-black border border-gray-300">{{ $user->role }}</td>
                            <td class="flex justify-center gap-2 p-2 border border-gray-300">
                                <a href="{{ route('akun.show', $user->id_user) }}"
                                    class="px-2 py-1 text-white bg-green-500 rounded">Detail</a>
                                <a href="{{ route('akun.edit', $user->id_user) }}"
                                    class="px-2 py-1 text-white bg-blue-500 rounded">Ubah</a>
                                <form action="{{ route('akun.destroy', $user->id_user) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-2 py-1 text-white bg-red-500 rounded">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- ✅ MODAL TAMBAH AKUN -->
        <div x-data="{ openModal: false }">
            <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="p-6 bg-white rounded-lg shadow-lg w-96">
                    <h2 class="mb-4 text-lg font-semibold">Tambah Akun</h2>
                    <form action="{{ route('akun.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block">Username</label>
                            <input type="text" name="username"
                                class="w-full p-2 text-black border border-gray-300 rounded" required>
                        </div>
                        <div class="mb-4">
                            <label class="block">Password</label>
                            <input type="password" name="password"
                                class="w-full p-2 text-black border border-gray-300 rounded" required>
                        </div>
                        <div class="mb-4">
                            <label class="block">Nama</label>
                            <input type="text" name="nama"
                                class="w-full p-2 text-black border border-gray-300 rounded" required>
                        </div>
                        <div class="mb-4">
                            <label class="block">Role</label>
                            <select name="role" class="w-full p-2 text-black border border-gray-300 rounded"
                                required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" @click="openModal = false"
                                class="px-4 py-2 mr-2 text-white bg-gray-500 rounded-lg">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-lg">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
