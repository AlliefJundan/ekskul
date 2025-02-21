<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Ekskul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    /**
     * Menampilkan daftar materi berdasarkan ekskul.
     */
    public function index(Request $request, $slug)
    {
        // Ambil data ekskul berdasarkan slug
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();
        $search = $request->input('search');

        // Ambil data materi berdasarkan ekskul dan pencarian
        $materi = Materi::where('id_ekskul', $ekskul->id_ekskul)
            ->when($search, function ($query, $search) {
                return $query->where('isi_materi', 'like', "%$search%");
            })
            ->orderBy('id_materi', 'desc')
            ->paginate(10);

        return view('materi', compact('ekskul', 'materi', 'search'));
    }

    /**
     * Menyimpan materi baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'isi_materi' => 'required|string',
            'lampiran_materi' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
            'id_ekskul' => 'required|exists:ekskul,id_ekskul',
            'id_user' => 'required|exists:users,id_user'
        ]);

        // Cek ekskul berdasarkan ID
        $ekskul = Ekskul::findOrFail($request->id_ekskul);

        // Simpan file jika ada
        $filePath = null;
        if ($request->hasFile('lampiran_materi')) {
            $filePath = $request->file('lampiran_materi')->store('materi_files', 'public');
        }

        // Simpan data ke database
        Materi::create([
            'isi_materi' => $request->isi_materi,
            'lampiran_materi' => $filePath,
            'id_ekskul' => $request->id_ekskul,
            'id_user' => $request->id_user,
        ]);

        // Redirect ke halaman materi dengan slug ekskul yang benar
        return redirect()->route('materi.index', ['slug' => $ekskul->slug])
            ->with('success', 'Materi berhasil ditambahkan.');
    }
    public function download($id)
    {
        // Gunakan id_materi karena kolom primary key-nya mungkin bukan 'id'
        $materi = Materi::where('id_materi', $id)->firstOrFail();

        if (!$materi->lampiran_materi) {
            return redirect()->back()->with('error', 'Lampiran tidak tersedia.');
        }

        $filePath = storage_path('app/public/' . $materi->lampiran_materi);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath);
    }
}
