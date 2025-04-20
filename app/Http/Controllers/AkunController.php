<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('deleted', false); // Ambil hanya yang belum dihapus

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('username', 'like', "%$search%");
            });
        }

        $akun = $query->paginate(25)->appends($request->query());

        return view('akun', compact('akun'));
    }

    public function create()
    {
        return view('akun_create');
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
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'deleted' => false, // Default akun baru tidak terhapus
        ]);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil ditambahkan!');
    }

    public function show($id_user)
    {
        $akun = User::where('id_user', $id_user)->where('deleted', false)->firstOrFail();
        return view('akun.show', compact('akun'));
    }

    public function edit($id_user)
    {
        $akun = User::where('id_user', $id_user)->where('deleted', false)->firstOrFail();
        return view('akun.edit', compact('akun'));
    }

    public function update(Request $request, $id_user)
    {
        try {
            $akun = User::where('id_user', $id_user)->where('deleted', false)->firstOrFail();

            $request->validate([
                'nama' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $id_user . ',id_user',
                'password' => 'nullable|string|min:6',
                'role' => 'required|string',
            ]);

            $akun->nama = $request->nama;
            $akun->username = $request->username;
            $akun->role = $request->role;

            if ($request->filled('password')) {
                $akun->password = bcrypt($request->password);
            }

            $akun->save();

            return redirect()->route('akun.index')->with('success', 'Akun berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui akun! Pesan error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $akun = User::where('id_user', $id)->where('deleted', false)->firstOrFail();

        // Cek validasi sebelum soft delete
        if ($akun->role == 'admin') {
            return redirect()->route('akun.index')->with('error', 'Akun admin tidak dapat dihapus!');
        }

        if ($akun->id_user == auth()->user()->id_user) {
            return redirect()->route('akun.index')->with('error', 'Akun yang sedang login tidak dapat dihapus!');
        }

        // Soft delete (ubah field `deleted` jadi true)
        $akun->deleted = true;
        $akun->save();

        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus!');
    }
}
