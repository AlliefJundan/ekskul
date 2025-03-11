<x-layout>
    <div class="grid gap-6 mt-8 grid-cols-1 md:grid-cols-8">
        <div></div>

        <div class="md:col-span-6">
            @if ($notifikasi->count() < 1)
                <p class="text-center text-gray-500">Tidak ada notifikasi.</p>
            @endif
            <div class="flex justify-end md-2 underline text-red-600">
                <a href = ''>Tandai sudah dilihat semua</a>
            </div>

            @foreach ($notifikasi as $item)
                <a href="{{ $item->notifikasi->url }}"
                    class="notifikasi-link shadow-md rounded-md p-2 md:p-3 bg-white mb-2 mt-2 w-full md:w-4/4 mx-auto block text-left
                    {{ $item->is_read ? 'bg-gray-200' : 'bg-white' }}"
                    data-id="{{ $item->id_notifikasi }}">

                    <h3 class="text-indigo-900 font-bold text-sm md:text-base">{{ $item->notifikasi->title }}</h3>
                    <h3 class="text-gray-700 text-xs md:text-sm">
                        {{ $item->notifikasi->description }} di ekskul {{ $item->notifikasi->ekskul->nama_ekskul }}
                    </h3>
                </a>
            @endforeach
        </div>
    </div>
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.notifikasi-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // Cegah redirect dulu

                let notifikasiId = this.dataset.id;
                let redirectUrl = this.href; // Simpan URL tujuan

                fetch("{{ route('notifikasi.read') }}", {
                        method: "POST",
                        body: JSON.stringify({
                            id_notifikasi: notifikasiId
                        }),
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Tandai sebagai sudah dibaca
                            this.classList.remove("bg-white");
                            this.classList.add("bg-gray-200");
                        }

                        // Lanjutkan ke halaman tujuan
                        window.location.href = redirectUrl;
                    }).catch(error => {
                        console.error("Error:", error);
                        // Jika gagal update, tetap arahkan ke halaman tujuan
                        window.location.href = redirectUrl;
                    });
            });
        });
    });
</script>
