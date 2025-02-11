<x-layout>
    <div class="container mx-auto mt-10 p-5">
        <h1 class="text-3xl font-bold text-center mb-5">Materi Hari Ini</h1>

        @if(session('success'))
            <div class="bg-green-200 p-3 text-green-800 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 shadow rounded">
            @csrf

            <table class="w-full border border-gray-300">
                <tr class="bg-gray-100">
                    <th class="border p-2 text-left">Pilih Ekskul</th>
                    <td class="border p-2">
                        <select name="id_ekskul" class="w-full border rounded p-2" required>
                            <option value="" disabled selected>Pilih ekskul</option>
                            @foreach ($ekskulList as $ekskul)
                                <option value="{{ $ekskul->id_ekskul }}">{{ $ekskul->nama_ekskul }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <th class="border p-2 text-left">Isi Materi</th>
                    <td class="border p-2">
                        <textarea name="isi_materi" rows="3" class="w-full border rounded p-2" required></textarea>
                    </td>
                </tr>

                <tr>
                    <th class="border p-2 text-left">Lampiran (Folder)</th>
                    <td class="border p-2">
                        <input type="file" name="lampiran_materi[]" multiple webkitdirectory directory class="w-full border p-2">
                        <small class="text-gray-500">Pilih folder untuk mengunggah semua file di dalamnya.</small>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="border p-2 text-right">
                        <button type="submit" class="bg-blue-600 text-blue px-4 py-2 rounded">
                            Kirim Materi
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</x-layout>
