<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::where('id_ekskul', Auth::user()->id_ekskul)
            ->orderBy('tanggal', 'desc')
            ->get();

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
            'id_user' => 'required|exists:users,id_user',
            'id_ekskul' => 'required|exists:ekskul,id_ekskul',
            'kehadiran' => 'required|in:hadir,izin,sakit,alpa',
        ]);

        // Simpan data ke database
        Absensi::create([
            'id_ekskul' => $request->id_ekskul,
            'id_user' => $request->id_user,
            'tanggal' => now()->toDateString(),
            'kehadiran' => $request->kehadiran,
            'status' => 'belum terverifikasi',
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil ditambahkan');
    }


    public function testInsert()
    {
        // Buat data dummy dan simpan ke database
        $absensi = Absensi::create([
            'id_ekskul' => 1, // Sesuaikan dengan ekskul yang ada
            'id_user' => 1, // Sesuaikan dengan user yang ada
            'tanggal' => now()->toDateString(),
            'kehadiran' => 'hadir',
            'status' => 'belum terverifikasi',
        ]);

        // Cek apakah data berhasil masuk ke database
        if ($absensi) {
            return response()->json([
                'message' => 'Data berhasil dimasukkan!',
                'data' => $absensi
            ], 200);
        } else {
            return response()->json([
                'message' => 'Gagal memasukkan data!'
            ], 500);
        }
    }
}
