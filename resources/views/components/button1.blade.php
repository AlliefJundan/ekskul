<div>
    <a
        {{ $attributes->merge(['class' => 'bg-ekskul ml-4 text-ekskul2 px-4 py-2 rounded-md font-bold hover:bg-orange-600 transition']) }}>
        {{ $slot }}
    </a>
</div>
