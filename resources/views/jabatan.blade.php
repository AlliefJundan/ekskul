<x-layout>
    @php
        $no = 1;
        $jabatanMap = [
            1 => 'Pembina',
            2 => 'Ketua',
            3 => 'Sekretaris',
            4 => 'Bendahara',
        ];
    @endphp
    <div class="container px-4 mx-auto mt-8">

        <x-button1 href="{{ route('anggota.show', $ekskul->slug) }}">Kembali</x-button1>
        <h1 class="text-4xl font-bold text-center mb-4">Struktur Organisasi Ekskul {{ $ekskul->nama_ekskul }}</h1>

        <div class="bg-indigo-900 rounded-lg mt-4 shadow-lg hover:shadow-xl transition duration-300 p-5">
            <div class="shadow-lg rounded-lg p-4 bg-white mb-3">
                <table class="w-full bg-white rounded-lg shadow-md border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100 text-gray-800">
                            <th class="py-2 px-4 text-left">No</th>
                            <th class="py-2 px-4 text-left">Jabatan</th>
                            <th class="py-2 px-4 text-left">Pemegang Jabatan</th>
                            <th class="py-2 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jabatanMap as $jabatanId => $jabatanNama)
                            @php
                                $pemegangJabatan = $anggota->firstWhere('pivot.jabatan', $jabatanId);
                            @endphp
                            <tr class="hover:bg-indigo-100 transition">

                                <td class="py-3 px-4">{{ $no++ }}</td>
                                <td class="py-3 px-4  font-bold">{{ $jabatanNama }}</td>
                                <td class="py-3 px-4 ">
                                    {{ $pemegangJabatan->nama ?? 'Belum Ada' }}
                                </td>
                                <td class="py-3 px-4 ">
                                    <div class="flex justify-start">
                                        <x-modal trigger="Ganti" title="Ganti Pemegang {{ $jabatanNama }}"
                                            buttonClass="bg-ekskul text-ekskul2 px-4 py-2 rounded-md font-bold hover:bg-orange-600 transition">
                                            <form method="post"
                                                action="{{ route('jabatan.jabatanUpdate', $ekskul->slug) }}"
                                                onsubmit="return confirm('Apakah Anda yakin untuk mengubah pemegang jabatan {{ $jabatanNama }} dari {{ $pemegangJabatan->nama ?? 'Belum Ada' }} menjadi ' + document.querySelector('[name=\'nama_baru\']').options[document.querySelector('[name=\'nama_baru\']').selectedIndex].text)">
                                                @csrf
                                                <input type="hidden" name="jabatan_id" value="{{ $jabatanId }}">

                                                <label class="block text-gray-700 font-semibold">Pemegang Saat
                                                    Ini</label>
                                                <input type="text"
                                                    class="w-full mb-3 border rounded-md p-2 bg-gray-100"
                                                    value="{{ $pemegangJabatan->nama ?? 'Belum Ada' }}" readonly>

                                                <label class="block text-gray-700 font-semibold">Pilih Anggota
                                                    Baru</label>
                                                <select name="nama_baru"
                                                    class="w-full border rounded-md p-2 bg-gray-100">
                                                    <option value="">-- Pilih Anggota --</option>
                                                    @foreach ($anggota as $member)
                                                        @if (!in_array($member->pivot->jabatan, [1, 2, 3, 4]))
                                                            <option value="{{ $member->id_user }}">{{ $member->nama }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <div class="flex justify-center mt-4">
                                                    <input type="submit" value="Simpan"
                                                        class="bg-ekskul text-ekskul2 px-4 py-2 rounded-md font-bold hover:bg-orange-600 transition">
                                                </div>
                                            </form>
                                        </x-modal>

                                        {{-- Modal untuk melepas jabatan --}}
                                        @if ($pemegangJabatan)
                                            <x-modal trigger="Lepas Jabatan" title="Konfirmasi Lepas Jabatan"
                                                buttonClass="bg-red-500 text-gray-700 px-4 py-2 ml-5 rounded-md font-bold hover:bg-red-600 transition">
                                                <form method="post"
                                                    action="{{ route('jabatan.jabatanRemove', $ekskul->slug) }}"
                                                    onsubmit="return confirm('Apakah Anda yakin untuk melepas jabatan {{ $jabatanNama }} dari {{ $pemegangJabatan->nama }}?')">
                                                    @csrf
                                                    <input type="hidden" name="jabatan_id"
                                                        value="{{ $jabatanId }}">

                                                    <div class="mb-4 text-gray-700 font-semibold">
                                                        Apakah Anda yakin ingin melepas jabatan {{ $jabatanNama }}
                                                        dari
                                                        {{ $pemegangJabatan->nama }}?
                                                    </div>

                                                    <div class="flex justify-center">
                                                        <input type="submit" value="Lepas Jabatan"
                                                            class="bg-red-600 text-white px-4 py-2 rounded-md font-bold hover:bg-red-700 transition">
                                                    </div>
                                                </form>
                                            </x-modal>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
</x-layout>
