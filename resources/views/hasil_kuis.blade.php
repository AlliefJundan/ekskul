<x-layout>

    <div class="container px-4 mx-auto mt-8">

        <!-- Tombol Kembali -->
        <div class="mb-4  ">
            <x-button1 href="{{ route('kuis.hasilKuis', $ekskul->slug) }}">
                Kembali
            </x-button1>
        </div>
        <tr class="bg-indigo-700 text-white">
            <!-- Tabel Hasil Kuis -->
            <div class="bg-indigo-900 rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5">

                @if ($hasil_kuis->count() > 0)
                    <table class="w-full bg-white rounded-lg font-semibold shadow-md">
                        <thead>
                            <th class="py-2 px-4">Nama</th>
                            <th class="py-2 px-4">Skor</th>
                            <th class="py-2 px-4">Bukti</th>
                            <th class="py-2 px-4">Waktu Submit</th>
                            <th class="py-2 px-4">Status</th>

        </tr>
        </thead>
        <tbody>
            @foreach ($hasil_kuis as $hasil)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $hasil->user->nama }}</td>
                    <td class="py-2 px-4">{{ $hasil->skor }}</td>
                    <td class="py-2 px-4">
                        <a href="{{ asset('storage/' . $hasil->bukti) }}" class="text-blue-600 hover:underline"
                            target="_blank">
                            Lihat Bukti
                        </a>
                    </td>
                    <td class="py-2 px-4">
                        {{ $hasil->created_at->translatedFormat('l, d F Y H:i:s') }}
                    </td>
                    <td class="py-2 px-4">
                        @if ($hasil->status == 'pending')
                            <div class="flex gap-2">
                                <form action="{{ route('hasil.terima', $hasil->id_hasil) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="text-green-600 font-semibold hover:underline">✅Terima</button>
                                </form>
                                |
                                <form action="{{ route('hasil.tolak', $hasil->id_hasil) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="text-red-600 font-semibold hover:underline">❌Tolak</button>
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
    @else
        <h1 class="text-white font-semibold text-center">Belum ada hasil yang dikirim.</h1>
        @endif
    </div>
    </div>

</x-layout>
