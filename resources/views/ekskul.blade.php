<x-layout>
    <div class="container px-4 mx-auto mt-8">
        <!-- Header -->
        <h1 class="mb-8 text-4xl font-bold text-center" style="font-bold"> {{ $ekskul->nama_ekskul }}</h1>

        <!-- Navigation Links in a Single Card -->
        <div class="flex justify-center gap-4 p-6 mb-8 rounded-lg shadow-lg bg-ekskul2">
            <a href="{{ route('materi.index', $ekskul->slug) }}"
                class="px-4 py-2 font-semibold text-black rounded-lg shadow-md bg-ekskul hover:bg-orange-600">
                Lihat Materi
            </a>
            <a href="{{ route('kuis.show', $ekskul->slug) }}"
                class="px-4 py-2 font-semibold text-black rounded-lg shadow-md bg-ekskul hover:bg-orange-600">
                Lihat Kuis
            </a>
            <a href="{{ route('anggota.show', $ekskul->slug) }}"
                class="px-4 py-2 font-semibold text-black rounded-lg shadow-md bg-ekskul hover:bg-orange-600">
                Anggota
            </a>
            <a href="{{ url('/absensi') }}"
                class="px-4 py-2 font-semibold text-black rounded-lg shadow-md bg-ekskul hover:bg-orange-600">
                Lihat Absensi
            </a>
        </div>

        <!-- Smaller Content Cards -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Example Card -->
            <div class="p-4 bg-white rounded-lg shadow-lg">
                <h3 class="mb-2 text-xl font-bold">KOPASGAS</h3>
                <p class="mb-4 text-gray-600">
                    Selamat Datang Di Eskul Pramuka, disini kalian bisa mengasah kemampuan diri, menemukan jiwa
                    petualang mu, dan menciptakan kenangan bersama-sama dengan teman baru mu
                </p>
                <p class="font-bold text-gray-600">Follow us:</p>
                <div class="grid grid-cols-2 gap-2">
                    <p class="text-gray-600">Instagram :</p>
                    <p class="text-gray-600">@kopasgas666</p>
                    <p class="text-gray-600">Tiktok :</p>
                    <p class="text-gray-600">@kopasgas666</p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
