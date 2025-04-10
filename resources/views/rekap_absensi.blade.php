<x-layout>
    <div class="container mx-auto mt-6">
        <h2 class="text-3xl font-bold text-center text-black">Rekap Absensi - {{ $ekskul->nama_ekskul }}</h2>
          <p class="text-gray-600 font-bold">Bulan: {{ DateTime::createFromFormat('!m', $bulan) ? DateTime::createFromFormat('!m', $bulan)->format('F') : 'Tidak Valid' }}</p>

       <div class="flex justify-between items-center mt-6">
    <!-- Tombol Kembali di Kiri -->
    <x-button1 href="{{ route('ekskul.show', $ekskul->slug) }}">Kembali</x-button1>

    <!-- Tombol Download di Kanan -->
    <a href="{{ route('rekap.absensi.pdf', ['slug' => $ekskul->slug, 'bulan' => $bulan]) }}"
   class="px-6 py-2 bg-danger text-white font-semibold rounded-lg hover:bg-red-600 transition">
   Download 
</a>

</div>

        <div class="mt-6 bg-blue-900 p-6 shadow-md rounded-lg">
            <div class="bg-white p-4 rounded-lg shadow-lg overflow-x-auto">
                @if($rekapAbsen->isEmpty())
                    <p class="text-center text-gray-500">Belum ada data absensi untuk ekskul ini.</p>
                @else
                    <table class="w-full border-collapse border border-gray-300 rounded-lg">
                        <thead>
    <tr class="bg-blue-900 text-white">
        <th class="border border-gray-300 px-4 py-2">No</th>
        <th class="border border-gray-300 px-4 py-2">Nama</th>
        <th class="border border-gray-300 px-4 py-2">Konfirmasi</th>
        <th class="border border-gray-300 px-4 py-2">Hadir</th>
        <th class="border border-gray-300 px-4 py-2">Izin</th>
        <th class="border border-gray-300 px-4 py-2">Sakit</th>
        <th class="border border-gray-300 px-4 py-2">Alpa</th>
    </tr>
</thead>
<tbody class="bg-gray-100">
    @foreach ($rekapAbsen as $index => $rekap)
    <tr class="text-center">
        <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
        <td class="border border-gray-300 px-4 py-2 font-semibold">{{ $rekap->nama ?? $rekap->username ?? 'Tidak Diketahui' }}</td>
        <td class="border border-gray-300 px-4 py-2">{{ $rekap->konfirmasi ?? 0 }}</td>
        <td class="border border-gray-300 px-4 py-2">{{ $rekap->hadir ?? 0 }}</td>
        <td class="border border-gray-300 px-4 py-2">{{ $rekap->izin ?? 0 }}</td>
        <td class="border border-gray-300 px-4 py-2">{{ $rekap->sakit ?? 0 }}</td>
        <td class="border border-gray-300 px-4 py-2">{{ $rekap->alpa ?? 0 }}</td>
    </tr>
    @endforeach
</tbody>

                    </table>
                @endif
            </div>
        </div>
    </div>
</x-layout>
