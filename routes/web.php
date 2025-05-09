<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\EkskulController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HasilKuisController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PendaftaranController;

// Route yang tidak membutuhkan autentikasi
Route::get('/', [EkskulController::class, 'index'])->name('home');
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'tampilLogin'])->name('login');
    Route::post('/login/submit', [AuthController::class, 'submitLogin'])->name('login.submit');
});

// Semua route lainnya hanya bisa diakses oleh user yang sudah login
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profil
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil/PasswordUpdate', [ProfilController::class, 'password'])->name('profil.password');
    Route::put('/profil/foto', [ProfilController::class, 'foto'])->name('profil.foto');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard_admin');
    Route::get('/ekskul', [EkskulController::class, 'galeri'])->name('ekskul.galeri');

    // Ekskul (dengan middleware cek.keanggotaan, kecuali store)
    Route::post('/ekskul/store', [EkskulController::class, 'store'])->name('ekskul.store'); // Dikecualikan dari middleware cek.keanggotaan

    Route::middleware(['role:admin,jabatan:1'])->group(function () {
        Route::get('/ekskul/jabatan/{ekskul:slug}', [AnggotaController::class, 'jabatanShow'])->name('jabatan.jabatanShow');
        Route::post('/ekskul/jabatan/ganti/{ekskul:slug}', [AnggotaController::class, 'jabatanUpdate'])->name('jabatan.jabatanUpdate');
        Route::post('/ekskul/jabatan/lepas/{ekskul:slug}', [AnggotaController::class, 'jabatanRemove'])->name('jabatan.jabatanRemove');
    });
    Route::middleware(['cek.keanggotaan'])->group(function () {
        Route::get('/ekskul/{slug}', [EkskulController::class, 'show'])->name('ekskul.show');

        // Anggota Ekskul
        Route::get('/ekskul/anggota/{slug}', [AnggotaController::class, 'show'])->name('anggota.show');
        Route::post('/ekskul/anggota/{slug}', [AnggotaController::class, 'keluar'])->name('anggota.keluar');

        // Jabatan

        Route::delete('/ekskul/anggota/keluar/{slug}', [AnggotaController::class, 'keluarkanAnggota'])->name('anggota.keluarkan');
        Route::post('/keluar/ekskul/{slug}', [AnggotaController::class, 'keluar'])->name('anggota.keluar');

        // Absensi
        Route::get('/ekskul/absensi/{slug}', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
        Route::patch('/absensi/verifikasi/{id_absensi}', [AbsensiController::class, 'verifikasi'])->name('absensi.verifikasi');
    });

    Route::post('/kuis/store', [KuisController::class, 'store'])->name('kuis.store');
    Route::post('/kuis/hasil', [KuisController::class, 'hasil'])->name('kuis.hasil');


    // Hasil Kuis
    Route::get('/kuis/hasil/jawaban/{slug}', [HasilKuisController::class, 'hasil'])
        ->name('hasil_kuis.hasil');
    Route::put('/hasil/{id}/terima', [HasilKuisController::class, 'terima'])->name('hasil.terima');
    Route::put('/hasil/{id}/tolak', [HasilKuisController::class, 'tolak'])->name('hasil.tolak');

    // Kuis (dengan middleware cek.keanggotaan)
    Route::middleware(['cek.keanggotaan'])->group(function () {
        Route::get('/ekskul/pendaftaran/{slug}', [PendaftaranController::class, 'show'])->name('pendaftaran.show');

        //Kuis
        Route::get('/kuis/hasil/{slug}', [KuisController::class, 'hasilKuis'])->name('kuis.hasilKuis');
        Route::get('/kuis/{slug}', [KuisController::class, 'show'])->name('kuis.show');

        //absensi dan kegiatan
        Route::get('/kegiatan/konfirmasi/{slug}', [AbsensiController::class, 'konfirmasiKegiatan'])->name('kegiatan.konfirmasi');
        Route::get('/rekap-absensi/{slug}', [AbsensiController::class, 'rekap'])->name('rekap.absensi');
        Route::patch('/absensi/verifikasi/{id_absensi}', [AbsensiController::class, 'verifikasi'])->name('absensi.verifikasi');
        Route::get('/ekskul/absensi/{slug}', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');

        //Materi
        Route::get('ekskul/materi/{slug}', [MateriController::class, 'index'])->name('materi.index');
        Route::get('/materi/download/{id}', [MateriController::class, 'download'])->name('materi.download');
        Route::post('/materi/update', [MateriController::class, 'update'])->name('materi.update');
    });

    // Akun (khusus admin)
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('akun', AkunController::class);
        Route::delete('/akun/{id_user}/delete', [AkunController::class, 'destroy'])->name('akun.destroy');
    });

    // Notifikasi
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/read', [NotifikasiController::class, 'read'])->name('notifikasi.read');
    Route::post('/notifikasi/readAll', [NotifikasiController::class, 'readAll'])->name('notifikasi.readAll');

    // Materi
    Route::get('/materi/{slug}', [MateriController::class, 'index'])->name('materi.index');
    Route::post('/materi', [MateriController::class, 'store'])->name('materi.store');
    Route::put('/materi/{id}', [MateriController::class, 'update'])->name('materi.update');
    Route::delete('/materi/{id}', [MateriController::class, 'destroy'])->name('materi.destroy');
    Route::get('/materi/download/{id}', [MateriController::class, 'download'])->name('materi.download');

    // Pendaftaran
    Route::post('/pendaftaran/store', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::post('/pendaftaran/terima', [PendaftaranController::class, 'terima'])->name('pendaftaran.terima');
    Route::post('/pendaftaran/tolak', [PendaftaranController::class, 'tolak'])->name('pendaftaran.tolak');

    Route::get('/kegiatan/konfirmasi/{slug}', [AbsensiController::class, 'konfirmasiKegiatan'])->name('kegiatan.konfirmasi');

    Route::get('/kegiatan/konfirmasi/{slug}', [AbsensiController::class, 'konfirmasiKegiatan'])->name('kegiatan.konfirmasi');
    Route::get('/rekap-absensi/{slug}', [AbsensiController::class, 'rekap'])->name('rekap.absensi');
    Route::get('/rekap-absensi/{slug}/view/pdf', [AbsensiController::class, 'view_pdf'])->name('rekap.absensi.pdf');
    Route::patch('/absensi/verifikasi/{id_absensi}', [AbsensiController::class, 'verifikasi'])
        ->name('absensi.verifikasi');
    Route::get('/ekskul/absensi/{slug}', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::patch('/absensi/verifikasi/{id_absensi}', [AbsensiController::class, 'verifikasi'])->name('absensi.verifikasi');
    Route::post('/ekskul/{id}/tambah-gambar', [EkskulController::class, 'tambahGambar'])->name('ekskul.tambahGambar');

    Route::put('/ekskul/{id}', [EkskulController::class, 'update'])->name('ekskul.update');
    Route::delete('/ekskul/{id}', [EkskulController::class, 'destroy'])->name('ekskul.destroy');
    Route::delete('/ekskul/hapus-gambar/{id}', [EkskulController::class, 'hapusGambar'])->name('ekskul.hapusGambar');
});
