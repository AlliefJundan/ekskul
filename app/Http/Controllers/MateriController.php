<?php

namespace App\Http\Controllers;

use App\Models\Ekskul;
use App\Models\Materi;
use Mockery\Matcher\Not;
use App\Models\EkskulUser;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Models\NotifikasiTarget;
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

        Notifikasi::create([
            'title' => 'Materi Baru',
            'category' => 'Materi',
            'id_ekskul' => $request->id_ekskul,
            'description' => 'Materi baru telah ditambahkan',
        ]);

        $users = EkskulUser::where('ekskul_id', $request->id_ekskul)
            ->join('users', 'ekskul_user.user_id', '=', 'users.id_user')
            ->where('users.deleted', false)
            ->pluck('user_id');
        $id_notifikasi = Notifikasi::orderByDesc('id_notifikasi')->first()->id_notifikasi;


        foreach ($users as $user_id) {
            NotifikasiTarget::create([
                'id_notifikasi' => $id_notifikasi,
                'id_user' => $user_id,
            ]);
        }

        return redirect()->route('materi.index', ['slug' => $ekskul->slug])
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    /**
     * Mengupdate materi yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'isi_materi' => 'required|string',
            'lampiran_materi' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
        ]);

        $materi = Materi::findOrFail($id);
        $materi->isi_materi = $request->isi_materi;

        // Jika ada file baru, hapus file lama lalu simpan yang baru
        if ($request->hasFile('lampiran_materi')) {
            if ($materi->lampiran_materi) {
                Storage::delete('public/' . $materi->lampiran_materi);
            }

            $filePath = $request->file('lampiran_materi')->store('materi_files', 'public');
            $materi->lampiran_materi = $filePath;
        }

        $materi->save();

        return redirect()->back()->with('success', 'Materi berhasil diperbarui.');
    }

    /**
     * Menghapus materi dari database.
     */
    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);

        // Hapus file lampiran jika ada dan file tersebut memang ada di storage
        if ($materi->lampiran_materi && Storage::exists('public/' . $materi->lampiran_materi)) {
            Storage::delete('public/' . $materi->lampiran_materi);
        }

        // Hapus data dari database
        $materi->delete();

        // Untuk AJAX Response
        return response()->json(['success' => true]);
    }


    /**
     * Mengunduh lampiran materi.
     */
    public function download($id)
    {
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
