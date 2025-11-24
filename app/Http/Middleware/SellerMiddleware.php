<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan role-nya seller
        if (!auth()->check() || !auth()->user()->isSeller()) {
            abort(403, 'Akses ditolak. Hanya Seller yang bisa mengakses halaman ini.');
        }

        // Cek apakah seller sudah approved
        if (!auth()->user()->isApprovedSeller()) {
            // Redirect ke halaman pending jika belum approved
            return redirect()->route('seller.pending');
        }

        return $next($request);
    }
}