<?php

use App\Models\Ekskul;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\EkskulController;

Route::get('/', function () {
    return view('home');
});

Route::get('/ekskul', function () {
    return view('ekskul');
});

//kuis

Route::get('/kuis/{slug}', [KuisController::class, 'show'])->name('kuis.show');

//dashboard admin
Route::get('/dashboard_admin', [EkskulController::class, 'dashboard_admin'])->name('dashboard_admin');

Route::get('/dashboard_admin/{ekskul:id_ekskul}', function (Ekskul $ekskul) {

    return view('Ekskul', ['title' => 'Single Post', 'post' => $ekskul]);
});

Route::get('/kuis', function () {
    return view('kuis');
});

//ekskul
Route::get('/ekskul/{nama_ekskul}', [EkskulController::class, 'show'])->name('ekskul.show');

Route::get('/ekskul_user', function () {
    return view('ekskul_user');
});

//dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/tabel_akun', function () {
    return view('tabel_akun');
});


Route::post(
    '/ekskul/store',
    [
        EkskulController::class,
        'store'
    ]
)->name('ekskul.store');
