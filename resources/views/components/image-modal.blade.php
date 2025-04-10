@props([
    'imgSrc' => '',
])

<div x-data="{ open: false }" class="inline">
    <!-- Gambar kecil yang bisa diklik -->
    <img src="{{ $imgSrc }}" @click="open = true" alt="Foto"
        class="w-8 h-8 rounded-full cursor-pointer transition hover:scale-110">

    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        @click.away="open = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90" style="display: none;">
        <div class="bg-gray-200 rounded-lg p-4 relative shadow-xl w-[90%] max-w-md">
            <button @click="open = false"
                class="absolute top-2 right-2 text-gray-600 hover:text-black text-xl font-bold">✖</button>
            <div class="flex justify-center">
                <img src="{{ $imgSrc }}" class="w-60 h-60 rounded" alt="Foto Besar">
            </div>
        </div>
    </div>
</div>
