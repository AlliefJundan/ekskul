<?php

namespace App\Http\Controllers;

use App\Models\Kuis;
use App\Models\Ekskul;
use Illuminate\Http\Request;

class KuisController extends Controller
{
    public function show(Request $request, $slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();

        // Ambil keyword dari input pencarian
        $search = $request->input('search');

        // Jika ada keyword pencarian, filter berdasarkan nama kuis
        $kuis = Kuis::where('id_ekskul', $ekskul->id_ekskul)
            ->when($search, function ($query, $search) {
                return $query->where('nama_kuis', 'like', "%$search%");
            })
            ->paginate(10);

        return view('kuis', compact('ekskul', 'kuis', 'search'));
    }



    public function ikuti($id_kuis)
    {
        $isi = Kuis::where('id_kuis', $id_kuis->isi_kuis)->firstOrFail();

        return view('kuis', compact('isi'));
    }
}
