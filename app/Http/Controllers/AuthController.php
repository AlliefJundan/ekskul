<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function tampilLogin()
    {
        return view('login');
    }

    public function submitLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role == 'admin') {
                return redirect()->route('dashboard_admin'); // Redirect admin ke dashboard admin
            } else {
                return redirect()->route('dashboard'); // Redirect user biasa ke dashboard user
            }
        }

        return redirect()->back()->with('error', 'Login Gagal');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
