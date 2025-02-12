<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HasilKuisController extends Controller
{
    public function show()
    {
        return view('hasil_kuis');
    }
}
