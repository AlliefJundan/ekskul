<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekskul;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Pastikan hanya user yang terautentikasi bisa mengakses
    }

    public function index()
    {
        return $this->dashboard_admin(); // Langsung panggil dashboard_admin
    }

    public function dashboard_admin()
    {
        $ekskuls = Ekskul::with([
            'pembina.user',
            'ketua.user',
            'sekertaris.user',
            'bendahara.user'
        ])->get();

        return view('dashboard_admin', compact('ekskuls'));
    }

    public function show($slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->firstOrFail();

        return view('ekskul', compact('ekskul'));
    }
}
