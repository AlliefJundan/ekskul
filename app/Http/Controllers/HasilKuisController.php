<?php

namespace App\Http\Controllers;

use App\Models\Kuis;
use App\Models\Ekskul;
use App\Models\HasilKuis;
use Illuminate\Http\Request;

class HasilKuisController extends Controller
{
    public function show()
    {
        return view('hasil_kuis');
    }

    public function hasil($slug)
    {
        // Cari kuis berdasarkan slug
        $kuis = Kuis::where('slug', $slug)->firstOrFail();

        // Cari ekskul berdasarkan id_ekskul dari kuis
        $ekskul = Ekskul::where('id_ekskul', $kuis->id_ekskul)->firstOrFail();

        // Ambil hasil kuis berdasarkan id_kuis
        $hasil_kuis = HasilKuis::where('id_kuis', $kuis->id_kuis)->get();

        return view('hasil_kuis', compact('kuis', 'ekskul', 'hasil_kuis'));
    }
}
