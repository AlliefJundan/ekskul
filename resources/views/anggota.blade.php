<x-layout>
    @php
        $no = 1;
        $jabatanMap = [
            1 => 'Pembina',
            2 => 'Ketua',
            3 => 'Sekretaris',
            4 => 'Bendahara',
            null => 'Anggota',
        ];
    @endphp

    <div class="container px-4 mx-auto mt-8">
        <x-button1 href="{{ route('ekskul.show', $ekskul->slug) }}">Kembali</x-button1>
        <h1 class="mb-8 text-4xl font-bold text-center">Anggota Ekskul {{ $ekskul->nama_ekskul }}</h1>

        @if ($isAdmin || $userJabatan <= 2)
            <div class="flex justify-start gap-4 mb-4">
                <x-button2 href="{{ route('pendaftaran.show', $ekskul->slug) }}"
                    class="bg-ekskul2 text-white px-4 py-2 rounded-md font-bold hover:bg-orange-600 transition">
                    Permintaan Masuk
                </x-button2>

                @if ($isAdmin || $isPembina)
                    <x-modal trigger="Jabatan" title="Jabatan" class="flex justify-center"
                        buttonClass="bg-ekskul2 text-white px-4 py-2 rounded-md font-bold hover:bg-orange-600 transition">
                        @php
                            $jabatanFix = [1, 2, 3, 4];
                        @endphp
                        @foreach ($jabatanFix as $jabatanId)
                            @php
                                $pemegangJabatan = $anggota->firstWhere('pivot.jabatan', $jabatanId);
                            @endphp
                            <div class="text-gray-700 font-bold h-10">
                                {{ $jabatanMap[$jabatanId] }} = {{ $pemegangJabatan->nama ?? 'Belum Ada' }}
                            </div>
                        @endforeach
                        <div class="flex justify-center mt-4">
                            <x-button1 href="{{ route('jabatan.jabatanShow', $ekskul->slug) }}">Ubah</x-button1>
                        </div>
                    </x-modal>
                @endif
            </div>
        @endif

        <div class="bg-indigo-900 rounded-lg shadow-lg hover:shadow-xl transition duration-300 p-5">

            <!-- TABEL untuk laptop -->
            <div class="hidden md:block">
                <div class="shadow-lg rounded-lg p-4 bg-white mb-3 overflow-x-auto">
                    <table class="w-full bg-white rounded-lg shadow-md border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100 text-gray-800 text-sm md:text-base rounded">
                                <th class="py-2 px-4 text-left">No</th>
                                <th class="py-2 px-4 text-left">Nama</th>
                                <th class="py-2 px-4 text-left">Kelas</th>
                                <th class="py-2 px-4 text-left">Jabatan</th>
                                @if ($canManage)
                                    <th class="py-2 px-4 text-left">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($anggota as $item)
                                <tr class="hover:bg-indigo-100 transition text-sm md:text-base">
                                    <td class="py-2 px-4">{{ $no++ }}</td>
                                    <td class="py-2 px-4">{{ $item->nama }}</td>
                                    <td class="py-2 px-4">
                                        {{ optional($item->kelas)->kelas ?? '-' }}
                                        {{ optional($item->kelas)->jurusan ?? '-' }}
                                        {{ optional($item->kelas)->nomor_kelas ?? '-' }}
                                    </td>
                                    <td class="py-2 px-4 {{ $item->pivot->jabatan !== null ? 'font-bold' : '' }}">
                                        {{ $jabatanMap[$item->pivot->jabatan] ?? '-' }}
                                    </td>
                                    @if ($canManage)
                                        <td class="py-2 px-4">
                                            @php
                                                $targetJabatan = $item->pivot->jabatan;
                                                $canKick = false;
                                                if ($isAdmin) {
                                                    $canKick = true;
                                                } elseif ($isPembina && $targetJabatan != 1) {
                                                    $canKick = true;
                                                } elseif (
                                                    $userJabatan == 2 &&
                                                    $targetJabatan !== 1 &&
                                                    $targetJabatan !== 2
                                                ) {
                                                    $canKick = true;
                                                }
                                            @endphp

                                            @if ($canKick)
                                                <x-modal title="Yakin ingin mengeluarkan {{ $item->nama }}?"
                                                    trigger="Keluarkan"
                                                    buttonClass="bg-red-500 text-white px-3 py-1 rounded-md font-bold hover:bg-red-600 transition text-sm">
                                                    <form action="{{ route('anggota.keluarkan', $ekskul->slug) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin mengeluarkan {{ $item->nama }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="user_id"
                                                            value="{{ $item->id_user }}">
                                                        <input type="hidden" name="ekskul_id"
                                                            value="{{ $ekskul->id_ekskul }}">
                                                        <button type="submit"
                                                            class="px-3 py-1 bg-red-500 text-white rounded font-bold text-sm">Hapus</button>
                                                    </form>
                                                </x-modal>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- CARD untuk mobile -->
            <div class="block md:hidden">
                <div class="grid grid-cols-1 gap-4">
                    @foreach ($anggota as $item)
                        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col justify-between">
                            <div class="space-y-2">
                                <h2 class="text-lg font-bold text-indigo-800">{{ $item->nama }}</h2>
                                <p class="text-gray-700 text-sm">
                                    <span class="font-semibold">Kelas:</span>
                                    {{ optional($item->kelas)->kelas ?? '-' }}
                                    {{ optional($item->kelas)->jurusan ?? '-' }}
                                    {{ optional($item->kelas)->nomor_kelas ?? '-' }}
                                </p>
                                <p class="text-gray-700 text-sm">
                                    <span class="font-semibold">Jabatan:</span>
                                    <span class="{{ $item->pivot->jabatan !== null ? 'font-bold' : '' }}">
                                        {{ $jabatanMap[$item->pivot->jabatan] ?? '-' }}
                                    </span>
                                </p>
                            </div>

                            @if ($canManage)
                                @php
                                    $targetJabatan = $item->pivot->jabatan;
                                    $canKick = false;
                                    if ($isAdmin) {
                                        $canKick = true;
                                    } elseif ($isPembina && $targetJabatan != 1) {
                                        $canKick = true;
                                    } elseif ($userJabatan == 2 && $targetJabatan !== 1 && $targetJabatan !== 2) {
                                        $canKick = true;
                                    }
                                @endphp

                                @if ($canKick)
                                    <div class="mt-4 flex justify-end">
                                        <x-modal title="Yakin ingin mengeluarkan {{ $item->nama }}?"
                                            trigger="Keluarkan"
                                            buttonClass="bg-red-500 text-white px-3 py-1 rounded-md font-bold hover:bg-red-600 transition text-sm">
                                            <form action="{{ route('anggota.keluarkan', $ekskul->slug) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin mengeluarkan {{ $item->nama }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="user_id" value="{{ $item->id_user }}">
                                                <input type="hidden" name="ekskul_id"
                                                    value="{{ $ekskul->id_ekskul }}">
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-500 text-white rounded font-bold text-sm">Hapus</button>
                                            </form>
                                        </x-modal>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-layout>
