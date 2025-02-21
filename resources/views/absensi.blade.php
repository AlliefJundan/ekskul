<x-layout>

    <div class="container px-4 mx-auto mt-8">
        <div class="flex items-center mb-8">
            <a href="javascript:history.back()"
                class="flex items-center px-3 py-2 text-white bg-yellow-500 rounded-lg shadow-md hover:bg-blue-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        </div>   

        {{-- @dd($absensi); --}}
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
            <form action="{{ route('absensi.store') }}" method="POST" class="flex items-center gap-4">
                @csrf
                <input type="hidden" name="id_user" value="{{ Auth::user()->id_user }}">
                <button type="submit"
                    class="px-6 py-2 text-lg font-semibold text-white bg-blue-900 rounded-md shadow-md">Tambah</button>
                <select name="kehadiran" class="p-2 text-lg text-black border border-blue-900 rounded">
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="alpa">Alfa</option>
                </select>
                <input type="hidden" name="id_ekskul" value="1">
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

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif


                </tbody>
            </table>
        </div>
</x-layout>
