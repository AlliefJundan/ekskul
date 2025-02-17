<x-layout>
    @php
        $no = 1;
        $jabatanMap = [
            1 => 'Pembina',
            2 => 'Ketua',
            3 => 'Sekretaris',
            4 => 'Bendahara',
            5 => 'Anggota',
        ];
    @endphp
    <a href="{{ route('anggota.show', $ekskul->slug) }}"
        class="inline-block px-4 py-2 mb-3 bg-ekskul hover:bg-orange-600 text-ekskul2 font-semibold rounded-lg shadow-md">
        Kembali
    </a>
    <div class="bg-indigo-900 rounded-lg mt-4 shadow-lg hover:shadow-xl transition duration-300 p-5">
        <div class="shadow-lg rounded-lg p-4 flex justify-between items-center bg-white mb-3">
            <table class="w-full bg-white rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-100 text-gray-800">
                        <th class="py-2 px-4">No</th>
                        <th class="py-2 px-4">Jabatan</th>
                        <th class="py-2 px-4">Nama</th>
                        <th class="py-2 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($anggota as $item)
                        @if (($item->pivot->jabatan ?? null) != 5)
                            <tr class="hover:bg-indigo-100 transition">
                                <td class="py-3 px-4">{{ $no++ }}</td>
                                <td class="py-3 px-4">
                                    {{ $jabatanMap[$item->pivot->jabatan] ?? '-' }} </td>
                                <td class="py-3 px-4"> {{ $item->nama }}</td>
                                <td>
                                    <x-modal trigger="Ganti" title="Ganti Pemegang Jabatan" class="flex justify-center"
                                        buttonClass="bg-ekskul text-ekskul2 px-4 py-2 rounded-md font-bold hover:bg-orange-600 transition">
                                        <form method="post">
                                            @csrf
                                            <input type="hidden" name="ekskul_id" value="{{ $anggota->ekskul_id }}">
                                            <label class="block text-white">Nama Jabatan</label>
                                            <input type="text" name="jabatan"
                                                value=" {{ $jabatanMap[$item->pivot->jabatan] ?? '-' }} "
                                                class="w-full mb-3 border border-gray-300 rounded-md p-2 bg-gray-100"
                                                readonly>
                                            <label class="block text-white">Pemilik Jabatan Saat Ini</label>
                                            <input type="text" name="nama"
                                                class="w-full border border-gray-300 rounded-md p-2 bg-gray-100"
                                                value=" {{ $item->nama }} " readonly>
                                            <label class="block text-white">Pemilik Jabatan yang baru</label>
                                            <select name="nama_baru" id="nama_baru"
                                                class="w-full border border-gray-300 rounded-md p-2 bg-gray-100">
                                                <option value="" class="md-5">-- Pilih Anggota --</option>
                                                @foreach ($anggota as $member)
                                                    @if (($member->pivot->jabatan ?? null) == 5)
                                                        <option value="{{ $member->id }}">{{ $member->nama }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="flex justify-end">
                                                <input type="submit"
                                                    class="bg-ekskul ml-4 text-ekskul2 px-4 py-2 rounded-md mt-4 font-bold hover:bg-orange-600 transition">
                                            </div>
                                        </form>
                                    </x-modal>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
