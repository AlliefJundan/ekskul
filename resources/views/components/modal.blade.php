@props([
    'title',
    'trigger',
    'buttonClass' => 'bg-ekskul2 text-white px-4 py-2 rounded-md font-bold hover:bg-indigo-700 transition',
])

<div x-data="{ open: false }">
    <!-- Tombol untuk membuka modal -->
    <button @click="open = true" class="{{ $buttonClass }}">
        {{ $trigger }}
    </button>

    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        @click.away="open = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90" style="display: none;">

        <div class="bg-indigo-900 rounded-lg p-4 w-96 shadow-lg relative w-[500px] ">
            <button @click="open = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">
                ✖
            </button>
            <h2 class="text-xl text-white font-bold mb-4 flex justify-center">{{ $title }}</h2>
            {{ $slot }}
        </div>
    </div>
</div>
