<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek apakah user sudah login, DAN apakah rolenya SESUAI dengan yang diminta
        // Kalau belum login, tolak langsung
        if (!$request->user()) {
            abort(403, 'Akses Ditolak: Lu harus login dulu!');
        }

        // Kalau rolenya gak sesuai, tampilkan error 403 (Akses Ditolak)
        if ($request->user()->role !== $role) {
            abort(403, 'Akses Ditolak: Lu bukan ' . $role . ' bang!');
        }

        // Kalau sesuai, silakan lewat
        return $next($request);
    }
}