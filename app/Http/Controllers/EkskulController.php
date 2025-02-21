<?php

namespace App\Http\Controllers;

use App\Models\Ekskul;
use App\Models\Materi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

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

    public function show(Request $request, $slug)
    {
        $ekskul = Ekskul::where('slug', $slug)
            ->with(['pembina.user', 'ketua.user', 'sekertaris.user', 'bendahara.user'])
            ->firstOrFail();

        $materi = Materi::where('id_ekskul', $ekskul->id_ekskul)
            ->orderBy('id_materi', 'desc')
            ->paginate(7);



        return view('ekskul', compact('ekskul', 'materi'));
    }



    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_ekskul' => 'required|string|max:255',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'deskripsi' => 'nullable|string',
        ]);

        // Simpan ekskul ke database
        Ekskul::create([
            'nama_ekskul' => $request->nama_ekskul,
            'gambar' => $request->file('image')->store('pp_ekskul', 'public'),
            'deskripsi' => $request->deskripsi,
            'slug' => Str::slug($request->nama_ekskul),
        ]);

        return redirect()->back()->with('success', 'Ekskul berhasil ditambahkan!');
    }
    public function updateJumlahAnggota($id)
    {
        $ekskul = Ekskul::findOrFail($id);
        $ekskul->jml_anggota = $ekskul->users()->count();
        $ekskul->save();

        return response()->json(['message' => 'Jumlah anggota diperbarui!']);
    }

}
