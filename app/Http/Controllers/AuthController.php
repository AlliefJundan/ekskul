<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function tampilLogin()
    {
        return view('login'); // Sesuaikan dengan lokasi view login
    }

    public function submitLogin(Request $request)
    {
        $data = $request->only('username', 'password');

        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            
            return redirect()->route('dashboard_admin');
        } else {
            return redirect()->back()->with('gagal', 'username atau password salah');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login.tampil');
        }
}
