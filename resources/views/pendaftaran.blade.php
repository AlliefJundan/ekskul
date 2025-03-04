@php
    $no = 1;
@endphp
<x-layout>
    <div class="container px-4 mx-auto mt-8">
        <x-button1 href="{{ route('anggota.show', $ekskul->slug) }}">Kembali</x-button1>
        <h1 class="text-4xl font-bold text-center mb-4">Permintaan Masuk Ekskul {{ $ekskul->nama_ekskul }}</h1>

        <div class="bg-indigo-900 rounded-lg mt-4 shadow-lg hover:shadow-xl transition duration-300 p-5">
            @if ($pendaftaran->count() > 0)
                <div class="shadow-lg rounded-lg p-4 bg-white mb-3 overflow-x-auto">
                    <table class="w-full bg-white rounded-lg shadow-md border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100 text-gray-800 text-sm md:text-base rounded">
                                <th class="py-2 px-4 text-left">No</th>
                                <th class="py-2 px-4 text-left">Nama</th>
                                <th class="py-2 px-4 text-left">Kelas</th>
                                <th class="py-2 px-4 text-left">Waktu daftar</th>
                                <th class="py-2 px-4 text-left">Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendaftaran as $item)
                                <tr class="hover:bg-indigo-100 transition text-sm md:text-base">
                                    <td class="py-2 px-4">{{ $no++ }}</td>
                                    <td class="py-2 px-4">{{ $item->user->nama }}</td>
                                    <td class="py-2 px-4">
                                        {{ $item->user->kelas->kelas ?? '-' }}
                                        {{ $item->user->kelas->jurusan ?? '-' }}
                                        {{ $item->user->kelas->nomor_kelas ?? '-' }}
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                    <td class="flex justify-left gap-2 p-2">
                                        <x-modal trigger="Terima" title="Terima {{ $item->user->nama }} untuk masuk">
                                            <form method="POST" action="{{ route('pendaftaran.terima') }}">
                                                @csrf
                                                <input type="hidden" name="id_pendaftaran" id="id_pendaftaran"
                                                    value="{{ $item->id_pendaftaran }}">
                                                <div class="flex justify-center gap-2 p-1">
                                                    <button @click="open = false"
                                                        class="px-2 py-1 font-bold text-white text-xl bg-red-500 rounded hover:bg-red-700">Batal</button>
                                                    <button type="submit"
                                                        class="bg-ekskul font-bold text-ekskul2 px-4 py-2 rounded-md hover:bg-blue-600 transition">
                                                        ✔ Terima
                                                    </button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    </td>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h1 class="text-white font-semibold mb-2 text-center">Tidak ada User yang mendaftar.
                    </h1>
            @endif
        </div>
    </div>
    </div>
</x-layout>
