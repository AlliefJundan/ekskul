<?php

use App\Models\Kuis;
use App\Models\Ekskul;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\EkskulController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HasilKuisController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\TerimaPengajuanEkskulController;




Route::get('/', function () {
    return view('home', [EkskulController::class, 'index']);
});

Route::get('/', [EkskulController::class, 'index'])->name('galeri');

Route::get('/ekskul', function () {
    return view('ekskul');
});

//kuis

Route::get('/kuis/{slug}', [KuisController::class, 'show'])->name('kuis.show');
Route::post('/kuis/store', [KuisController::class, 'store'])->name('kuis.store');
Route::post('/kuis/hasil', [KuisController::class, 'hasil'])->name('kuis.hasil');
Route::get('/kuis/hasil/{slug}', [KuisController::class, 'hasilKuis'])->name('kuis.hasilKuis');

//hasil kuis
Route::get('/kuis/hasil/jawaban/{slug}', [HasilKuisController::class, 'hasil'])
    ->name('hasil_kuis.hasil');

Route::get('/kuis', function () {
    return view('kuis');
});

Route::get('/redirect-kuis/{id}', function ($id) {
    $kuis = Kuis::findOrFail($id);
    return redirect()->away($kuis->link_kuis);
})->name('redirect.kuis');


//dashboard admin
// Route::get('/ekskul/{ekskul:slug}', [DashboardController::class, 'show'])->name('ekskul.show');
Route::get('/dashboard_admin/{ekskul:id_ekskul}', function (Ekskul $ekskul) {
    return view('Ekskul', ['post' => $ekskul]);
});

//Login
// Route::get('/login', [AuthController::class, 'tampilLogin'])->name('login');
Route::post('/login/submit', [AuthController::class, 'submitLogin'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//ekskul
Route::get('/ekskul/{slug}', [EkskulController::class, 'show'])->name('ekskul.show');


//anggota ekskul
Route::get('/ekskul/anggota/{slug}', [AnggotaController::class, 'show'])->name('anggota.show');
Route::get('/ekskul/jabatan/{slug}', [AnggotaController::class, 'jabatanShow'])->name('jabatan.jabatanShow');
Route::post('/ekskul/anggota/{slug}', [AnggotaController::class, 'keluar'])->name('anggota.keluar');
Route::post('/ekskul/jabatan/ganti/{slug}', [AnggotaController::class, 'jabatanUpdate'])->name('jabatan.jabatanUpdate');
Route::post('/ekskul/jabatan/lepas/{slug}', [AnggotaController::class, 'jabatanRemove'])->name('jabatan.jabatanRemove');
Route::delete('/ekskul/anggota/keluar/{slug}', [AnggotaController::class, 'keluarkanAnggota'])->name('anggota.keluar');

//dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard_admin');
});

//akun

Route::middleware('role:admin')->group(function () {
    Route::resource('akun', AkunController::class);
});

Route::post('/ekskul/store', [EkskulController::class, 'store'])->name('ekskul.store');
Route::get('/get-pembina/{id_jabatan}', [EkskulController::class, 'getPembinaByJabatan'])->name('get-pembina');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'tampilLogin'])->name('login');
    Route::post('/login/submit', [AuthController::class, 'submitLogin'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/coba', function () {
    return view('coba');
});


//materi
Route::get('/materi/{slug}', [MateriController::class, 'index'])->name('materi.index');
Route::post('/materi', [MateriController::class, 'store'])->name('materi.store');
Route::get('/materi/download/{id}', [MateriController::class, 'download'])->name('materi.download');


//Absensi
Route::middleware(['auth'])->group(function () {
    Route::get('/ekskul/absensi/{slug}', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
});



Route::patch('/absensi/verifikasi/{id_absensi}', [AbsensiController::class, 'verifikasi'])
    ->name('absensi.verifikasi');

Route::post('/pendaftaran/store', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

//terimaEkskul
Route::get('/terima_pengajuan_ekskul', [TerimaPengajuanEkskulController::class, 'index'])->name('terimaPengajuanEkskul');
Route::post('/terima_pengajuan_ekskul/{userId}/{ekskulId}/terima', [TerimaPengajuanEkskulController::class, 'terima'])->name('terimaPengajuanEkskul.terima');
Route::post('/terima_pengajuan_ekskul/{userId}/{ekskulId}/tolak', [TerimaPengajuanEkskulController::class, 'tolak'])->name('terimaPengajuanEkskul.tolak');
