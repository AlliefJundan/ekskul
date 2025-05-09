 <x-layout>
     <div class="container mx-auto px-6 py-12" x-data="{ modalOpen: false, selectedEkskul: null }">
         <div class="flex items-center mb-8">
             <x-button1 href="{{ route('dashboard_admin') }}">Dashboard</x-button1>
         </div>
         <div class="flex justify-center">
             <p class="font-bold text-4xl">Daftar Ekstrakurikuler yang tersedia</p>
         </div>

         @if ($ekskuls->count() > 0)
             <!-- Grid Ekskul -->
             <div
                 class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8 justify-items-center md:justify-items-stretch">
                 @foreach ($ekskuls as $ekskul)
                     <?php
                     $pembina = "{{ $ekskul->pembina->user->nama ?? 'Belum ada' }}";
                     $ketua = "{{ $ekskul->ketua->user->nama ?? 'Belum ada' }}";
                     $ekskul->jml_anggota = $ekskul->users->where('deleted', false)->count();
                     ?>
                     <div
                         class="relative bg-indigo-800 text-white w-[350px] min-w-[350px] rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-2 hover:shadow-xl">
                         <span class="absolute -bottom-2 -right-2 bg-orange-400 h-full w-full rounded-lg -z-10"></span>

                         <!-- Gambar Ekskul -->
                         <div class="w-full h-60 overflow-hidden">
                             <img class="w-full h-full object-cover object-center"
                                 src="{{ asset('storage/' . $ekskul->gambar) }}" alt="{{ $ekskul->nama_ekskul }}">
                         </div>

                         <div class="p-5">
                             <h4 class="text-xl font-semibold mb-2">{{ $ekskul->nama_ekskul }}</h4>
                             <p class="text-gray-300 text-sm">{{ $ekskul->deskripsi }}</p>
                             <!-- Tombol Lihat Detail -->
                             <button @click="modalOpen = true; selectedEkskul = {{ json_encode($ekskul) }}"
                                 class="mt-3 bg-amber-400 text-indigo-900 font-semibold px-4
                    py-2 rounded-lg shadow-md hover:bg-amber-500 transition">
                                 Lihat Detail →
                             </button>
                         </div>
                     </div>
                 @endforeach
             </div>

             <!-- Modal Detail -->
             <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                 @click.away="modalOpen = false" x-transition>
                 <div class="bg-white rounded-lg p-6 w-96 shadow-lg relative">
                     <button @click="modalOpen = false"
                         class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">✖</button>

                     <template x-if="selectedEkskul">
                         <div>
                             <h2 class="text-xl font-bold mb-4 text-gray-900" x-text="selectedEkskul.nama_ekskul"></h2>
                             <img class="w-full h-60 object-cover rounded-md mb-4"
                                 :src="'/storage/' + selectedEkskul.gambar" alt="Gambar Ekskul">

                             <p><strong>Nama Ekskul:</strong> <span x-text="selectedEkskul.nama_ekskul"></span></p>
                             <p><strong>Nama Pembina:</strong> <span
                                     x-text="selectedEkskul.pembina?.user?.nama || 'Belum ada'"></span></p>
                             <p><strong>Nama Ketua:</strong> <span
                                     x-text="selectedEkskul.ketua?.user?.nama || 'Belum ada'"></span></p>
                             <p><strong>Jumlah Anggota:</strong> <span x-text="selectedEkskul.jml_anggota"></span>
                             </p>
                             <!-- Tombol Daftar -->
                             <div class="flex justify-center mt-6" x-data="{ openConfirm: false }">
                                 @if (auth()->check())
                                     <button @click="openConfirm = true"
                                         class="relative inline-flex items-center px-6 py-3 bg-amber-400 text-indigo-900 font-semibold text-lg rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
                                         Daftar Sekarang!
                                         <span
                                             class="absolute -bottom-1 -right-1 bg-orange-500 h-full w-full rounded-2xl -z-10"></span>
                                     </button>
                                 @else
                                     <x-button1 href="login">Login untuk mendaftar</x-button1>
                                 @endif

                                 <!-- Modal Konfirmasi -->
                                 <div x-show="openConfirm"
                                     class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                                     @click.away="openConfirm = false" x-transition>
                                     <div class="bg-white rounded-lg p-6 w-96 shadow-lg relative">
                                         <h2 class="text-xl font-bold mb-4 text-gray-900 text-center">Yakin mau masuk?
                                         </h2>
                                         @if (auth()->check())
                                             <form method="POST" action="{{ route('pendaftaran.store') }}">
                                                 @csrf
                                                 <input type="hidden" name="id_user"
                                                     value="{{ Auth::user()->id_user }}">
                                                 <input type="hidden" name="id_ekskul"
                                                     x-bind:value="selectedEkskul.id_ekskul">

                                                 <div class="flex justify-center gap-4 mt-4">
                                                     <button type="button" @click="openConfirm = false"
                                                         class="bg-gray-400 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-500 transition">
                                                         Tidak
                                                     </button>
                                                     <button type="submit"
                                                         class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600 transition">
                                                         Ya
                                                     </button>
                                                 </div>
                                             </form>
                                         @endif
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </template>
                 </div>
             </div>
         @else
             <div class="flex justify-center">
                 <h2 class="font-bold">Tidak ada ekskul yang tersedia saat ini</h2>
             </div>
         @endif
     </div>
 </x-layout>
