<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekskul;
use Illuminate\Support\Str;
use App\Models\Jabatan;

class EkskulController extends Controller
{
    public function dashboard_admin()
    {
        $ekskuls = Ekskul::with(['pembina.user', 'ketua.user', 'sekertaris.user', 'bendahara.user'])->get();

        return view('dashboard_admin', compact('ekskuls'));
    }

    public function index()
    {
        $ekskuls = Ekskul::all(); // Mengambil semua data ekskul dari database
        return view('home', compact('ekskuls')); // Mengirimkan data ke view
    }

    public function show($slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();

        return view('ekskul.ekskul', compact('ekskul'));
    }


    public function store(Request $request)
    {

        // dd($request->all());
        // Validasi input
        $request->validate([
            'nama_ekskul' => 'required|string|max:255',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'deskripsi' => 'nullable|string',
            'id_pembina' => 'nullable|integer|exists:jabatan,id_jabatan',
            'id_ketua' => 'nullable|integer|exists:jabatan,id_jabatan',
            'id_sekertaris' => 'nullable|integer|exists:jabatan,id_jabatan',
            'id_bendahara' => 'nullable|integer|exists:jabatan,id_jabatan',
            'jml_anggota' => 'required|integer|min:1',
        ]);

        // Simpan gambar
        $image = $request->file('image'); // Pastikan nama input sesuai

        // Simpan ke database
        $ekskul = Ekskul::create([
            'nama_ekskul' => $request->nama_ekskul,
            'gambar' =>
            $request->file('image')->store('pp_ekskul', 'public'),
            'deskripsi' => $request->deskripsi,
            'slug' => Str::slug($request->nama_ekskul),
            'id_pembina' => $request->id_pembina ?? null,
            'id_ketua' => $request->id_ketua ?? null,
            'id_sekertaris' => $request->id_sekertaris ?? null,
            'id_bendahara' => $request->id_bendahara ?? null,
            'jml_anggota' => $request->jml_anggota,
        ]);

        return redirect()->back()->with('success', 'Ekskul berhasil ditambahkan!');
    }
}
