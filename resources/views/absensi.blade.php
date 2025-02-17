<x-layout>
    <div class="my-6 text-3xl font-bold text-center">Absen</div>
    <div class="text-lg font-semibold text-center">Tanggal Hari Ini: {{ now()->translatedFormat('l, d F Y') }}</div>
    <div class="flex justify-center gap-6 px-10 mt-6">
        @foreach (['Hadir', 'Izin', 'Sakit', 'Alfa'] as $status)
            <div
                class="flex flex-col items-center justify-center w-56 p-10 text-lg font-semibold text-center text-white border-8 border-blue-900 rounded-lg shadow-lg bg-ekskul2 h-36">
                <span>{{ $status }}</span>
                <span class="text-2xl font-bold">{{ $count[$status] }} Hari</span>
            </div>
        @endforeach
    </div>
    <div class="flex justify-start px-10 mt-6">
        <form action="{{ url('/absensi') }}" method="POST" class="flex items-center gap-4">
            @csrf
            <button type="submit"
                class="px-6 py-2 text-lg font-semibold text-white bg-blue-900 rounded-md shadow-md">Tambah</button>
            <select name="kehadiran" class="p-2 text-lg text-black border border-blue-900 rounded">
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
    <div class="p-6 mx-10 mt-6 text-white bg-blue-900 rounded-md shadow-md">
        <table class="w-full text-lg">
            <thead>
                <tr class="border-b border-ekskul2">
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Kehadiran</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absensi as $absen)
                    <tr class="border-b border-ekskul2">
                        <td class="p-3">{{ $absen->tanggal }}</td>
                        <td class="p-3">{{ ucfirst($absen->kehadiran) }}</td>
                        <td class="p-3">{{ ucfirst($absen->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
