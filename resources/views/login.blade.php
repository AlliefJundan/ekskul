<x-layout>
    <div class="flex items-center justify-center min-h-screen bg-white px-4 sm:px-0">
        <div class="bg-[#0B0022] p-8 sm:p-16 rounded-lg shadow-md w-full max-w-sm sm:max-w-md">
            <h2 class="text-xl sm:text-2xl font-bold text-center text-white">LOGIN</h2>
            <div class="mt-4">
                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="username" class="text-white">Username</label>
                        <input type="text" name="username" class="w-full p-2 mt-1 text-black border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukan Username" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="text-white">Password</label>
                        <input type="password" name="password" class="w-full p-2 mt-1 text-black border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukan Password" required>
                    </div>
                    <div class="flex justify-center mt-5">
                        <button type="submit" class="px-4 py-2 font-bold text-black bg-yellow-500 rounded-lg shadow-md hover:bg-yellow-600">Login</button>
                    </div>
                </form>
                @if (session('gagal'))
                    <div class="p-3 mt-4 text-white bg-red-500 rounded-md">
                        {{ session('gagal') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>