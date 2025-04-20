<x-layout>
    <div class="container px-4 mx-auto mt-8">
        <!-- Tombol Kembali -->
        <div class="mb-4">
            <x-button1 href="{{ route('kuis.hasilKuis', $ekskul->slug) }}">
                Kembali
            </x-button1>
        </div>

        <div class="bg-indigo-900 rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5">
            @if ($hasil_kuis->count() > 0)
                <!-- TABEL untuk laptop -->
                <div class="hidden md:block">
                    <table class="w-full bg-white rounded-lg font-semibold shadow-md">
                        <thead>
                            <tr class="bg-gray-100 text-gray-800 text-sm md:text-base rounded">
                                <th class="py-2 px-4 text-left">Nama</th>
                                <th class="py-2 px-4 text-left">Skor</th>
                                <th class="py-2 px-4 text-left">Bukti</th>
                                <th class="py-2 px-4 text-left">Waktu Submit</th>
                                <th class="py-2 px-4 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasil_kuis as $hasil)
                                <tr class="border-b hover:bg-indigo-100 transition text-sm md:text-base">
                                    <td class="py-2 px-4">{{ $hasil->user->nama }}</td>
                                    <td class="py-2 px-4">{{ $hasil->skor }}</td>
                                    <td class="py-2 px-4">
                                        <a href="{{ asset('storage/' . $hasil->bukti) }}"
                                            class="text-blue-600 hover:underline" target="_blank">
                                            Lihat Bukti
                                        </a>
                                    </td>
                                    <td class="py-2 px-4">
                                        {{ $hasil->created_at->translatedFormat('l, d F Y H:i:s') }}
                                    </td>
                                    <td class="py-2 px-4">
                                        @if ($hasil->status == 'pending')
                                            <div class="flex gap-2">
                                                <form action="{{ route('hasil.terima', $hasil->id_hasil) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button
                                                        class="text-green-600 font-semibold hover:underline">✅Terima</button>
                                                </form>
                                                |
                                                <form action="{{ route('hasil.tolak', $hasil->id_hasil) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button
                                                        class="text-red-600 font-semibold hover:underline">❌Tolak</button>
                                                </form>
                                            </div>
                                        @else
                                            <span
                                                class="text-{{ $hasil->status == 'diterima' ? 'green' : 'red' }}-500 font-semibold capitalize">
                                                @if ($hasil->status == 'diterima')
                                                    Hasil Telah Diverifikasi
                                                @elseif ($hasil->status == 'ditolak')
                                                    Hasil Ditolak
                                                @endif
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- CARD untuk mobile -->
                <div class="block md:hidden">
                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($hasil_kuis as $hasil)
                            <div class="bg-white rounded-lg shadow-md p-4 flex flex-col justify-between">
                                <div class="space-y-2">
                                    <h2 class="text-lg font-bold text-indigo-800">{{ $hasil->user->nama }}</h2>
                                    <p class="text-gray-700 text-sm">
                                        <span class="font-semibold">Skor:</span> {{ $hasil->skor }}
                                    </p>
                                    <p class="text-gray-700 text-sm">
                                        <span class="font-semibold">Bukti:</span>
                                        <a href="{{ asset('storage/' . $hasil->bukti) }}"
                                            class="text-blue-600 hover:underline" target="_blank">
                                            Lihat Bukti
                                        </a>
                                    </p>
                                    <p class="text-gray-700 text-sm">
                                        <span class="font-semibold">Waktu Submit:</span>
                                        {{ $hasil->created_at->translatedFormat('l, d F Y H:i:s') }}
                                    </p>
                                    <p class="text-gray-700 text-sm">
                                        <span class="font-semibold">Status:</span>
                                        @if ($hasil->status == 'pending')
                                            <div class="flex gap-2 mt-1">
                                                <form action="{{ route('hasil.terima', $hasil->id_hasil) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button
                                                        class="text-green-600 font-semibold hover:underline">✅Terima</button>
                                                    |
                                                </form>
                                                <form action="{{ route('hasil.tolak', $hasil->id_hasil) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button
                                                        class="text-red-600 font-semibold hover:underline">❌Tolak</button>
                                                </form>
                                            </div>
                                        @else
                                            <span
                                                class="text-{{ $hasil->status == 'diterima' ? 'green' : 'red' }}-500 font-semibold capitalize">
                                                @if ($hasil->status == 'diterima')
                                                    Hasil Telah Diverifikasi
                                                @elseif ($hasil->status == 'ditolak')
                                                    Hasil Ditolak
                                                @endif
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <h1 class="text-white font-semibold text-center">Belum ada hasil yang dikirim.</h1>
            @endif
        </div>
    </div>
</x-layout>
