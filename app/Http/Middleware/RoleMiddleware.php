<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();
        $allowedJabatan = [];

        // Pisahkan antara role dan jabatan
        foreach ($roles as $key => $role) {
            if (str_starts_with($role, 'jabatan:')) {
                $allowedJabatan[] = intval(str_replace('jabatan:', '', $role));
                unset($roles[$key]);
            }
        }

        // Cek apakah user memiliki role yang diperbolehkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Cek apakah user memiliki jabatan dalam ekskul_user
        $jabatanUser = $user->ekskulUser()->pluck('jabatan')->toArray();

        // Jika user tidak memiliki jabatan sama sekali, maka ditolak
        if (empty($jabatanUser)) {
            return redirect('/dashboard_admin')->with('error', 'Anda belum memiliki jabatan di ekskul.');
        }

        // Cek apakah user memiliki jabatan yang diperbolehkan
        if (!empty($allowedJabatan) && array_intersect($jabatanUser, $allowedJabatan)) {
            return $next($request);
        }

        return redirect('/dashboard_admin')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
