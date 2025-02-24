<div>
    <a
        {{ $attributes->merge(['class' => 'relative inline-flex items-center px-4 py-2 text-black bg-ekskul2 font-semibold text-lg rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-transform duration-300']) }}>
        {{ $slot }}
    </a>
</div>
