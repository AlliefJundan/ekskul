<!-- resources/views/ekskul/index.blade.php -->

<x-layout>
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Daftar Ekskul</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $ekskuls = App\Models\Ekskul::all(); ?>
            @foreach ($ekskuls as $ekskul)
                <div class="w-full max-w-sm mx-auto bg-white shadow-lg rounded-lg overflow-hidden flex flex-col">
                    <img src="https://via.placeholder.com/400x200" alt="Card Image" class="w-full h-48 object-cover">
                    <div class="p-6 flex-1">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $ekskul->nama_ekskul }}</h2>
                        <p class="text-gray-600 mt-2">Nama Pembina : {{ $ekskul->pembina->nama_jabatan }}</p>
                        <p class="text-gray-600 mt-2">Nama Ketua : {{ $ekskul->ketua->nama_jabatan }}</p>
                        <p class="text-gray-600 mt-2">Jumlah Anggota : {{ $ekskul->jml_anggota }}</p>
                        <div class="mt-4">
                            <a href="#"
                                class="inline-block bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">Read
                                More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>
