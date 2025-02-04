<div class="relative inline-block text-left" x-data="{ open: false }">
    <div>
        <button type="button" @click="open = !open"
            class="inline-flex w-full justify-center gap-x-1.5 rounded-md font-bold bg-ekskul px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white"
            id="menu-button" aria-expanded="true" aria-haspopup="true">
            {{ $slot }}
            <svg class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                data-slot="icon">
                <path fill-rule="evenodd"
                    d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    <?php $collection = App\Models\Ekskul::all(); ?>
    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white ring-1 shadow-lg ring-black/5 focus:outline-hidden"
        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
        <div class="py-1" role="none">
            <!-- Loop through the collection and display each item -->
            @foreach ($collection as $item)
                <a href="#" class="text-gray-700 block px-4 py-2 text-sm">
                    {{ $item->nama_ekskul }} <!-- Assuming nama_ekskul is a column in your Ekskul model -->
                </a>
            @endforeach
        </div>
    </div>
</div>
