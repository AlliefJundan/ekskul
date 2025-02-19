<?php

namespace App\Http\Controllers;


use App\Models\Ekskul;
use App\Models\EkskulUser;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function sasda($slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();
        $anggota = EkskulUser::where('ekskul_id', $ekskul->id_ekskul)->get();

        return view('anggota', compact('ekskul', 'anggota', 'jabatan'));
    }

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
}
