<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EkskulController;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\HasilKuisController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AkunController;

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

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard_admin');

    // Ekskul (dengan middleware cek.keanggotaan, kecuali store)
    Route::post('/ekskul/store', [EkskulController::class, 'store'])->name('ekskul.store'); // Dikecualikan dari middleware cek.keanggotaan

    Route::middleware(['cek.keanggotaan'])->group(function () {
        Route::get('/ekskul', [EkskulController::class, 'galeri'])->name('ekskul.galeri');
        Route::get('/ekskul/{slug}', [EkskulController::class, 'show'])->name('ekskul.show');

        // Anggota Ekskul
        Route::get('/ekskul/anggota/{slug}', [AnggotaController::class, 'show'])->name('anggota.show');
        Route::get('/ekskul/jabatan/{slug}', [AnggotaController::class, 'jabatanShow'])->name('jabatan.jabatanShow');
        Route::post('/ekskul/anggota/{slug}', [AnggotaController::class, 'keluar'])->name('anggota.keluar');
        Route::post('/ekskul/jabatan/ganti/{slug}', [AnggotaController::class, 'jabatanUpdate'])->name('jabatan.jabatanUpdate');
        Route::post('/ekskul/jabatan/lepas/{slug}', [AnggotaController::class, 'jabatanRemove'])->name('jabatan.jabatanRemove');
        Route::delete('/ekskul/anggota/keluar/{slug}', [AnggotaController::class, 'keluarkanAnggota'])->name('anggota.keluar');

        // Absensi
        Route::get('/ekskul/absensi/{slug}', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
        Route::patch('/absensi/verifikasi/{id_absensi}', [AbsensiController::class, 'verifikasi'])->name('absensi.verifikasi');
    });

    // Kuis (dengan middleware cek.keanggotaan)
    Route::middleware(['cek.keanggotaan'])->group(function () {
        Route::get('/kuis/{slug}', [KuisController::class, 'show'])->name('kuis.show');
        Route::post('/kuis/store', [KuisController::class, 'store'])->name('kuis.store');
        Route::post('/kuis/hasil', [KuisController::class, 'hasil'])->name('kuis.hasil');
        Route::get('/kuis/hasil/{slug}', [KuisController::class, 'hasilKuis'])->name('kuis.hasilKuis');

        // Hasil Kuis
        Route::get('/kuis/hasil/jawaban/{slug}', [HasilKuisController::class, 'hasil'])
            ->name('hasil_kuis.hasil');
    });

    // Akun (khusus admin)
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('akun', AkunController::class);
    });

    // Materi
    Route::get('/materi/{slug}', [MateriController::class, 'index'])->name('materi.index');
    Route::get('/materi/download/{id}', [MateriController::class, 'download'])->name('materi.download');

    // Pendaftaran
    Route::post('/pendaftaran/store', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/pendaftaran/{slug}', [PendaftaranController::class, 'show'])->name('pendaftaran.show');
    Route::post('/pendaftaran/terima', [PendaftaranController::class, 'terima'])->name('pendaftaran.terima');
    Route::post('/pendaftaran/tolak', [PendaftaranController::class, 'tolak'])->name('pendaftaran.tolak');

    Route::get('/kegiatan/konfirmasi/{slug}', [AbsensiController::class, 'konfirmasiKegiatan'])->name('kegiatan.konfirmasi');

    Route::get('/kegiatan/konfirmasi/{slug}', [AbsensiController::class, 'konfirmasiKegiatan'])->name('kegiatan.konfirmasi');
    Route::get('/rekap-absensi/{slug}', [AbsensiController::class, 'rekap'])->name('rekap.absensi');
    Route::get('/rekap-absensi/{slug}/view/pdf', [AbsensiController::class, 'view_pdf']);
    Route::patch('/absensi/verifikasi/{id_absensi}', [AbsensiController::class, 'verifikasi'])
        ->name('absensi.verifikasi');
    Route::get('/ekskul/absensi/{slug}', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');


});
