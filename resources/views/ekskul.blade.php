<x-layout>
    <div class="container mx-auto mt-8 px-4">
        <!-- Header -->
        <h1 class="text-4xl font-bold text-center mb-8" style="font-bold"> {{ $ekskul->nama_ekskul }}</h1>

        <!-- "Materi Hari Ini" Card -->
        <div class="bg-ekskul2 text-white flex justify-end rounded-lg shadow-lg p-6 mb-8">
            <a href="{{ route('materi.index', $ekskul->slug) }}"
                class="inline-block px-4 py-2 bg-ekskul hover:bg-orange-600 text-black font-semibold rounded-lg shadow-md">
                Lihat Materi
            </a>

        </div>
        
        <div class="bg-ekskul text-white flex justify-end rounded-lg shadow-lg p-6 mb-8">
            <a href="{{ route('kuis.show', $ekskul->slug) }}"
                class="inline-block px-4 py-2 bg-ekskul2 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-md">
                Lihat Kuis
            </a>

        </div>
        

        <!-- Smaller Content Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Example Card -->
            <div class="bg-white shadow-lg rounded-lg p-4">
                <h3 class="text-xl font-bold mb-2">Kepribadian Unggul</h3>
                <p class="text-gray-600 mb-4">
                    Body text for whatever you'd like to say. Add main takeaway points, quotes, anecdotes, or even a
                    very
                    very short story.
                </p>
                <!-- Gray Box for Attachment -->
                <div class="w-full h-24 bg-gray-200 rounded flex flex-col justify-center items-center">
                    <p class="text-sm text-gray-600 mb-2">Attachment</p>
                    <button
                        class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition">Download</button>
                </div>
            </div>

            <!-- Add more cards as needed -->
        </div>
    </div>
</x-layout>
