<x-layout>
    <div class="container mx-auto mt-8">    

        <!-- Grid Ekskul -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            <?php $ekskuls = App\Models\Ekskul::all(); ?>
            @foreach ($ekskuls as $ekskul)
                <!-- Card -->
                <div x-data="{ open: false }" 
                    class="cursor-pointer bg-[#742D37] text-white rounded-lg p-6 shadow-md hover:shadow-lg transition">
                    <div @click="open = true"> 
                        <h2 class="text-lg font-bold " style="color: black">Nama Eskul</h2>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Tagline -->
        <div class="text-center mt-5">
            <h2 class="text-2xl font-bold font-serif">AYO DAFTAR ESKUL BIAR</h2>
            <h2 class="text-2xl font-bold font-serif">HIDUP KAMU GA NGEBOSENIN</h2>
        </div>
    </div>
</x-layout>
