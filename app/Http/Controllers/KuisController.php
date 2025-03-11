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

        $kuis = Kuis::where('id_ekskul', $ekskul->id_ekskul)
            ->when($search, function ($query, $search) {
                return $query->where('nama_kuis', 'like', "%$search%");
            })
            ->orderBy('id_kuis', 'desc')
            ->paginate(10);

        // Cek apakah user sudah mengirim hasil untuk setiap kuis
        $userId = auth()->id();
        $hasil_kuis_user = HasilKuis::where('id_user', $userId)->pluck('id_kuis')->toArray();

        return view('kuis', compact('ekskul', 'kuis', 'search', 'hasil_kuis_user'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_kuis' => 'required|string|max:255',
            'isi_kuis' => 'required|string',
            'id_ekskul' => 'required|exists:ekskul,id_ekskul'
        ]);

        $slug = Str::slug($request->nama_kuis) . '-' . now(); // Bikin slug unik

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

        $ekskul = EkskulUser::where('ekskul_id', $request->id_ekskul)->pluck('user_id');
        $id_notifikasi = Notifikasi::latest()->first()->id_notifikasi;

        foreach ($ekskul as $user_id) {
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


        // Debugging

        HasilKuis::create([
            'id_kuis' => $request->id_kuis,
            'id_user' => $request->id_user,
            'id_ekskul' => $request->id_ekskul,
            'skor' => $request->skor,
            'bukti' => $request->file('bukti')->store('bukti_kuis', 'public'),
        ]);

        return redirect()->route('kuis.show', Ekskul::find($request->id_ekskul)->slug)
            ->with('success', 'Kuis berhasil ditambahkan.');
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
