<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BuyerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan role-nya buyer
        if (!auth()->check() || !auth()->user()->isBuyer()) {
            abort(403, 'Akses ditolak. Hanya Buyer yang bisa mengakses halaman ini.');
        }

        return $next($request);
    }
}