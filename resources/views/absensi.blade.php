<x-layout>
    <div class="flex items-center mb-4 sm:mb-8">
        <a href="javascript:history.back()" class="flex items-center px-3 py-2 text-white rounded-lg shadow-md bg-yellow-500 hover:bg-blue-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
    </div>
    <div class="my-4 text-2xl font-bold text-center sm:text-3xl">Absen</div>
    <div class="text-base font-semibold text-center sm:text-lg">Tanggal Hari Ini: {{ now()->translatedFormat('l, d F Y') }}</div>
    
    <div class="grid grid-cols-2 gap-4 px-4 mt-6 sm:flex sm:justify-center sm:gap-6 sm:px-10">
        @foreach (['Hadir', 'Izin', 'Sakit', 'Alfa'] as $status)
            <div class="flex flex-col items-center justify-center w-full p-6 text-sm font-semibold text-center text-white border-4 border-blue-900 rounded-lg shadow-lg bg-ekskul2 sm:w-56 sm:p-10 sm:text-lg h-28 sm:h-36">
                <span>{{ $status }}</span>
                <span class="text-lg font-bold sm:text-2xl">{{ $count[$status] }} Hari</span>
            </div>
        @endforeach
    </div>
    
    <div class="flex justify-center px-4 mt-6 sm:justify-start sm:px-10">
        <form action="{{ route('absensi.store') }}" method="POST" class="flex flex-col items-center gap-4 sm:flex-row">
            @csrf
            <input type="hidden" name="id_user" value="{{ Auth::user()->id_user }}">
            <select name="kehadiran" class="p-2 text-sm text-black border border-blue-900 rounded sm:text-lg">
                <option value="hadir">Hadir</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="alpa">Alfa</option>
            </select>
            <input type="hidden" name="id_ekskul" value="1">
            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-blue-900 rounded-md shadow-md sm:px-6 sm:text-lg">Tambah</button>
        </form>
    </div>
    
    <div class="p-4 mx-4 mt-6 text-white bg-blue-900 rounded-md shadow-md sm:p-6 sm:mx-10">
        <div class="overflow-x-auto">
            <table class="w-full text-sm sm:text-lg">
                <thead>
                    <tr class="border-b border-ekskul2">
                        <th class="p-2 sm:p-3">Tanggal</th>
                        <th class="p-2 sm:p-3">Kehadiran</th>
                        <th class="p-2 sm:p-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absensi as $absen)
                        <tr class="border-b border-ekskul2">
                            <td class="p-2 sm:p-3">{{ $absen->tanggal }}</td>
                            <td class="p-2 sm:p-3">{{ ucfirst($absen->kehadiran) }}</td>
                            <td class="p-2 sm:p-3">{{ ucfirst($absen->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
