<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Ekskul;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index(Request $request, $slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();
        $user = Auth::user();
        $tanggal = $request->input('tanggal', now()->toDateString()); // Ambil tanggal dari input, default ke hari ini

        // Jika admin atau user dengan jabatan 2, bisa melihat semua absensi di ekskul dengan filter tanggal
        if ($user->role === 'admin' || optional($user->ekskulUser)->jabatan == 2) {
            $absensi = Absensi::where('id_ekskul', $ekskul->id_ekskul)
                ->whereDate('tanggal', $tanggal)
                ->with('user')
                ->orderBy('tanggal', 'desc')
                ->get();
        }
        // Jika user biasa, hanya bisa melihat absensinya sendiri
        else {
            $absensi = Absensi::where('id_user', $user->id_user)
                ->where('id_ekskul', $ekskul->id_ekskul)
                ->whereDate('tanggal', $tanggal)
                ->with('user')
                ->orderBy('tanggal', 'desc')
                ->get();
        }

        $count = [
            'Hadir' => $absensi->where('kehadiran', 'hadir')->count(),
            'Izin' => $absensi->where('kehadiran', 'izin')->count(),
            'Sakit' => $absensi->where('kehadiran', 'sakit')->count(),
            'Alfa' => $absensi->where('kehadiran', 'alpa')->count(),
        ];

        return view('absensi', compact('absensi', 'count', 'ekskul'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'id_ekskul' => 'required|exists:ekskul,id_ekskul',
            'kehadiran' => 'required|in:hadir,izin,sakit,alpa',
        ]);

        $today = now()->toDateString();

        // Cek apakah user sudah absen hari ini di ekskul yang sama
        $existingAbsensi = Absensi::where('id_user', $request->id_user)
            ->where('id_ekskul', $request->id_ekskul)
            ->where('tanggal', $today)
            ->first();

        if ($existingAbsensi) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absensi hari ini!');
        }

        // Simpan absensi jika belum ada
        Absensi::create([
            'id_ekskul' => $request->id_ekskul,
            'id_user' => $request->id_user,
            'tanggal' => $today,
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
    public function verifikasi($id_absensi)
    {
        $absensi = Absensi::findOrFail($id_absensi);
        $user = Auth::user();

        // Pastikan hanya admin atau user dengan jabatan 2 di ekskul tersebut yang bisa verifikasi
        if ($user->role !== 'admin' && optional($user->ekskulUser)->jabatan != 2) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk verifikasi absensi.');
        }

        $absensi->status = 'terverifikasi';
        $absensi->save();

        return redirect()->back()->with('success', 'Absensi berhasil diverifikasi.');
    }

}
