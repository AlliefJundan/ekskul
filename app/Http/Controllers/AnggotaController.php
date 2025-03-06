<?php

namespace App\Http\Controllers;


use App\Models\Ekskul;
use App\Models\EkskulUser;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function show($slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();
        $anggota = $ekskul->users()
            ->with(['kelas']) // Load relasi kelas langsung
            ->withPivot('jabatan')
            ->orderByRaw('CASE 
        WHEN ekskul_user.jabatan IS NULL THEN 2 
        ELSE 1 
    END, ekskul_user.jabatan ASC')
            ->get();
        return view('anggota', compact('ekskul', 'anggota'));
    }


    public function jabatanShow($slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();
        $anggota = $ekskul->users()->withPivot('jabatan')->get();
        return view('jabatan', compact('ekskul', 'anggota'));
    }

    public function jabatanUpdate(Request $request, $slug)
    {
        // Find the 'ekskul' by slug
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();

        // Validate the request to ensure that the jabatan_id and nama_baru are provided
        $request->validate([
            'jabatan_id' => 'required|integer',
            'nama_baru' => 'required|exists:users,id_user', // Check if the new user exists
        ]);

        // Find the old pemegang jabatan by jabatan_id
        $oldPemegangJabatan = EkskulUser::where('ekskul_id', $ekskul->id_ekskul)
            ->where('jabatan', $request->jabatan_id)
            ->first();

        if ($oldPemegangJabatan) {
            // Update the old pemegang jabatan to '5' (members)
            $oldPemegangJabatan->update([
                'jabatan' => null, // Assuming jabatan '5' is for members
            ]);
        }

        // Find the new pemegang jabatan by user_id
        $newPemegangJabatan = EkskulUser::where('ekskul_id', $ekskul->id_ekskul)
            ->where('user_id', $request->nama_baru)
            ->first();

        if ($newPemegangJabatan) {
            // Update the new pemegang jabatan with the correct jabatan
            $newPemegangJabatan->update([
                'jabatan' => $request->jabatan_id,
            ]);
        }

        return redirect()->route('jabatan.jabatanShow', $ekskul->slug)
            ->with('success', 'Pemegang jabatan berhasil diubah!');
    }

    public function jabatanRemove(Request $request, $slug)
    {
        // Find the 'ekskul' by slug
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();

        // Validate the request to ensure jabatan_id is provided
        $request->validate([
            'jabatan_id' => 'required|integer',
        ]);

        // Find the current pemegang jabatan
        $pemegangJabatan = EkskulUser::where('ekskul_id', $ekskul->id_ekskul)
            ->where('jabatan', $request->jabatan_id)
            ->firstOrFail();

        // Update the pemegang jabatan to 'Anggota' (jabatan = 5)
        $pemegangJabatan->update([
            'jabatan' => null, // Assuming jabatan '5' is for members
        ]);

        return redirect()->route('jabatan.jabatanShow', $ekskul->slug)
            ->with('success', 'Jabatan berhasil dilepas!');
    }

    public function keluarkanAnggota(Request $request)
    {
        $user = auth()->user();
        // Ambil data anggota yang ingin dikeluarkan
        $request->validate([
            'user_id' => 'required|integer|exists:users,id_user',
            'ekskul_id' => 'required|integer|exists:ekskul,id_ekskul',
        ]);

        $anggota = EkskulUser::where('user_id', $request->user_id)
            ->where('ekskul_id', $request->ekskul_id) // Hanya di ekskul terkait
            ->first();

        $keluar = Pendaftaran::where('id_user', $request->user_id)
            ->where('id_ekskul', $request->ekskul_id)
            ->where('status', 'diterima')
            ->first();

        if (!$anggota) {
            return redirect()->back()->with('error', 'Anggota tidak ditemukan.');
        }

        // Dapatkan jabatan pengguna yang sedang login
        $userJabatan = optional($user->ekskulUser)->jabatan;
        $userRole = $user->role;

        // Cek apakah pengguna memiliki hak untuk mengeluarkan anggota
        $targetJabatan = $anggota->jabatan;
        $canKick = false;

        if ($userRole == 'admin') {
            $canKick = true; // Admin bisa mengeluarkan siapa saja
        } elseif ($userJabatan == 1 && $targetJabatan !== 1) {
            $canKick = true; // Pembina bisa mengeluarkan Ketua dan di bawahnya, tapi tidak sesama Pembina
        } elseif ($userJabatan == 2 && $targetJabatan !== 1 && $targetJabatan !== 2) {
            $canKick = true; // Ketua hanya bisa mengeluarkan Sekretaris, Bendahara, dan Anggota
        }

        if (!$canKick) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengeluarkan anggota ini.');
        }

        if (!$anggota) {
            return redirect()->back()->with('error', 'Anggota tidak ditemukan di ekskul ini.');
        }

        $anggota->delete();
        $keluar->status = 'dikeluarkan';
        $keluar->save();

        return redirect()->back()->with('success', 'Anggota berhasil dikeluarkan.');
    }
}
