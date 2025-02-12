<?php

// app/Http/Controllers/AbsensiController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::where('id_ekskul', Auth::user()->id_ekskul)->get();

        $count = [
            'Hadir' => $absensi->where('kehadiran', 'hadir')->count(),
            'Izin' => $absensi->where('kehadiran', 'izin')->count(),
            'Sakit' => $absensi->where('kehadiran', 'sakit')->count(),
            'Alfa' => $absensi->where('kehadiran', 'alpa')->count(),
        ];

        return view('absensi', compact('absensi', 'count'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ekskul' => 'required|exists:ekskul,id_ekskul',
            'kehadiran' => 'required|in:hadir,izin,sakit,alpa',
            'status' => 'required|in:terverifikasi,belum terverifikasi',
        ]);

        // Cek apakah sudah absen hari ini
        $alreadyExists = Absensi::where('id_user', Auth::id())
            ->whereDate('tanggal', now()->toDateString())
            ->exists();

        if ($alreadyExists) {
            return redirect()->back()->with('error', 'Anda sudah absen hari ini!');
        }

        Absensi::create([
            'id_ekskul' => $request->id_ekskul,
            'id_user' => Auth::id(),
            'tanggal' => now(),
            'kehadiran' => $request->kehadiran,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil ditambahkan');
    }
}
