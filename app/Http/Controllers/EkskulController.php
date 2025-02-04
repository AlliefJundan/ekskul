<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekskul;

class EkskulController extends Controller
{
    public function dashboard_admin()
    {
        $ekskuls = Ekskul::with(['pembina', 'ketua'])->get();
        return view('dashboard_admin', compact('ekskuls'));
    }
}
