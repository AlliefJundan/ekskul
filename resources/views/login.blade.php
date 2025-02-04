<x-layout>
    <div class="flex items-start justify-center min-h-screen bg-white pt-16">
        <div class="bg-[#863942] p-16 rounded-lg shadow-md w-[500px]">
            <h2 class="text-white text-center text-2xl font-bold">LOGIN</h2>
            <div class="mt-3">
                <form>
                    <input type="text" id="username" name="username" placeholder="Username" required
                        class="w-full mt-2 p-1 bg-gray-300 rounded focus:outline-none text-black text-lg">
            </div>

            <div class="mt-3">
                <input type="password" id="password" name="password" placeholder="Password" required
                    class="w-full mt-2 p-1 bg-gray-300 rounded focus:outline-none text-black text-lg">
            </div>

            <div class="mt-8 flex justify-center">
                <button type="submit"
                    class="bg-[#8174A0] text-black font-semibold px-8 py-3 rounded-lg hover:bg-[#6a547e] text-lg">
                    LOGIN
                </button>
            </div>
            </form>
        </div>
    </div>
</x-layout>
