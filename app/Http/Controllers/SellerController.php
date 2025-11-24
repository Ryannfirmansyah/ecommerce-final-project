<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    // Halaman pending untuk seller yang belum approved
    public function pending()
    {
        $user = Auth::user();

        // Jika bukan seller atau bukan pending, redirect
        if (!$user->isSeller()) {
            return redirect()->route('dashboard');
        }

        return view('seller.pending', compact('user'));
    }

    // Delete account untuk rejected seller
    public function deleteAccount()
    {
        $user = Auth::user();

        // Hanya rejected seller yang bisa delete account
        if ($user->isSeller() && $user->isRejectedSeller()) {
            Auth::logout();
            $user->delete();

            return redirect()->route('login')->with('status', 'Akun Anda telah dihapus.');
        }

        return redirect()->back();
    }
}