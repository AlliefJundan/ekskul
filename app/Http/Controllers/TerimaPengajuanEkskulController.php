<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekskul;
use App\Models\EkskulUser;
use App\Models\User;

class TerimaPengajuanEkskulController extends Controller
{
    /**
     * Tampilkan halaman daftar pengajuan ekskul.
     */
    public function index()
    {
        // Mengambil user yang memiliki pengajuan ekskul dengan status pending
        $pengajuanEkskul = User::whereHas('ekskulPengajuan')->with('ekskulPengajuan')->get();
    
        return view('terima_pengajuan_ekskul', compact('pengajuanEkskul'));
    }

    /**
     * Terima pengajuan ekskul.
     */
    public function terima($userId, $ekskulId)
    {
        $ekskul = EkskulUser::where('user_id', $userId)->firstOrFail()
            ->where('ekskul_id', $ekskulId)->firstOrFail()
            ->update(['status' => 'diterima']);

        return redirect()->route('terimaPengajuanEkskul')->with('success', 'Pengajuan ekskul diterima.');
    }

    /**
     * Tolak pengajuan ekskul.
     */
    public function tolak($userId, $ekskulId)
    {
        $ekskul = EkskulUser::where('user_id', $userId)->firstOrFail()
            ->where('ekskul_id', $ekskulId)->firstOrFail()
            ->update(['status' => 'ditolak']);

        return redirect()->route('terimaPengajuanEkskul')->with('success', 'Pengajuan ekskul ditolak.');
    }
}
