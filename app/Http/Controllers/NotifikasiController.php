<?php

namespace App\Http\Controllers;


use App\Models\NotifikasiTarget;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifikasi = NotifikasiTarget::where('id_user', $user->id_user)
            ->with(['notifikasi.ekskul'])
            ->get();

        return view('notifikasi', compact('notifikasi'));
    }

    public function read(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'id_notifikasi' => 'required|exists:notifikasi_target,id_notifikasi',
        ]);

        // Cari notifikasi berdasarkan id_notifikasi & id_user
        $notifikasi = NotifikasiTarget::where('id_notifikasi', $request->id_notifikasi)
            ->where('id_user', $user->id_user)
            ->first();

        if ($notifikasi) {
            $notifikasi->update(['is_read' => true]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function readAll()
    {
        $user = auth()->user();

        $notifikasi = NotifikasiTarget::where('id_user', $user->id_user)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Berhasil membaca semua notifikasi');
    }
}
