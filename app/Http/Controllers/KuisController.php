<?php

namespace App\Http\Controllers;

use App\Models\Kuis;
use App\Models\Ekskul;
use Illuminate\Http\Request;

class KuisController extends Controller
{
    public function show($slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();
        $kuis = Kuis::where('id_ekskul', $ekskul->id)->get();

        return view('kuis', compact('ekskul', 'kuis'));
    }
}
