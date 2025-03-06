<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Ekskul;
use App\Models\User;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index(Request $request, $slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();
        $user = Auth::user();
        $tanggal = $request->input('tanggal', now()->toDateString()); // Default ke hari ini

        // Cek apakah ada kegiatan yang dibuat hari ini
        $kegiatanHariIni = Kegiatan::where('id_ekskul', $ekskul->id_ekskul)
            ->whereDate('hari', today())
            ->first();

        if ($user->role === 'admin' || optional($user->ekskulUser)->jabatan == 2) {
            $absensi = Absensi::where('id_ekskul', $ekskul->id_ekskul)
                ->whereDate('tanggal', $tanggal)
                ->with('user')
                ->orderBy('tanggal', 'desc')
                ->get();
        } else {
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

        $jumlahKegiatan = Kegiatan::where('id_ekskul', $ekskul->id_ekskul)->count();

        $rekapAbsen = User::whereHas('absensi', function ($query) use ($ekskul) {
            $query->where('id_ekskul', $ekskul->id_ekskul);
        })->withCount([
            'absensi as hadir' => function ($query) use ($ekskul) {
                $query->where('id_ekskul', $ekskul->id_ekskul)->where('kehadiran', 'hadir');
            },
            'absensi as izin' => function ($query) use ($ekskul) {
                $query->where('id_ekskul', $ekskul->id_ekskul)->where('kehadiran', 'izin');
            },
            'absensi as sakit' => function ($query) use ($ekskul) {
                $query->where('id_ekskul', $ekskul->id_ekskul)->where('kehadiran', 'sakit');
            },
            'absensi as tidak_hadir' => function ($query) use ($ekskul) {
                $query->where('id_ekskul', $ekskul->id_ekskul)->where('kehadiran', 'alpa');
            },
        ])->get();

        return view('absensi', compact('absensi', 'count', 'ekskul', 'jumlahKegiatan', 'rekapAbsen', 'kegiatanHariIni'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'id_ekskul' => 'required|exists:ekskul,id_ekskul',
            'kehadiran' => 'required|in:hadir,izin,sakit,alpa',
        ]);

        $today = now()->toDateString();
        $currentTime = now()->toTimeString(); // Waktu saat ini

        // Cek apakah ada kegiatan hari ini
        $kegiatanHariIni = Kegiatan::where('id_ekskul', $request->id_ekskul)
            ->whereDate('hari', today())
            ->first();

        if (!$kegiatanHariIni) {
            return redirect()->back()->with('error', 'Tidak ada kegiatan yang dibuat hari ini! Absensi tidak dapat dilakukan.');
        }

        // Cek apakah waktu saat ini sudah melewati waktu terakhir kegiatan
        if ($currentTime > $kegiatanHariIni->waktu_berakhir) {
            return redirect()->back()->with('error', 'Waktu absensi sudah berakhir. Anda tidak dapat melakukan absensi.');
        }

        $existingAbsensi = Absensi::where('id_user', $request->id_user)
            ->where('id_ekskul', $request->id_ekskul)
            ->where('tanggal', $today)
            ->first();

        if ($existingAbsensi) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absensi hari ini!');
        }

        Absensi::create([
            'id_ekskul' => $request->id_ekskul,
            'id_user' => $request->id_user,
            'tanggal' => $today,
            'kehadiran' => $request->kehadiran,
            'status' => 'belum terverifikasi',
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil ditambahkan');
    }



        public function konfirmasiKegiatan(Request $request, $slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        if (!($user->role === 'admin' || in_array(optional($user->ekskulUser)->jabatan, [1, 2, 3]))) {
            return redirect()->route('absensi.index', $slug)->with('error', 'Anda tidak memiliki akses untuk konfirmasi kegiatan.');
        }

        // Cek apakah sudah ada kegiatan yang dibuat hari ini
        $kegiatanHariIni = Kegiatan::where('id_ekskul', $ekskul->id_ekskul)
            ->whereDate('hari', today())
            ->exists();

        if ($kegiatanHariIni) {
            return redirect()->route('absensi.index', $slug)->with('error', 'Kegiatan sudah dibuat hari ini, tidak bisa menambahkan lagi.');
        }

        if ($request->has('mulai') && $request->has('berakhir')) {
            Kegiatan::create([
                'id_ekskul' => $ekskul->id_ekskul,
                'hari' => today(),
                'waktu_mulai' => $request->mulai,
                'waktu_berakhir' => $request->berakhir,
            ]);

            return redirect()->route('absensi.index', $slug)->with('success', 'Kegiatan berhasil ditambahkan.');
        }

        return redirect()->route('absensi.index', $slug);
    }
    public function rekap($slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();

        $rekapAbsen = User::whereHas('absensi', function ($query) use ($ekskul) {
            $query->where('id_ekskul', $ekskul->id_ekskul);
        })->withCount([
            'absensi as konfirmasi' => function ($query) use ($ekskul) {
                $query->where('id_ekskul', $ekskul->id_ekskul)->where('status', 'belum terverifikasi');
            },
            'absensi as hadir' => function ($query) use ($ekskul) {
                $query->where('id_ekskul', $ekskul->id_ekskul)->where('kehadiran', 'hadir')->where('status', 'terverifikasi');
            },
            'absensi as izin' => function ($query) use ($ekskul) {
                $query->where('id_ekskul', $ekskul->id_ekskul)->where('kehadiran', 'izin')->where('status', 'terverifikasi');
            },
            'absensi as sakit' => function ($query) use ($ekskul) {
                $query->where('id_ekskul', $ekskul->id_ekskul)->where('kehadiran', 'sakit')->where('status', 'terverifikasi');
            },
            'absensi as tidak_hadir' => function ($query) use ($ekskul) {
                $query->where('id_ekskul', $ekskul->id_ekskul)->where('kehadiran', 'alpa')->where('status', 'terverifikasi');
            },
        ])->get();

        return view('rekap_absensi', compact('rekapAbsen', 'ekskul'));
    }

    public function verifikasi($id_absensi)
    {
        // Cari absensi berdasarkan ID
        $absensi = Absensi::findOrFail($id_absensi);

        // Update status menjadi 'terverifikasi'
        $absensi->update([
            'status' => 'terverifikasi',
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil diverifikasi.');
    }
}
