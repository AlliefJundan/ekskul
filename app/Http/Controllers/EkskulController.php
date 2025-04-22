<?php

namespace App\Http\Controllers;

use App\Models\Kuis;
use App\Models\User;
use App\Models\Ekskul;
use App\Models\Materi;
use App\Models\Kegiatan;
use App\Models\HasilKuis;
use App\Models\EkskulUser;
use App\Models\Notifikasi;
use App\Models\Pendaftaran;
use Illuminate\Support\Str;
use App\Models\GambarEkskul;
use App\Models\NotifikasiTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EkskulController extends Controller
{


    public function index()
    {
        $ekskuls = Ekskul::all()->where('deleted', false);
        return view('home', compact('ekskuls'));
    }

    public function galeri()
    {
        $ekskuls = Ekskul::all()->where("deleted", false);
        return view('ekskuls', compact('ekskuls'));
    }

    public function show(Request $request, $slug)
    {
        $ekskul = Ekskul::where('slug', $slug)
            ->with([
                'pembina.user' => function ($query) {
                    $query->where('deleted', false);
                },
                'ketua.user' => function ($query) {
                    $query->where('deleted', false);
                },
                'sekertaris.user' => function ($query) {
                    $query->where('deleted', false);
                },
                'bendahara.user' => function ($query) {
                    $query->where('deleted', false);
                },
            ])
            ->firstOrFail();

        $materi = Materi::where('id_ekskul', $ekskul->id_ekskul)
            ->orderBy('id_materi', 'desc')
            ->paginate(7);

        $user = auth()->user();

        $isNotAdmin = User::where('id_user', $user->id_user)
            ->where('role', '!=', 'admin')
            ->where('deleted', false) // Pastikan user aktif
            ->exists();

        $jabatanUser = auth()->user()->ekskulUser()
            ->where('ekskul_id', $ekskul->id_ekskul)
            ->first()?->jabatan;

        $hasNullJabatan = EkskulUser::where('ekskul_id', $ekskul->id_ekskul)
            ->where('user_id', $user->id_user)
            ->whereNull('jabatan')
            ->first();

        $tanpaJabatan = $isNotAdmin && $hasNullJabatan;

        return view('ekskul', compact('ekskul', 'materi', 'tanpaJabatan', 'user', 'jabatanUser'));
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
        $ekskul->slug = Str::slug($request->nama_ekskul);
        $ekskul->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('ekskul_images', 'public');
            $ekskul->gambar = $path;
        }

        $ekskul->save();

        // Redirect berdasarkan slug
        return redirect()->route('ekskul.show', $ekskul->slug)->with('success', 'Ekskul berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $ekskul = Ekskul::findOrFail($id);


        $ekskul->deleted = true;
        $ekskul->save();
        return redirect()->route('dashboard_admin')->with('success', 'Ekskul berhasil dihapus!');
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
    public function hapusGambar(Request $request, $id)
    {
        $gambar = GambarEkskul::find($request->gambar_id);
        if ($gambar) {
            Storage::delete('public/' . $gambar->gambar);
            $gambar->delete();
            return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
        }
        return redirect()->back()->with('error', 'Gambar tidak ditemukan.');
    }
}
