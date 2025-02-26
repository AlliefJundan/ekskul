<x-layout>
    <div class="flex justify-center">
        <h1 class="mb-4 text-2xl font-bold text-center">Pengajuan Anggota Ekskul</h1>
    </div>

    @if (session('success'))
        <div class="p-3 mb-4 text-green-700 bg-green-200 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="p-5 mt-4 transition duration-300 bg-indigo-900 rounded-lg shadow-lg hover:shadow-xl">
        <div class="p-4 mb-3 overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="w-full bg-white border border-collapse border-gray-300 rounded-lg shadow-md">
                <thead>
                    <tr class="text-sm text-gray-800 bg-gray-100 md:text-base">
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Username</th>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Ekskul</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengajuanEkskul as $index => $user)
                        @foreach ($user->ekskul as $ekskul)
                            @if ($ekskul->pivot->status === 'pending')
                                <tr class="text-sm transition hover:bg-indigo-100 md:text-base">
                                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2">{{ $user->username }}</td>
                                    <td class="px-4 py-2">{{ $user->nama }}</td>
                                    <td class="px-4 py-2">{{ $ekskul->nama_ekskul }}</td>
                                    <td class="flex px-4 py-2 space-x-2">
                                        <form
                                            action="{{ route('terimaPengajuanEkskul.terima', [$user->id_user, $ekskul->id_ekskul]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="px-2 py-1 text-white bg-green-500 rounded hover:bg-green-600">
                                                Terima
                                            </button>
                                        </form>
                                        <form
                                            action="{{ route('terimaPengajuanEkskul.tolak', [$user->id_user, $ekskul->id_ekskul]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="px-2 py-1 text-white bg-red-500 rounded hover:bg-red-600">
                                                Tolak
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
