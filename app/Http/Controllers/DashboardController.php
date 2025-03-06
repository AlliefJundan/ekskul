<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekskul;
use App\Models\EkskulUser;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Pastikan hanya user yang terautentikasi bisa mengakses
    }

    public function index()
    {
        if (auth()->user()->role) {
            return $this->dashboard_admin(); // Langsung panggil dashboard_admin
        }
        return $this->dashboard_user(); // Langsung panggil dashboard_admin

    }

    public function dashboard_admin()
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            // Admin melihat semua ekskul
            $ekskuls = Ekskul::all();
        } else {

            $ekskulUser = EkskulUser::where('user_id', $user->id_user)->pluck('ekskul_id');

            $ekskuls = Ekskul::whereIn('id_ekskul', $ekskulUser)->get();
        }

        return view('dashboard_admin', compact('ekskuls'));
    }




    public function dashboard_user()
    {
        $ekskuls = Ekskul::with([
            'pembina.user',
            'ketua.user',
            'sekertaris.user',
            'bendahara.user'
        ])->get();

        return view('dashboard', compact('ekskuls'));
    }
}
