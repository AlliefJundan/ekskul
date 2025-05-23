<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\User;
use App\Models\Ekskul;
use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\EkskulUser;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Models\NotifikasiTarget;
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
            'Hadir' => $absensi->where('kehadiran', 'hadir')->where('status', 'terverifikasi')->count(),
            'Izin' => $absensi->where('kehadiran', 'izin')->where('status', 'terverifikasi')->count(),
            'Sakit' => $absensi->where('kehadiran', 'sakit')->where('status', 'terverifikasi')->count(),
            'Alfa' => $absensi->where('kehadiran', 'alpa')->where('status', 'terverifikasi')->count(),
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

    public function verifikasi($id_absensi)
    {
        // Cari absensi berdasarkan ID
        $absensi = Absensi::findOrFail($id_absensi);

        // Update status menjadi 'terverifikasi'
        $absensi->update([
            'status' => 'terverifikasi',
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Absensi berhasil diverifikasi.');
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

        // Pastikan hanya admin atau pengurus ekskul yang bisa konfirmasi
        if (!(auth()->user()->role === 'admin' || optional(auth()->user()->ekskulUser->getCurrentEkskul($ekskul->id_ekskul))->jabatan)) {
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Anda tidak memiliki akses untuk konfirmasi kegiatan.',
                    'redirect_url' => route('absensi.index', $slug)
                ], 403);
            }
            return redirect()->route('absensi.index', $slug)->with('error', 'Anda tidak memiliki akses untuk konfirmasi kegiatan.');
        }

        // Cek apakah sudah ada kegiatan yang dibuat hari ini
        $kegiatanHariIni = Kegiatan::where('id_ekskul', $ekskul->id_ekskul)
            ->whereDate('hari', today())
            ->exists();

        if ($kegiatanHariIni) {
            if ($request->ajax()) {
                return response()->json([
                    'ada_kegiatan' => true,
                    'redirect_url' => route('absensi.index', $slug)
                ]);
            }
            return redirect()->route('absensi.index', $slug)->with('error', 'Kegiatan sudah dibuat hari ini, tidak bisa menambahkan lagi.');
        }

        // Jika request AJAX hanya untuk cek kegiatan, cukup kirim response JSON
        if ($request->ajax()) {
            return response()->json([
                'ada_kegiatan' => false
            ]);
        }

        // Jika menerima data mulai & berakhir, buat kegiatan baru
        if ($request->has('mulai') && $request->has('berakhir')) {
            Kegiatan::create([
                'id_ekskul' => $ekskul->id_ekskul,
                'hari' => today(),
                'waktu_mulai' => $request->mulai,
                'waktu_berakhir' => $request->berakhir,
            ]);

            Notifikasi::create([
                'title' => 'Kegiatan Baru',
                'category' => 'kegiatan',
                'id_ekskul' => $ekskul->id_ekskul,
                'description' => 'Hari ini ada kegiatan dari jam ' . $request->mulai . ' hingga ' . $request->berakhir,
            ]);

            $users = EkskulUser::where('ekskul_id', $request->id_ekskul)
                ->join('users', 'ekskul_user.user_id', '=', 'users.id_user')
                ->where('users.deleted', false)
                ->pluck('user_id');
            $id_notifikasi = Notifikasi::latest('id_notifikasi')->value('id_notifikasi');

            foreach ($users as $user_id) {
                NotifikasiTarget::create([
                    'id_notifikasi' => $id_notifikasi,
                    'id_user' => $user_id,
                ]);
            }

            return redirect()->route('absensi.index', $slug)->with('success', 'Kegiatan berhasil ditambahkan.');
        }

        return redirect()->route('absensi.index', $slug);
    }


    public function view_pdf($slug, Request $request)
    {
        $bulan = $request->query('bulan', date('m')); // Default bulan ini
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();

        // Ambil data absensi berdasarkan ekskul dan bulan
        $rekapAbsen = User::whereHas('absensi', function ($query) use ($ekskul, $bulan) {
            $query->where('id_ekskul', $ekskul->id_ekskul)
                ->whereMonth('tanggal', $bulan);
        })->with('absensi')->get();

        // Render tampilan Blade ke HTML
        $html = view('rekap_absensi_pdf', compact('rekapAbsen', 'ekskul', 'bulan'))->render();

        // Inisialisasi MPDF
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        // Output PDF
        return response($mpdf->Output('Rekap_Absensi.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }
    public function rekap($slug, Request $request)
    {
        $bulan = $request->query('bulan', date('m')); // Ambil bulan dari query, default bulan sekarang
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();

        $rekapAbsen = User::whereHas('absensi', function ($query) use ($ekskul, $bulan) {
            $query->where('id_ekskul', $ekskul->id_ekskul)
                ->whereMonth('tanggal', $bulan);
        })
            ->withCount([
                // Hitung jumlah yang belum terverifikasi untuk kolom konfirmasi
                'absensi as konfirmasi' => function ($query) use ($ekskul, $bulan) {
                    $query->where('id_ekskul', $ekskul->id_ekskul)
                        ->whereMonth('tanggal', $bulan)
                        ->where('status', 'belum terverifikasi'); // Menampilkan yang belum terverifikasi
                },
                // Hanya hitung jika statusnya sudah terverifikasi
                'absensi as hadir' => function ($query) use ($ekskul, $bulan) {
                    $query->where('id_ekskul', $ekskul->id_ekskul)
                        ->whereMonth('tanggal', $bulan)
                        ->where('status', 'terverifikasi') // Hanya yang sudah terverifikasi
                        ->where('kehadiran', 'hadir');
                },
                'absensi as izin' => function ($query) use ($ekskul, $bulan) {
                    $query->where('id_ekskul', $ekskul->id_ekskul)
                        ->whereMonth('tanggal', $bulan)
                        ->where('status', 'terverifikasi') // Hanya yang sudah terverifikasi
                        ->where('kehadiran', 'izin');
                },
                'absensi as sakit' => function ($query) use ($ekskul, $bulan) {
                    $query->where('id_ekskul', $ekskul->id_ekskul)
                        ->whereMonth('tanggal', $bulan)
                        ->where('status', 'terverifikasi') // Hanya yang sudah terverifikasi
                        ->where('kehadiran', 'sakit');
                },
                'absensi as alpa' => function ($query) use ($ekskul, $bulan) {
                    $query->where('id_ekskul', $ekskul->id_ekskul)
                        ->whereMonth('tanggal', $bulan)
                        ->where('status', 'terverifikasi') // Hanya yang sudah terverifikasi
                        ->where('kehadiran', 'alpa');
                },
            ])->get();

        return view('rekap_absensi', compact('rekapAbsen', 'ekskul', 'bulan'));
    }
}
