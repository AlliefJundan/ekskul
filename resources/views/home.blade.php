  <x-layout>
      <section id="home"
          class="relative w-full h-screen bg-cover bg-center flex items-center justify-center "
          style="background-image: url('/img/imagee.png');">
          <div class="absolute inset-0 bg-black bg-opacity-50"></div>
          <div class="relative text-center text-white px-6">
              <h1 class="text-5xl md:text-6xl font-bold uppercase">Ekstrakurikuler</h1>
              <p class="mt-4 text-lg md:text-xl">SMK Bakti Nusantara 666</p>
              <a href="#about"
                  class="mt-6 inline-block px-6 py-3 bg-amber-400 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-md">
                  Pelajari
              </a>

          </div>
      </section>



      @include('about')

      @include('gallery')

  </x-layout>
