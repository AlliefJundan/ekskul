  <x-layout>
      <section id="home" class="relative w-full h-screen bg-cover bg-center flex items-center justify-center "
          style="background-image: url('/img/imagee.png');">
          <div class="absolute inset-0 bg-black bg-opacity-50"></div>
          <div class="relative text-center text-white px-6">
              <h1 class="text-5xl md:text-6xl font-bold uppercase">Ekstrakurikuler</h1>
              <p class="mt-4 text-lg md:text-xl">SMK Bakti Nusantara 666</p>
              <a href="#about"
                  class="relative inline-flex items-center px-6 py-3 text-white bg-ekskul font-semibold text-lg rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
                  Pelajari
                  <span class="absolute -bottom-1 -right-1 bg-ekskul2 h-full w-full rounded-2xl -z-10"></span>
              </a>

          </div>
      </section>



      @include('about')

      @include('gallery')

  </x-layout>
