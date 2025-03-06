<?php

namespace App\Http\Controllers;

use App\Models\Ekskul;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        $ekskuls = Ekskul::with(['pembina.user', 'ketua.user'])->withCount('users')->get();
        return view('home', compact('ekskuls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|integer|exists:users,id_user',
            'id_ekskul' => 'required|integer|exists:ekskul,id_ekskul',
        ]);

        // Cek apakah user sudah mendaftar ekskul yang sama sebelumnya
        $existing = Pendaftaran::where('id_user', $request->id_user)
            ->where('id_ekskul', $request->id_ekskul)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Kamu sudah mendaftar ekskul ini!');
        }

        // Simpan data pendaftaran
        Pendaftaran::create([
            'id_ekskul' => $request->id_ekskul,
            'id_user' => $request->id_user,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Permintaanmu sedang diproses');
    }

    public function show($slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();
        $pendaftaran = Pendaftaran::where('id_ekskul', $ekskul->id_ekskul)
            ->where('status', 'pending')
            ->with('user')
            ->get();

        return view('pendaftaran', compact('ekskul', 'pendaftaran'));
    }

    public function terima(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|integer|exists:pendaftaran,id_pendaftaran',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($request->id_pendaftaran);
        $pendaftaran->status = 'diterima';
        $pendaftaran->save();


        return redirect()->back()->with('success', 'Pendaftaran berhasil diterima');
    }
}
