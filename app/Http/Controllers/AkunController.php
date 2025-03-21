<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AkunController extends Controller
{

    public function index(Request $request)
    {
        $query = User::query(); // Ambil semua user

        // Cek apakah ada parameter pencarian
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nama', 'like', "%$search%")
                ->orWhere('username', 'like', "%$search%");
        }

        $akun = $query->paginate(10)->appends($request->query()); // Pastikan paginasi tetap menyimpan query pencarian

        return view('akun', compact('akun'));
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

    public function update(Request $request, $id_user)
    {
        $akun = User::findOrFail($id_user);

        // Validasi input update
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id_user . ',id_user',
            'password' => 'nullable|string|min:6', // Password boleh kosong (tidak diubah)
            'role' => 'required|string',
        ]);

        // Update data
        $akun->nama = $request->nama;
        $akun->username = $request->username;
        $akun->role = $request->role;

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $akun->password = bcrypt($request->password);
        }

        $akun->save();

        return redirect()->route('akun.index')->with('success', 'Akun berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $akun = User::findOrFail($id);
        $akun->delete();

        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus!');
    }
}
