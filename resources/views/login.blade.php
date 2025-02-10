<x-layout>
    <div class="flex items-start justify-center min-h-screen pt-16 bg-white">
        <div class="bg-[#0B0022] p-16 rounded-lg shadow-md w-[500px]">
            <h2 class="text-2xl font-bold text-center text-white">LOGIN</h2>
            <div class="mt-3">
                <form action="{{ route('login.submit') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1"
                            style="color: white; font-bold:'Times New Roman';">Username</label>
                        <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="Masukan Username">
                    </div>

                    <div class="mt-5 form-group">
                        <label for="exampleInputPassword1"
                            style="color: white; font-bold:'Times New Roman';">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                            placeholder="Masukan Password">
                    </div>
                    <div class="flex justify-center mt-5">
                        <button type="submit" class="px-4 py-2 btn btn-warning">Submit</button>
                    </div>

                </form>
                @if (session('gagal'))
                    <p class="text-danger">{{ session('gagal') }}</p>
                @endif
            </div>
        </div>

</x-layout>
