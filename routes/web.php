<?php

use App\Http\Controllers\EkskulController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/ekskul', function () {
    return view('ekskul');
});

<<<<<<< HEAD
Route::get('/dashboard_admin', function () {
    return view('dashboard_admin');
});

Route::get('/login', function () {
    return view('login');
});



=======
// Route::get('/dashboard_admin', function () {
//     return view('dashboard_admin');
// });


Route::get('/dashboard_admin', [EkskulController::class, 'dashboard_admin']);
>>>>>>> e2303ad83b37cbd4c6f71d0b39e593140c7103d6
