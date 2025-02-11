<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Ekskul;

class MateriController extends Controller
{
    public function index()
    {
        $ekskulList = Ekskul::all();
        return view('materi', compact('ekskulList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ekskul' => 'required|exists:ekskul,id_ekskul',
            'isi_materi' => 'required|string',
            'lampiran_materi.*' => 'nullable|file|max:2048'
        ]);

        $lampiranPaths = [];
        if ($request->hasFile('lampiran_materi')) {
            foreach ($request->file('lampiran_materi') as $file) {
                $lampiranPaths[] = $file->store('materi_lampiran', 'public');
            }
        }

        Materi::create([
            'id_ekskul' => $request->id_ekskul,
            'isi_materi' => $request->isi_materi,
            'lampiran_materi' => json_encode($lampiranPaths)
        ]);

        return redirect()->back()->with('success', 'Materi berhasil dikirim!');
    }
}
