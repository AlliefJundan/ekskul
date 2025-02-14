<x-layout>
    <div class="container mx-auto mt-8 px-4">
        <!-- Header -->
        <h1 class="text-4xl font-bold text-center mb-8" style="font-bold"> {{ $ekskul->nama_ekskul }}</h1>

        <!-- Navigation Links in a Single Card -->
        <div class="bg-ekskul2 shadow-lg rounded-lg p-6 mb-8 flex justify-center gap-4">
            <a href="{{ route('materi.index', $ekskul->slug) }}"
                class="px-4 py-2 bg-ekskul hover:bg-orange-600 text-black font-semibold rounded-lg shadow-md">
                Lihat Materi
            </a>
            <a href="{{ route('kuis.show', $ekskul->slug) }}"
                class="px-4 py-2 bg-ekskul hover:bg-orange-600 text-black font-semibold rounded-lg shadow-md">
                Lihat Kuis
            </a>
            <a href="{{ url('/absensi') }}"
                class="px-4 py-2 bg-ekskul hover:bg-orange-600 text-black font-semibold rounded-lg shadow-md">
                Lihat Absensi
            </a>
        </div>

        <!-- Smaller Content Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Example Card -->
            <div class="bg-white shadow-lg rounded-lg p-4">
                <h3 class="text-xl font-bold mb-2">KOPASGAS</h3>
                <p class="text-gray-600 mb-4">
                    Selamat Datang Di Eskul Pramuka, disini kalian bisa mengasah kemampuan diri, menemukan jiwa
                    petualang mu, dan menciptakan kenangan bersama-sama dengan teman baru mu
                </p>
                <p class="text-gray-600 font-bold">Follow us:</p>
                <div class="grid grid-cols-2 gap-2">
                    <p class="text-gray-600">Instagram :</p>
                    <p class="text-gray-600">@kopasgas666</p>
                    <p class="text-gray-600">Tiktok :</p>
                    <p class="text-gray-600">@kopasgas666</p>
                </div>
            </div>

            <!-- Add more cards as needed -->
        </div>
    </div>
</x-layout>
