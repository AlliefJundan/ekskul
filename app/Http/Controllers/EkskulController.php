<?php

namespace App\Http\Controllers;

use App\Models\Ekskul;
use App\Models\Materi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\GambarEkskul;
class EkskulController extends Controller
{


    public function index()
    {
        $ekskuls = Ekskul::all();
        return view('home', compact('ekskuls'));
    }

    public function galeri()
    {
        $ekskuls = Ekskul::all();
        return view('ekskuls', compact('ekskuls'));
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ekskul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $ekskul = Ekskul::findOrFail($id);
        $ekskul->nama_ekskul = $request->nama_ekskul;
        $ekskul->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('pp_ekskul ', 'public');
            $ekskul->gambar = $path;
        }

        $ekskul->save();
        return redirect()->back()->with('success', 'Ekskul berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Ekskul::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Ekskul berhasil dihapus!');
    }

    public function updateJumlahAnggota($id)
    {
        $ekskul = Ekskul::findOrFail($id);
        $ekskul->jml_anggota = $ekskul->users()->count();
        $ekskul->save();

        return response()->json(['message' => 'Jumlah anggota diperbarui!']);
    }
    public function tambahGambar(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $ekskul = Ekskul::findOrFail($id);
        $path = $request->file('image')->store('ekskul_images', 'public');

        GambarEkskul::create([
            'ekskul_id' => $ekskul->id_ekskul,
            'gambar' => $path,
        ]);

        return redirect()->back()->with('success', 'Gambar berhasil ditambahkan!');
    }
}
