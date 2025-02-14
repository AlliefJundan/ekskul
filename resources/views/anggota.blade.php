<x-layout>

    <div class="bg-indigo-900 rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5">
        <div class="shadow-lg rounded-lg p-4 flex justify-between items-center bg-white mb-3">
            <table class="w-full bg-white rounded-lg shadow-md">
                <thead>
                    <tr>
                        <th class="py-2 px-4">No</th>
                        <th class="py-2 px-4">Nama</th>
                        <th class="py-2 px-4">Kelas</th>
                        <th class="py-2 px-4">Jabatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($anggota as $anggota)
                        <tr>
                            <td class="py-1 px-4">{{ $no++ }}</td>
                            <td class="py-1 px-4">{{ $anggota->nama }}</td>
                            <td class="py-1 px-4">
                                {{ $anggota->kelas->kelas ?? '-' }}
                                {{ $anggota->kelas->jurusan ?? '-' }}
                                {{ $anggota->kelas->nomor_kelas ?? '-' }}
                            </td>
                            <td class="py-1 px-4">
                                <?php
                                $jabatanMap = [
                                    1 => 'Pembina',
                                    2 => 'Ketua',
                                    3 => 'Sekretaris',
                                    4 => 'Bendahara',
                                    5 => 'Anggota',
                                ];
                                
                                $jabatanCode = $anggota->pivot->jabatan ?? null;
                                echo $jabatanMap[$jabatanCode] ?? '-';
                                ?>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-layout>
