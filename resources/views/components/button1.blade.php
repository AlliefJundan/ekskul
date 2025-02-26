<div>
    <a
        {{ $attributes->merge(['class' => 'relative inline-flex items-center sm:w-auto px-4 py-2 text-white bg-ekskul font-semibold  rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-transform duration-300']) }}>
        {{ $slot }}
    </a>
</div>
