<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekskul;
use App\Models\Materi;

class HalamanEkskulController extends Controller
{
    public function show($slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();

        // Ambil materi terbaru berdasarkan ekskul
        $materiTerbaru = Materi::where('id_ekskul', $ekskul->id_ekskul)
            ->orderBy('id_materi', 'desc')
            ->first();

        return view('ekskul', compact('ekskul', 'materiTerbaru'));
    }
}
