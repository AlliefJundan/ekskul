<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\EkskulUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekKeanggotaan
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();
        $slug = $request->route('slug'); // Ambil slug dari parameter URL

        if ($user->role === 'admin') {
            return $next($request);
        }

        // Cek apakah user merupakan anggota ekskul berdasarkan slug
        $isMember = EkskulUser::where('user_id', $user->id_user)
            ->whereHas('ekskul', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->exists();

        if (!$isMember) {
            return redirect()->route('dashboard_admin')->with('error', 'Anda bukan anggota ekskul ini.');
        }

        return $next($request);
    }
}
