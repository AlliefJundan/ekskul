<x-layout>

    @php
        $jabatanMap = [
            1 => 'Pembina',
            2 => 'Ketua',
            3 => 'Sekretaris',
            4 => 'Bendahara',
        ];
    @endphp

    <div class="container mx-auto mt-8 px-2">
        <div class="flex items-center mb-8">
            <x-button1 href="{{ route('dashboard_admin') }}">Kembali</x-button>
        </div>
        <h1 class="mb-8 text-4xl font-bold text-center">Halaman Akun</h1>
        <div class="flex justify-end mx-2">
            <form method="GET" action="{{ route('akun.index') }}" class="w-full md:w-auto flex">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="px-4 py-2 border rounded-l-lg bg-gray-200 w-full md:w-auto" placeholder="Cari kuis...">
                <button type="submit"
                    class="px-4 py-2 bg-ekskul2 hover:bg-indigo-700 text-white font-semibold rounded-r-lg">Cari</button>
            </form>
        </div>
        <div class="bg-indigo-900 mt-8 mx-2 rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-2">
                <x-modal title="Tambah User" trigger="+Tambah User"
                    buttonClass="bg-black text-white font-bold px-4 py-2 rounded-md hover:bg-gray-700 w-full">
                    <form action="{{ route('akun.store') }}" method="POST">
                        @csrf
                        <div class="grid items-center grid-cols-3 gap-2 mb-3">
                            <label class="col-span-1 font-bold text-right">Nama :</label>
                            <input type="text" name="nama" placeholder="Masukan Nama"
                                class="w-full col-span-2 p-2 text-gray-800 rounded" maxlength="100" max="100">
                        </div>
                        <div class="grid items-center grid-cols-3 gap-2 mb-3">
                            <label class="col-span-1 font-bold text-right">Username :</label>
                            <input type="text" name="username" placeholder="Masukan Username"
                                class="w-full col-span-2 p-2 text-gray-800 rounded" required>
                        </div>
                        <div class="grid items-center grid-cols-3 gap-2 mb-3">
                            <label class="col-span-1 font-bold text-right">Password :</label>
                            <div class="relative w-full col-span-2">
                                <input type="password" id="passwordInput" name="password" placeholder="Masukan Password"
                                    class="w-full p-2 text-gray-800 rounded" required>
                                <button type="button" onclick="togglePassword()" class="absolute right-2 top-2">
                                    <i id="eyeIcon" class="fas fa-eye-slash"></i>
                                </button>
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
                </x-modal>
            </div>

            @if ($akun->count() > 0)
                <!-- Tabel untuk mode desktop -->
                <div class="hidden md:block">
                    <table class="w-full text-white bg-gray-100 border border-collapse rounded-lg border-gray-300">
                        <thead>
                            <tr class="bg-gray-300 ">
                                <th class="p-2 text-center text-gray-800 border-gray-300">No</th>
                                <th class="p-2 text-center text-gray-800 border-gray-300">Nama</th>
                                <th class="p-2 text-center text-gray-800 border-gray-300">Username</th>
                                <th class="p-2 text-center text-gray-800 border-gray-300">Kelas</th>
                                <th class="p-2 text-center text-gray-800 border-gray-300">Role</th>
                                <th class="p-2 text-center text-gray-800 border-gray-300">Foto</th>
                                <th class="flex justify-center p-2 text-gray-800 border-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($akun as $index => $user)
                                <tr
                                    class="text-center items-center {{ $index % 2 == 0 ? 'bg-maroon-600' : 'bg-maroon-700' }}">
                                    <td class="p-2 font-bold text-gray-800 border border-gray-300">
                                        {{ ($akun->currentPage() - 1) * $akun->perPage() + $index + 1 }}</td>
                                    <td class="p-2 font-bold text-left text-gray-800 border border-gray-300">
                                        {{ Str::limit($user->nama, '50', '...') }}</td>
                                    <td class="p-2 font-bold text-gray-800 border border-gray-300">
                                        {{ $user->username }}
                                    </td>
                                    <td class="p-2 font-bold text-gray-800 border border-gray-300">
                                        {{ optional($user->kelas)->kelas ?? '-' }}
                                        {{ optional($user->kelas)->jurusan ?? '-' }}
                                        {{ optional($user->kelas)->nomor_kelas ?? '-' }}
                                    </td>
                                    <td class="p-2 font-bold text-gray-800 border border-gray-300">
                                        {{ $user->role }}
                                    </td>
                                    <td class="p-2 border border-gray-300">
                                        <div class="flex items-center justify-center">
                                            <x-image-modal :img-src="$user->foto
                                                ? asset('storage/' . $user->foto)
                                                : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png'" />
                                        </div>
                                    </td>
                                    <td class="flex justify-center gap-2 p-2 border border-gray-300">
                                        <x-modal title="Detail Pengguna" trigger="Detail"
                                            buttonClass="px-2 py-1 font-bold text-white bg-green-500 rounded hover:bg-green-700">

                                            <div class="space-y-6 text-lg text-gray-800">
                                                {{-- Nama --}}
                                                <div class="flex items-start">
                                                    <div class="w-1/3 font-semibold text-left">Nama:</div>
                                                    <div class="w-2/3 text-left break-words">{{ $user->nama }}
                                                    </div>
                                                </div>

                                                {{-- Username --}}
                                                <div class="flex items-start">
                                                    <div class="w-1/3 font-semibold text-left">Username:</div>
                                                    <div class="w-2/3 text-left break-words">{{ $user->username }}
                                                    </div>
                                                </div>

                                                <div class="flex items-start">
                                                    <div class="w-1/3 font-semibold text-left">Kelas:</div>
                                                    <div class="w-2/3 text-left break-words">
                                                        {{ optional($user->kelas)->kelas ?? '-' }}
                                                        {{ optional($user->kelas)->jurusan ?? '-' }}
                                                        {{ optional($user->kelas)->nomor_kelas ?? '-' }}
                                                    </div>
                                                </div>

                                                {{-- Role --}}
                                                <div class="flex items-start">
                                                    <div class="w-1/3 font-semibold text-left">Role:</div>
                                                    <div class="w-2/3 text-left break-words">{{ $user->role }}
                                                    </div>
                                                </div>

                                                {{-- Ekskul --}}
                                                <div class="flex items-start">
                                                    <div class="w-1/3 font-semibold text-left">Ekskul:</div>
                                                    <div class="w-2/3 text-left break-words">
                                                        @if ($user->ekskuls->isEmpty())
                                                            <div class="text-gray-500 italic">Tidak ada ekskul</div>
                                                        @else
                                                            <ul class="list-disc list-inside space-y-2">
                                                                @foreach ($user->ekskuls as $ekskul)
                                                                    <li class="flex flex-col">
                                                                        <span class="font-semibold">•
                                                                            {{ $ekskul->nama_ekskul }} --

                                                                            ({{ $jabatanMap[$ekskul->pivot->jabatan] ?? 'Tidak ada jabatan' }})
                                                                        </span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </x-modal>

                                        <x-modal title="Ubah Data Pengguna" trigger="Ubah"
                                            buttonClass="px-2 py-1 font-bold text-white bg-blue-500 rounded hover:bg-blue-600">

                                            <form action="{{ route('akun.edit', $user->id_user) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="grid items-center grid-cols-3 gap-2 mb-3">
                                                    <label class="col-span-1 font-bold text-right">Nama :</label>
                                                    <input type="text" name="nama" placeholder="Masukan Nama"
                                                        class="w-full col-span-2 p-2 text-gray-800 rounded"
                                                        maxlength="100" max="100">
                                                </div>
                                                <div class="grid items-center grid-cols-3 gap-2 mb-3">
                                                    <label class="col-span-1 font-bold text-right">Username :</label>
                                                    <input type="text" name="username"
                                                        placeholder="Masukan Username"
                                                        class="w-full col-span-2 p-2 text-gray-800 rounded" required>
                                                </div>
                                                <div class="grid items-center grid-cols-3 gap-2 mb-3">
                                                    <label class="col-span-1 font-bold text-right">Password :</label>
                                                    <div class="relative w-full col-span-2">
                                                        <input type="password" id="passwordInput" name="password"
                                                            placeholder="Masukan Password"
                                                            class="w-full p-2 text-gray-800 rounded" required>
                                                    </div>
                                                </div>
                                                <div class="grid items-center grid-cols-3 gap-2 mb-3">
                                                    <label class="col-span-1 font-bold text-right">Role :</label>
                                                    <select name="role"
                                                        class="w-full col-span-2 p-2 text-gray-800 rounded" required>
                                                        <option value="" disabled>Pilih Role</option>
                                                        <option value="user"
                                                            {{ $user->role === 'user' ? 'selected' : '' }}>User
                                                        </option>
                                                        <option value="admin"
                                                            {{ $user->role === 'admin' ? 'selected' : '' }}>Admin
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="flex justify-end gap-2 mt-4">
                                                    <button type="button" @click="open = false"
                                                        class="px-4 py-2 text-white bg-red-500 font-semibold rounded">Batal</button>
                                                    <button type="submit"
                                                        class="px-4 py-2 text-white bg-green-500 font-semibold rounded">Simpan</button>
                                                </div>
                                            </form>
                                        </x-modal>


                                        <x-modal trigger="Hapus" title="Konfirmasi Hapus"
                                            buttonClass="px-2 py-1 font-bold text-white bg-red-500 rounded hover:bg-red-600">

                                            <div class="text-center text-gray-800 text-lg">
                                                <p>Apakah kamu yakin ingin menghapus data ini?</p>
                                            </div>

                                            <div class="flex justify-center gap-4 mt-6">
                                                <!-- Tombol Batal -->
                                                <button type="button" @click="open = false"
                                                    class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded">
                                                    Batal
                                                </button>

                                                <!-- Form Hapus -->
                                                <form action="{{ route('akun.destroy', $user->id_user) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>

                                        </x-modal>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Tampilan Card untuk mode mobile -->
                <div class="md:hidden grid grid-cols-1 gap-6">
                    <div class=" py-2 rounded-md">
                        @foreach ($akun as $user)
                            <div class="rounded-lg bg-gray-300 mt-1 p-4 text-black">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-bold">{{ Str::limit($user->nama, 23) }}</h2>
                                    <div
                                        class="{{ $user->role === 'admin' ? 'bg-green-600 text-white' : 'bg-white' }} rounded-md px-2">
                                        <span class="font-semibold ">{{ $user->role }}</span>
                                    </div>
                                </div>
                                <p class="text-sm  font-semibold">{{ $user->username }} --
                                    {{ optional($user->kelas)->kelas ?? '-' }}
                                    {{ optional($user->kelas)->jurusan ?? '-' }}
                                    {{ optional($user->kelas)->nomor_kelas ?? '-' }}</p>
                                <div class="mt-3 flex items-center justify-between">
                                    <x-image-modal :img-src="$user->foto
                                        ? asset('storage/' . $user->foto)
                                        : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png'" />
                                    <div class="flex gap-2">
                                        <x-modal title="Detail Pengguna" trigger="Detail"
                                            buttonClass="px-2 py-1 font-bold text-white bg-green-500 rounded hover:bg-green-700">

                                            <div class="space-y-6 text-lg text-gray-800">
                                                {{-- Nama --}}
                                                <div class="flex items-start">
                                                    <div class="w-1/3 font-semibold text-left">Nama:</div>
                                                    <div class="w-2/3 text-left break-words">{{ $user->nama }}
                                                    </div>
                                                </div>

                                                {{-- Username --}}
                                                <div class="flex items-start">
                                                    <div class="w-1/3 font-semibold text-left">Username:</div>
                                                    <div class="w-2/3 text-left break-words">{{ $user->username }}
                                                    </div>
                                                </div>

                                                <div class="flex items-start">
                                                    <div class="w-1/3 font-semibold text-left">Kelas:</div>
                                                    <div class="w-2/3 text-left break-words">
                                                        {{ optional($user->kelas)->kelas ?? '-' }}
                                                        {{ optional($user->kelas)->jurusan ?? '-' }}
                                                        {{ optional($user->kelas)->nomor_kelas ?? '-' }}
                                                    </div>
                                                </div>

                                                {{-- Role --}}
                                                <div class="flex items-start">
                                                    <div class="w-1/3 font-semibold text-left">Role:</div>
                                                    <div class="w-2/3 text-left break-words">{{ $user->role }}
                                                    </div>
                                                </div>

                                                {{-- Ekskul --}}
                                                <div class="flex items-start">
                                                    <div class="w-1/3 font-semibold text-left">Ekskul:</div>
                                                    <div class="w-2/3 text-left break-words">
                                                        @if ($user->ekskuls->isEmpty())
                                                            <div class="text-gray-500 italic">Tidak ada ekskul</div>
                                                        @else
                                                            <ul class="list-disc list-inside space-y-2">
                                                                @foreach ($user->ekskuls as $ekskul)
                                                                    <li class="flex flex-col">
                                                                        <span class="font-semibold">•
                                                                            {{ $ekskul->nama_ekskul }} --
                                                                            ({{ $jabatanMap[$ekskul->pivot->jabatan] ?? 'Tidak ada jabatan' }})
                                                                        </span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </x-modal>
                                        <x-modal title="Ubah Data Pengguna" trigger="Ubah"
                                            buttonClass="px-2 py-1 font-bold text-white bg-blue-500 rounded hover:bg-blue-600">

                                            <form action="{{ route('akun.update', $user->id_user) }}" method="POST"
                                                class="space-y-6 text-gray-800">
                                                @csrf
                                                @method('PUT')

                                                {{-- Nama --}}
                                                <div class="grid items-center grid-cols-3 gap-2 mb-3">
                                                    <label class="col-span-1 font-bold text-right">Nama :</label>
                                                    <input type="text" name="nama" placeholder="Masukan Nama"
                                                        class="w-full col-span-2 p-2 text-gray-800 rounded"
                                                        maxlength="100" max="100" value="{{ $user->nama }}"
                                                        required>
                                                </div>
                                                <div class="grid items-center grid-cols-3 gap-2 mb-3">
                                                    <label class="col-span-1 font-bold text-right">Username
                                                        :</label>
                                                    <input type="text" name="username"
                                                        placeholder="Masukan Username"
                                                        class="w-full col-span-2 p-2 text-gray-800 rounded"
                                                        value="{{ $user->username }}" required>
                                                </div>
                                                <div class="grid items-center grid-cols-3 gap-2 mb-3">
                                                    <label class="col-span-1 font-bold text-right">Password
                                                        :</label>
                                                    <div class="relative w-full col-span-2">
                                                        <input type="password" id="passwordInput" name="password"
                                                            placeholder="Masukan Password"
                                                            class="w-full p-2 text-gray-800 rounded" minlength="8">
                                                    </div>
                                                </div>
                                                <div class="grid items-center grid-cols-3 gap-2 mb-3">
                                                    <label class="col-span-1 font-bold text-right">Role :</label>
                                                    <select name="role"
                                                        class="w-full col-span-2 p-2 text-gray-800 rounded" required>
                                                        <option value="" disabled>Pilih Role</option>
                                                        <option value="user"
                                                            {{ $user->role === 'user' ? 'selected' : '' }}>User
                                                        </option>
                                                        <option value="admin"
                                                            {{ $user->role === 'admin' ? 'selected' : '' }}>Admin
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="flex justify-end gap-2 mt-4">
                                                    <button type="button" @click="open = false"
                                                        class="px-4 py-2 text-white bg-red-500 font-semibold rounded">Batal</button>
                                                    <button type="submit"
                                                        class="px-4 py-2 text-white bg-green-500 font-semibold rounded">Simpan</button>
                                                </div>
                                            </form>
                                        </x-modal>

                                        <x-modal trigger="Hapus" title="Konfirmasi Hapus"
                                            buttonClass="px-2 py-1 font-bold text-white bg-red-500 rounded hover:bg-red-600">

                                            <div class="text-center text-gray-800 text-lg">
                                                <p>Apakah kamu yakin ingin menghapus data ini?</p>
                                            </div>

                                            <div class="flex justify-center gap-4 mt-6">
                                                <!-- Tombol Batal -->
                                                <button type="button" @click="open = false"
                                                    class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded">
                                                    Batal
                                                </button>

                                                <!-- Form Hapus -->
                                                <form action="{{ route('akun.destroy', $user->id_user) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>

                                        </x-modal>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex items-center justify-center w-full h-96">
                        <h1 class="text-2xl font-bold text-center text-white">Tidak ada data akun</h1>
                    </div>
            @endif
        </div>
    </div>
</x-layout>
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');

        // Cek tipe input saat ini
        if (passwordInput.type === 'password') {
            // Ganti tipe input ke 'text' agar password terlihat
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye-slash'); // Hapus ikon mata tertutup
            eyeIcon.classList.add('fa-eye'); // Tambahkan ikon mata terbuka
        } else {
            // Kembalikan tipe input ke 'password'
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye'); // Hapus ikon mata terbuka
            eyeIcon.classList.add('fa-eye-slash'); // Tambahkan ikon mata tertutup
        }
    }
</script>
