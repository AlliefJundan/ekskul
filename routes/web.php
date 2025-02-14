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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HasilKuisController;

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
Route::get('/ekskul/{ekskul:slug}', [DashboardController::class, 'show'])->name('ekskul.show');
Route::get('/dashboard_admin/{ekskul:id_ekskul}', function (Ekskul $ekskul) {
    return view('Ekskul', ['post' => $ekskul]);
});

//Login
// Route::get('/login', [AuthController::class, 'tampilLogin'])->name('login');
Route::post('/login/submit', [AuthController::class, 'submitLogin'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//ekskul
Route::get('/ekskul/{slug}', [EkskulController::class, 'show'])->name('ekskul.show');
Route::get('/ekskul_user', function () {
    return view('ekskul_user');
});

//anggota ekskul
Route::get('/ekskul/anggota/{slug}', [AkunController::class, 'anggotaShow'])->name('anggota.show');

//dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard_admin', [DashboardController::class, 'index'])->name('dashboard_admin');
});

//akun
Route::resource('akun', AkunController::class);
Route::post(
    '/ekskul/store',
    [
        EkskulController::class,
        'store'
    ]
)->name('ekskul.store');

Route::resource('akun', AkunController::class);
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
Route::get('/materi', [MateriController::class, 'index'])->name('materi.index');
Route::post('/materi', [MateriController::class, 'store'])->name('materi.store');


//Absensi
Route::get('/absensi', [AbsensiController::class, 'index'])->middleware('auth');
Route::post('/absensi', [AbsensiController::class, 'store'])->middleware('auth');
