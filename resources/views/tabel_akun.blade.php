<x-layout>
    <div class="container mx-auto p-6">
        <div class="bg-maroon-700 p-4 shadow-md rounded-lg text-white">
            <h2 class="text-xl font-semibold mb-4">Halaman Users</h2>
            <input type="text" placeholder="Cari" class="mb-4 p-2 w-full rounded text-black" />
            <table class="w-full border-collapse border border-gray-300 text-white">
                <thead>
                    <tr class="bg-maroon-800">
                        <th class="border border-gray-300 p-2">No</th>
                        <th class="border border-gray-300 p-2">User ID</th>
                        <th class="border border-gray-300 p-2">Nama</th>
                        <th class="border border-gray-300 p-2">Username</th>
                        <th class="border border-gray-300 p-2">Role</th>
                        <th class="border border-gray-300 p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $ekskuls = App\Models\Ekskul::all(); ?>
                @foreach ($ekskuls as $ekskul)
                    <tr class="text-center {{ $index % 2 == 0 ? 'bg-maroon-600' : 'bg-maroon-700' }}">
                        <td class="border border-gray-300 p-2">{{ $index + 1 }}</td>
                        <td class="border border-gray-300 p-2">{{ $users->id }}</td>
                        <td class="border border-gray-300 p-2">{{ $users->name }}</td>
                        <td class="border border-gray-300 p-2">{{ $users->username }}</td>
                        <td class="border border-gray-300 p-2">{{ $users->role }}</td>
                        <td class="border border-gray-300 p-2 flex justify-center gap-2">
                            <a href="{{ route('users.show', $users->id) }}" class="bg-green-500 text-white px-2 py-1 rounded">Detail</a>
                            <a href="{{ route('users.edit', $users->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded">Ubah</a>
                            <form action="{{ route('users.destroy', $users->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
