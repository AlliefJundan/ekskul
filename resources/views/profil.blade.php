<x-layout>
    @php
        $jabatanMap = [
            1 => 'Pembina',
            2 => 'Ketua',
            3 => 'Sekretaris',
            4 => 'Bendahara',
            null => 'Anggota',
        ];
    @endphp

    <div class="container px-4 mx-auto mt-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 bg-white shadow-md rounded-xl">
            <!-- Foto dan Ganti Foto -->
            <div class="flex flex-col items-center space-y-3">
                <img src="{{ $user->foto ? asset('storage/' . $user->foto) : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png' }}"
                    alt="Foto Profil" class="rounded-full shadow-md w-40 h-40 object-cover">

                <x-modal trigger="Ganti Foto" title="Ganti Foto Profil"
                    buttonClass="cursor-pointer bg-gray-200 text-sm text-gray-700 px-3 py-1 rounded hover:bg-gray-300 transition">
                    <form action="{{ route('profil.foto') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <label class="block text-gray-700 font-semibold">Pilih Gambar Baru</label>
                        <input type="file" name="foto" class="form-control" accept="image/*" required>

                        <div class="mt-6 flex justify-center">
                            <button type="submit"
                                class="bg-ekskul font-bold text-ekskul2 px-4 py-2 rounded-md hover:bg-blue-600 transition">
                                ✔ Simpan
                            </button>
                        </div>
                    </form>
                </x-modal>
            </div>

            <!-- Info Siswa dan Ekskul -->
            <div class="md:col-span-2 flex flex-col justify-between space-y-4">
                <!-- Info Siswa -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $user->nama }}</h2>
                    <p class="text-sm text-gray-500">
                        {{ $user->username }}
                    </p>
                    <div class="mt-3">
                        <h4 class="font-bold text-gray-800">Kelas</h4>
                        <p class="text-gray-700">{{ optional($user->kelas)->kelas ?? '-' }}
                            {{ optional($user->kelas)->jurusan ?? '-' }}
                            {{ optional($user->kelas)->nomor_kelas ?? '-' }}</p>
                    </div>
                </div>

                <!-- Ekskul -->
                <div>
                    <h4 class="font-bold text-gray-800 mb-2">Ekskul :</h4>
                    @forelse ($ekskul as $item)
                        <p class="text-gray-700 text-sm">
                            • {{ $item->ekskul->nama_ekskul }} –
                            {{ $jabatanMap[$item->jabatan] ?? 'Anggota' }}
                        </p>
                    @empty
                        <p class="text-gray-400 text-sm italic">Belum terdaftar di ekskul manapun.</p>
                    @endforelse
                </div>

                <!-- Tombol Ubah Password -->
                <div>
                    <x-modal trigger="Ubah Password" title="Ubah Password"
                        buttonClass="bg-ekskul2 text-white px-3 py-1 rounded-md font-semibold">
                        <form action="{{ route('profil.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="password" class="block text-gray-700 font-bold mb-2">Password Saat
                                    Ini</label>
                                <input type="password" name="password_sekarang" id="password"
                                    class="border border-gray-300 rounded-lg w-full p-2 focus:outline-none focus:ring focus:ring-blue-500"
                                    minlength="8" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="block text-gray-700 font-bold mb-2">Password Baru</label>
                                <input type="password" name="password" id="password"
                                    class="border border-gray-300 rounded-lg w-full p-2 focus:outline-none focus:ring focus:ring-blue-500"
                                    minlength="8" required>
                            </div>
                            <div class="mb-4">
                                <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Konfirmasi
                                    Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="border border-gray-300 rounded-lg w-full p-2 focus:outline-none focus:ring focus:ring-blue-500"
                                    required>
                            </div>
                            <button type="submit" id="submitBtn"
                                class="bg-ekskul2 text-white px-4 py-2 rounded-md font-bold hover:bg-orange-600 transition">
                                Simpan
                            </button>
                        </form>
                    </x-modal>
                </div>
            </div>
        </div>
    </div>

    <script>
        const passwordBaru = document.querySelector('input[name="password"]');
        const passwordKonfirmasi = document.querySelector('input[name="password_confirmation"]');
        const submitBtn = document.getElementById('submitBtn');

        function validatePasswords() {
            if (passwordBaru.value !== passwordKonfirmasi.value) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        passwordBaru.addEventListener('input', validatePasswords);
        passwordKonfirmasi.addEventListener('input', validatePasswords);
    </script>
</x-layout>
