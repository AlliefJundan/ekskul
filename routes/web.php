<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/ekskul', function () {
    return view('ekskul');
});

Route::get('/dashboard_admin', function () {
    return view('dashboard_admin');
});

Route::get('/login', function () {
    return view('login');
});



