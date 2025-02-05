<x-layout>
    <div class="container mx-auto mt-8">

        <!-- Layout Utama -->
        <div class="flex mt-8">
            <!-- Sidebar Kiri -->
            <div class="relative w-1/3">
                <!-- Shadow Oranye di Belakang -->
                <div class="absolute -bottom-2 -right-2 w-full h-full bg-orange-400 rounded-lg"></div>

                <!-- Kartu Utama -->
                <div class="relative bg-[#2B1646] text-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold">Hallo !!</h2>
                    <p class="mt-2">Ini Teman teman kamu!</p>
                    <div class="mt-4 space-y-2">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="bg-white text-black p-2 rounded-md">
                                Nama User, Kelas dan Jabatan
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Konten Tengah -->
            <div class="flex-1 flex justify-center items-center">
                <div class="text-center text-2xl font-bold">
                    <h2 class="font-serif underline decoration-blue-500">
                        Selamat Datang di Ekskul Pramuka
                    </h2>
                </div>
            </div>
        </div>
    </div>
</x-layout>
