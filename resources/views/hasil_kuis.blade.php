<x-layout>
    <div class="container px-4 mx-auto mt-8">

        <!-- Tombol Kembali -->
        <div class="mb-4  ">
            <x-button1 href="{{ route('kuis.show', $ekskul->slug) }}">
                Kembali
            </x-button1>
        </div>

        <!-- Tabel Hasil Kuis -->
        <div class="bg-indigo-900 rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5">
            @if ($hasil_kuis->count() > 0)
                <table class="w-full bg-white rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-indigo-700 text-white">
                            <th class="py-2 px-4">Nama</th>
                            <th class="py-2 px-4">Skor</th>
                            <th class="py-2 px-4">Bukti</th>
                            <th class="py-2 px-4">Waktu Submit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasil_kuis as $hasil)
                            <tr class="border-b">
                                <td class="py-2 px-4">{{ $hasil->user->nama }}</td>
                                <td class="py-2 px-4">{{ $hasil->skor }}</td>
                                <td class="py-2 px-4">
                                    <a href="{{ asset('storage/' . $hasil->bukti) }}"
                                        class="text-blue-600 hover:underline" target="_blank">
                                        Lihat Bukti
                                    </a>
                                </td>
                                <td class="py-2 px-4">{{ $hasil->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h1 class="text-white font-semibold text-center">Belum ada hasil yang dikirim.</h1>
            @endif
        </div>
    </div>

</x-layout>
