<?php

use App\Models\Kuis;
use App\Models\Ekskul;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\EkskulController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\RoleMiddleware;


Route::get('/', function () {
    return view('home');
});

Route::get('/ekskul', function () {
    return view('ekskul');
});

//kuis

Route::get('/kuis/{slug}', [KuisController::class, 'show'])->name('kuis.show');

Route::get('/kuis', [KuisController::class, 'index'])->name('kuis.index');

Route::get('/redirect-kuis/{id}', function ($id) {
    $kuis = Kuis::findOrFail($id);
    return redirect()->away($kuis->link_kuis);
})->name('redirect.kuis');


//dashboard admin
Route::get('/dashboard_admin', [EkskulController::class, 'dashboard_admin'])->name('dashboard_admin');

Route::get('/dashboard_admin/{ekskul:id_ekskul}', function (Ekskul $ekskul) {

    return view('Ekskul', ['title' => 'Single Post', 'post' => $ekskul]);
});

Route::get('/kuis', function () {
    return view('kuis');
});

//ekskul
Route::get('/ekskul/{slug}', [EkskulController::class, 'show'])->name('ekskul.show');

Route::get('/ekskul_user', function () {
    return view('ekskul_user');
});

//dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::resource('akun', AkunController::class);
Route::post(
    '/ekskul/store',
    [
        EkskulController::class,
        'store'
    ]
)->name('ekskul.store');

Route::get('/get-pembina/{id_jabatan}', [EkskulController::class, 'getPembinaByJabatan'])->name('get-pembina');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'tampilLogin'])->name('login.tampil');
    Route::post('/login/submit', [AuthController::class, 'submitLogin'])->name('login.submit');
});



Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/coba', function () {
    return view('coba');
});
