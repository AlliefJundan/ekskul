<x-layout>
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Daftar Ekskul</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($ekskuls as $ekskul)
                <!-- Card -->
                <div x-data="{ open: false }"
                    class="cursor-pointer w-full max-w-sm mx-auto bg-white shadow-lg rounded-lg overflow-hidden flex flex-col">
                    <div @click="open = true">
                        <img src="https://via.placeholder.com/400x200" alt="Card Image" class="w-full h-48 object-cover">
                        <div class="p-6 flex-1">
                            <h2 class="text-xl font-semibold text-gray-800">{{ $ekskul->nama_ekskul }}</h2>
                            <p class="text-gray-600 mt-2">Klik untuk melihat detail</p>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div x-show="open" @click.away="open = false"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        style="display: none;">
                        <div class="bg-white rounded-lg p-6 w-96">
                            <h2 class="text-xl font-bold mb-4">Detail Ekskul</h2>
                            <p><strong>Nama Ekskul:</strong> {{ $ekskul->nama_ekskul }}</p>

                            <!-- Tampilkan Nama Orang -->
                            <p><strong>Nama Pembina:</strong> {{ optional($ekskul->pembina)->nama ?? 'Belum ada' }}</p>
                            <p><strong>Nama Ketua:</strong> {{ optional($ekskul->ketua)->nama ?? 'Belum ada' }}</p>
                            <p><strong>Jumlah Anggota:</strong> {{ $ekskul->jml_anggota }}</p>

                            <div class="mt-6 flex justify-end">
                                <button @click="open = false"
                                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition flex items-center">
                                    ✖ Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>
