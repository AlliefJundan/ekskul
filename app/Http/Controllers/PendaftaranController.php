<?php

namespace App\Http\Controllers;

use App\Models\Ekskul;
use App\Models\EkskulUser;
use App\Models\Notifikasi;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Models\NotifikasiTarget;

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

        $existing2 = EkskulUser::where('user_id', $request->id_user)
            ->where('ekskul_id', $request->id_ekskul)
            ->first();


        if ($existing || $existing2) {
            return redirect()->back()->with('error', 'Kamu sudah mendaftar ekskul ini!');
        }

        // Simpan data pendaftaran
        Pendaftaran::create([
            'id_ekskul' => $request->id_ekskul,
            'id_user' => $request->id_user,
            'status' => 'pending',
        ]);

        Notifikasi::create([
            'title' => 'Pendaftaran anggota baru',
            'category' => 'Pendaftaran',
            'id_ekskul' => $request->id_ekskul,
            'description' => 'Materi baru telah ditambahkan',
        ]);

        $users = EkskulUser::where('ekskul_id', $request->id_ekskul)
            ->whereIn('jabatan', [1, 2]) // Memfilter id_jabatan 1 atau 2
            ->pluck('user_id');
        $id_notifikasi = Notifikasi::orderByDesc('id_notifikasi')->first()->id_notifikasi;

        foreach ($users as $user_id) {
            $baru =   NotifikasiTarget::create([
                'id_notifikasi' => $id_notifikasi,
                'id_user' => $user_id,
            ]);
        }

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
            'id_ekskul' => 'required|integer|exists:ekskul,id_ekskul',
            'id_user' => 'required|integer|exists:users,id_user',
        ]);
        $pendaftaran = Pendaftaran::findOrFail($request->id_pendaftaran);
        $pendaftaran->status = 'diterima';
        $pendaftaran->save();

        $user = Pendaftaran::findOrFail($request->id_pendaftaran)->id_user;
        $ekskul = Pendaftaran::findOrFail($request->id_pendaftaran)->id_ekskul;

        $ekskul = EkskulUser::create([
            'user_id' => $user,
            'ekskul_id' => $ekskul,
            'jabatan' => null,
        ]);

        Notifikasi::create([
            'title' => 'Pendaftaran diterima',
            'category' => 'Pendaftaran',
            'id_ekskul' => $request->id_ekskul,
            'id_user' => $request->id_user,
            'description' => 'Permohonan daftar anda diterima',
        ]);

        $id_notifikasi = Notifikasi::orderByDesc('id_notifikasi')->first()->id_notifikasi;

        NotifikasiTarget::create([
            'id_notifikasi' => $id_notifikasi,
            'id_user' => $request->id_user,
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil diterima');
    }

    public function tolak(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|integer|exists:pendaftaran,id_pendaftaran',
            'id_ekskul' => 'required|integer|exists:ekskul,id_ekskul',
            'id_user' => 'required|integer|exists:users,id_user',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($request->id_pendaftaran);
        $pendaftaran->status = 'ditolak';
        $pendaftaran->save();

        Notifikasi::create([
            'title' => 'Pendaftaran ditolak',
            'category' => 'Pendaftaran',
            'id_ekskul' => $request->id_ekskul,
            'id_user' => $request->id_user,
            'description' => 'Permohonan daftar anda ditolak',
        ]);

        $id_notifikasi = Notifikasi::orderByDesc('id_notifikasi')->first()->id_notifikasi;

        NotifikasiTarget::create([
            'id_notifikasi' => $id_notifikasi,
            'id_user' => $request->id_user,
        ]);


        return redirect()->back()->with('success', 'Pendaftaran berhasil ditolak');
    }
}
