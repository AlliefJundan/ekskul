<?php

namespace App\Http\Controllers;

use App\Models\EkskulUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {

        // Mengambil data pengguna yang sedang login
        $user = auth()->user();
        $ekskul = EkskulUser::where('user_id', $user->id_user)->get();
        return view('profil', compact('user', 'ekskul'));
    }

    public function password(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'password_sekarang' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!password_verify($request->password_sekarang, $user->password)) {
            return back()->with('error', 'Password saat ini salah.');
        }

        if ($request->password_sekarang === $request->password) {
            return back()->with('error', 'Password baru tidak boleh sama dengan password lama.');
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('profil.index')->with('success', 'Password berhasil diperbarui.');
    }


    public function foto(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Menghapus foto lama jika ada
        if ($user->foto) {
            Storage::delete($user->foto);
        }

        // Menyimpan foto baru
        $path = $request->file('foto')->store('pp_akun', 'public');
        $user->update([
            'foto' => $path,
        ]);


        return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
