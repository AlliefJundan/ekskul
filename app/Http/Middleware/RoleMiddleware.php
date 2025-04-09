<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Ekskul;
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
        $allowedRoles = [];

        $slug = $request->route('ekskul');
        $ekskul = Ekskul::where('slug', $slug)->first();

        // Pisahkan antara role dan jabatan
        foreach ($roles as $role) {
            if (str_starts_with($role, 'jabatan:')) {
                $allowedJabatan[] = intval(str_replace('jabatan:', '', $role));
            } else {
                $allowedRoles[] = $role;
            }
        }

        // Jika role yang diperbolehkan termasuk admin, izinkan langsung
        if (in_array($user->role, $allowedRoles)) {
            return $next($request);
        }

        // Ambil daftar jabatan user di ekskul
        $jabatanUser = $user->ekskulUser()
            ->where('ekskul_id', $ekskul->id_ekskul)
            ->pluck('jabatan')
            ->toArray();


        // Jika user tidak memiliki jabatan, tolak akses
        if (empty($jabatanUser)) {
            return redirect()->back()->with('error', 'Anda belum memiliki jabatan di ekskul.');
        }

        // Jika user memiliki salah satu jabatan yang diperbolehkan, izinkan akses
        if (!empty($allowedJabatan) && array_intersect($jabatanUser, $allowedJabatan)) {
            return $next($request);
        }

        // Jika tidak memenuhi syarat, tolak akses
        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
