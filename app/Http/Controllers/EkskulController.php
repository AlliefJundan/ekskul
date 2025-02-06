<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekskul;

class EkskulController extends Controller
{
    public function dashboard_admin()
    {
        $ekskuls = Ekskul::with(['pembina', 'ketua', 'sekertaris', 'bendahara'])->get();

        return view('dashboard_admin', compact('ekskuls'));
    }


    public function show($nama_ekskul)
    {
        $ekskul = Ekskul::whereRaw("REPLACE(nama_ekskul, ' ', '-') = ?", [$nama_ekskul])->firstOrFail();

        return view('ekskul', compact('ekskul'));
    }
}
