<x-layout>
    <div class="flex items-start justify-center min-h-screen pt-16 bg-white">
        <div class="bg-[#0B0022] p-16 rounded-lg shadow-md w-[500px]">
            <h2 class="text-2xl font-bold text-center text-white">LOGIN</h2>
            <div class="mt-3">
                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username" style="color: white;">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukan Username"
                            required>
                    </div>
                    <div class="mt-5 form-group">
                        <label for="password" style="color: white;">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukan Password"
                            required>
                    </div>
                    <div class="flex justify-center mt-5">
                        <button type="submit" class="px-4 py-2 btn btn-warning font-bold">Login</button>
                    </div>
                </form>
                @if (session('gagal'))
                    <div class="alert alert-danger mt-3">
                        {{ session('gagal') }}
                    </div>
                @endif
            </div>
        </div>

</x-layout>
