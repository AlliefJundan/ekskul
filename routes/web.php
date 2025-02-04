<?php

use App\Http\Controllers\EkskulController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/gallery', function () {
    return view('gallery');
});

Route::get('/ekskul', function () {
    return view('ekskul');
});

// Route::get('/dashboard_admin', function () {
//     return view('dashboard_admin');
// });


Route::get('/dashboard_admin', [EkskulController::class, 'dashboard_admin']);
