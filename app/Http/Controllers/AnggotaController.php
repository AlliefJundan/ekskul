<?php

namespace App\Http\Controllers;


use App\Models\Ekskul;
use App\Models\EkskulUser;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function show($slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();
        $anggota = $ekskul->users()->withPivot('jabatan')->get();
        $jabatan = EkskulUser::where('jabatan')->get()
            ->sortByDesc('jabatan');
        return view('anggota', compact('ekskul', 'anggota', 'jabatan'));
    }
    public function jabatanShow($slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();
        $anggota = $ekskul->users()->withPivot('jabatan')->get();
        $jabatan = EkskulUser::where('jabatan')->get()
            ->sortByDesc('jabatan');
        return view('jabatan', compact('ekskul', 'anggota', 'jabatan'));
    }

    public function jabatanUpdate(Request $request, $slug)
    {

        $request->validate([
            'jabatan' => 'required|string|max:255',
            'nama' => 'required|string|max:255|unique:users',
            'nama_baru' => 'required|string|min:6',
        ]);
    }
    
}
