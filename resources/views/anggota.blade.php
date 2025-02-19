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
<x-layout>
    <div class="flex justify-between">
        <x-button1 href="{{ route('ekskul.show', $ekskul->slug) }}">
            Kembali
        </x-button1>
    @if (optional(auth()->user())->role == 'admin' || optional(auth()->user()->ekskulUser)->jabatan == 1)  
              <x-modal trigger="Jabatan" title="Jabatan" class="flex justify-center"
            buttonClass="bg-ekskul2 text-white px-4 py-2 rounded-md font-bold hover:bg-orange-600 transition">
            @foreach ($anggota as $item)
                @if (($item->pivot->jabatan ?? null) != 5)
                    <div class="text-white font-bold h-10">
                        {{ $jabatanMap[$item->pivot->jabatan] ?? '-' }} = {{ $item->nama }}
                    </div>
                @endif
            @endforeach
            <div class="flex justify-center">
                <x-button1 href="{{ route('jabatan.jabatanShow', $ekskul->slug) }}">Ubah</x-button1>
            </div>
        </x-modal>
        @endif
      
    </div>
    <div class="bg-indigo-900 rounded-lg mt-4 shadow-lg hover:shadow-xl transition duration-300 p-5">
        <div class="shadow-lg rounded-lg p-4 flex justify-between items-center bg-white mb-3">
            <table class="w-full bg-white rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-100 text-gray-800">
                        <th class="py-2 px-4 text-left">No</th>
                        <th class="py-2 px-4 text-left">Nama</th>
                        <th class="py-2 px-4 text-left">Kelas</th>
                        <th class="py-2 px-4 text-left">Jabatan</th>
                        <th class="py-2 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($anggota as $anggota)
                        <tr class="hover:bg-indigo-100 transition">
                            <td class="py-2 px-4">{{ $no++ }}</td>
                            <td class="py-2 px-4">{{ $anggota->nama }}</td>
                            <td class="py-2 px-4">
                                {{ $anggota->kelas->kelas ?? '-' }}
                                {{ $anggota->kelas->jurusan ?? '-' }}
                                {{ $anggota->kelas->nomor_kelas ?? '-' }}
                            </td>
                            @if (($anggota->pivot->jabatan ?? null) == 5)
                                <td class="py-2 px-4">
                                    {{ $jabatanMap[$anggota->pivot->jabatan] ?? '-' }}
                                </td>
                            @else
                                <td class="py-2 px-4 font-bold">
                                    {{ $jabatanMap[$anggota->pivot->jabatan] ?? '-' }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>

{{-- <td class="py-2 flex justify-start">
        <x-modal title="Yakin ingin mengeluarkan {{ $anggota->nama }}?" trigger="Keluarkan"
            buttonClass="bg-red text-ekskul2 px-4 py-2 rounded-md font-bold hover:bg-orange-600 transition">
            <form action="{{ route('anggota.keluar', $anggota->user_id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin mengeluarkan {{ $anggota->nama }} yang seorang {{ $jabatanMap[$anggota->pivot->jabatan] }}?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-2 py-1 text-white bg-red-500 rounded font-bold">Hapus</button>
            </form>
        </x-modal>
    </td> --}}
