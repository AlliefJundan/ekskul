<x-layout>

    <div class="bg-indigo-900 rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5">
        <div class="shadow-lg rounded-lg p-4 flex justify-between items-center bg-white mb-3">
            <table class="w-full bg-white rounded-lg shadow-md">
                <thead>
                    <th class="py-2 px-4">Nama</th>
                    <th class="py-2 px-4">Kelas</th>
                    <th class="py-2 px-4">Jabatan</th>
                </thead>
                @foreach ($anggota as $anggota)
                    <tbody>
                        <td class="py-1 px-4">{{ $anggota->nama }}</td>
                        <!-- Get kelas and id_kelas for each anggota -->
                        <td class="py-1 px-4">

                            {{ $anggota->kelas->kelas }} {{ $anggota->kelas->jurusan }}
                            {{ $anggota->kelas->nomor_kelas }}

                        </td>
                        <td class="py-1 px-4">{{ $anggota->jabatan->nama_jabatan ?? '-' }}</td>
                    </tbody>
                @endforeach
            </table>
        </div>
    </div>

</x-layout>
