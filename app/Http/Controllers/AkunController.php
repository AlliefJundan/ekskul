<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AkunController extends Controller
{

    public function index()
    {
        $akun = User::all();
        return view('akun', compact('akun')); // Ubah dari 'akun.index' ke 'akun'
    }

    public function create()
    {
        return view('akun_create'); // Pastikan file 'akun_create.blade.php' ada di resources/views/
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => bcrypt($request->password), // Enkripsi password
            'role' => $request->role,
        ]);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil ditambahkan!');
    }


    public function show($id_user)
    {
        $akun = User::findOrFail($id_user);
        return view('akun.show', compact('akun'));
    }

    public function edit($id_user)
    {
        $akun = User::findOrFail($id_user);
        return view('akun.edit', compact('akun'));
    }

    public function update(Request $request, $id)
    {
        $akun = User::findOrFail($id);
        $akun->update($request->all());

        return redirect()->route('akun.index')->with('success', 'Akun berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $akun = User::findOrFail($id);
        $akun->delete();

        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus!');
    }
}
