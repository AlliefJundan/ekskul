<?php

namespace App\Http\Controllers;

use App\Models\Kuis;
use App\Models\Ekskul;
use App\Models\HasilKuis;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Models\NotifikasiTarget;

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
        $hasil_kuis = HasilKuis::where('id_kuis', $kuis->id_kuis)
            ->whereHas('user', function ($query) {
                $query->where('deleted', false);
            })->get();

        return view('hasil_kuis', compact('kuis', 'ekskul', 'hasil_kuis'));
    }
    public function terima($id)
    {
        $hasil = HasilKuis::findOrFail($id);
        $hasil->status = 'diterima';
        $hasil->save();

        return back()->with('success', 'Hasil kuis diterima.');
    }

    public function tolak($id)
    {
        $hasil = HasilKuis::findOrFail($id);
        $hasil->status = 'ditolak';
        $hasil->save();

        Notifikasi::create([
            'title' => 'Hasil Kuis Ditolak',
            'category' => 'Kuis',
            'id_ekskul' => $hasil->id_ekskul,
            'description' => 'Hasil kuis yang anda kirim telah ditolak',
        ])->save();

        $id_notifikasi = Notifikasi::latest()->first()->id_notifikasi;
        NotifikasiTarget::create([
            'id_notifikasi' => $id_notifikasi,
            'id_user' => $hasil->id_user,
        ])->save();

        return back()->with('success', 'Hasil kuis ditolak.');
    }
}
