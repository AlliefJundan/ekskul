<?php

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

Route::get('/dashboard_admin', function () {
    return view('dashboard_admin');
});
