<?php

namespace App\Http\Controllers;

use App\Models\Kuis;
use App\Models\Ekskul;
use App\Models\HasilKuis;
use App\Models\EkskulUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Notifikasi;
use App\Models\NotifikasiTarget;

class KuisController extends Controller
{
    public function show(Request $request, $slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();
        $search = $request->input('search');
        $user = auth()->user();

        $kuis = Kuis::where('id_ekskul', $ekskul->id_ekskul)
            ->when($search, function ($query, $search) {
                return $query->where('slug', 'like', "%$search%");
            })
            ->orderBy('id_kuis', 'desc')
            ->paginate(10);

        // Ambil daftar hasil kuis yang sudah dikirim oleh user
        $hasilKuis = HasilKuis::where('id_user', $user->id_user)->where('status', '!=', 'ditolak')
            ->pluck('id_kuis')
            ->toArray();

        return view('kuis', compact('ekskul', 'user', 'kuis', 'search', 'hasilKuis'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_kuis' => 'required|string|max:255',
            'isi_kuis' => 'required|string',
            'id_ekskul' => 'required|exists:ekskul,id_ekskul'
        ]);

        $slug = Str::slug($request->nama_kuis) . '-' . now()->format('Y-d-M-His');

        Kuis::create([
            'nama_kuis' => $request->nama_kuis,
            'slug' => $slug,
            'isi_kuis' => $request->isi_kuis,
            'id_ekskul' => $request->id_ekskul,
        ]);

        Notifikasi::create([
            'title' => 'Kuis Baru',
            'category' => 'Kuis',
            'id_ekskul' => $request->id_ekskul,
            'description' => 'Kuis baru telah ditambahkan',
        ]);

        $id_notifikasi = Notifikasi::latest()->first()->id_notifikasi;

        // Cari user yang ikut ekskul dan belum dihapus
        $ekskulUsers = EkskulUser::where('ekskul_id', $request->id_ekskul)
            ->join('users', 'ekskul_user.user_id', '=', 'users.id_user')
            ->where('users.deleted', false)
            ->pluck('user_id');

        foreach ($ekskulUsers as $user_id) {
            NotifikasiTarget::create([
                'id_notifikasi' => $id_notifikasi,
                'id_user' => $user_id,
            ]);
        }

        return redirect()->route('kuis.show', Ekskul::find($request->id_ekskul)->slug)
            ->with('success', 'Kuis berhasil ditambahkan.');
    }




    public function hasil(Request $request)
    {

        $request->validate([
            'id_kuis' => 'required|exists:kuis,id_kuis',
            'id_user' => 'integer',
            'skor' => 'required|integer',
            'bukti' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            'id_ekskul' => 'required|exists:ekskul,id_ekskul',
        ]);



        $hasil =  HasilKuis::create([
            'id_kuis' => $request->id_kuis,
            'id_user' => $request->id_user,
            'id_ekskul' => $request->id_ekskul,
            'skor' => $request->skor,
            'bukti' => $request->file('bukti')->store('bukti_kuis', 'public'),
            'status' => 'pending',
        ]);

        if ($hasil) {
            return redirect()->back()
                ->with('success', 'Hasil berhasil ditambahkan.');
        } else {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan hasil kuis.');
        }
    }

    public function hasilKuis(Request $request, $slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();
        $search = $request->input('search');
        $kuis = Kuis::where('id_ekskul', $ekskul->id_ekskul)
            ->when($search, function ($query, $search) {
                return $query->where('nama_kuis', 'like', "%$search%");
            })
            ->orderBy('id_kuis', 'desc')
            ->paginate(10);

        return view('hasilKuis', compact('ekskul', 'kuis', 'search',));
    }
}
