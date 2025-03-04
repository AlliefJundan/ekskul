<x-layout>
    <div class="container mx-auto mt-6">
                <div class="flex items-center mb-8">
            <x-button1 href="{{ route('ekskul.show', $ekskul->slug) }}">Kembali</x-button1>
        </div>
        <h2 class="text-2xl font-bold text-center text-Amber-600">Rekap Absensi - {{ $ekskul->nama_ekskul }}</h2>

        <div class="mt-6 bg-white p-6 shadow-md rounded-lg overflow-x-auto">
            @if($rekapAbsen->isEmpty())
                <p class="text-center text-gray-500">Belum ada data absensi untuk ekskul ini.</p>
            @else
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-blue-900 text-white">
                            <th class="border border-gray-300 px-4 py-2">Nama</th>
                            <th class="border border-gray-300 px-4 py-2">Hadir</th>
                            <th class="border border-gray-300 px-4 py-2">Izin</th>
                            <th class="border border-gray-300 px-4 py-2">Sakit</th>
                            <th class="border border-gray-300 px-4 py-2">Alpa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekapAbsen as $rekap)
                        <tr class="text-center">
                            <td class="border border-gray-300 px-4 py-2">{{ $rekap->nama ?? $rekap->username ?? 'Tidak Diketahui' }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $rekap->hadir ?? 0 }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $rekap->izin ?? 0 }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $rekap->sakit ?? 0 }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $rekap->tidak_hadir ?? 0 }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-layout>
