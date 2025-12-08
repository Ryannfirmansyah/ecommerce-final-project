<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureSellerIsApproved
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Jika user adalah seller TAPI statusnya bukan 'approved'
        if ($user && $user->role === 'seller' && $user->seller_status !== 'approved') {

            // Lempar mereka ke halaman "Ruang Tunggu" (Pending Page)
            return redirect()->route('seller.pending');
        }

        return $next($request);
    }
}