<x-layout>
    <div class="text-center text-3xl font-bold my-6">Absen</div>
    <div class="text-center text-lg font-semibold">Tanggal Hari Ini: {{ now()->translatedFormat('l, d F Y') }}</div>
    <div class="flex justify-center gap-6 mt-6 px-10">
        @foreach (['Hadir', 'Izin', 'Sakit', 'Alfa'] as $status)
            <div
                class="border-8 border-blue-900 bg-ekskul2 text-white p-10 rounded-lg text-center text-lg font-semibold shadow-lg w-56 h-36 flex flex-col items-center justify-center">
                <span>{{ $status }}</span>
                <span class="text-2xl font-bold">{{ $count[$status] }} Hari</span>
            </div>
        @endforeach
    </div>
    <div class="mt-6 flex justify-start px-10">
        <form action="{{ url('/absensi') }}" method="POST" class="flex items-center gap-4">
            @csrf
            <button type="submit"
                class="bg-blue-900 text-white px-6 py-2 rounded-md shadow-md text-lg font-semibold">Tambah</button>
            <select name="kehadiran" class="p-2 border border-blue-900 rounded text-lg text-black">
                <option value="hadir">Hadir</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="alpa">Alfa</option>
            </select>
            <input type="hidden" name="id_ekskul" value="{{ Auth::user()->id_ekskul }}">
            <input type="hidden" name="status" value="belum terverifikasi">
            <input type="hidden" name="tanggal" value="{{ now()->toDateString() }}">
        </form>
    </div>
    <div class="bg-blue-900 text-white p-6 mt-6 rounded-md shadow-md mx-10">
        <table class="w-full text-lg">
            <thead>
                <tr class="border-b border-black">
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Kehadiran</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absensi as $absen)
                    <tr class="border-b border-black ">
                        <td class="p-3">{{ $absen->tanggal }}</td>
                        <td class="p-3">{{ ucfirst($absen->kehadiran) }}</td>
                        <td class="p-3">{{ ucfirst($absen->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
