<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // 2. Cek apakah role user sesuai dengan yang diminta route
        // Contoh: Route butuh 'admin', tapi user adalah 'buyer' -> TOLAK
        if (Auth::user()->role !== $role) {
            
            // Redirect pintar: Kembalikan user ke dashboard hak mereka masing-masing
            $userRole = Auth::user()->role;
            
            if ($userRole === 'admin') {
                return redirect()->route('admin.dashboard');
            } 
            elseif ($userRole === 'seller') {
                return redirect()->route('seller.dashboard');
            } 
            
            // Default untuk Buyer atau user lain
            return redirect()->route('home');
        }

        return $next($request);
    }
}