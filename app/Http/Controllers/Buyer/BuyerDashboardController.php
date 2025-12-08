<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product; // Import Product model

class BuyerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get recent orders for the dashboard stats
        $orders = Order::where('user_id', $user->id)->latest()->take(5)->get();
        
        // Fix: Also get some products for the "Back to Shop" or recommendations section
        // Fetch 4 random products for recommendations
        $products = Product::inRandomOrder()->take(4)->get(); 

        return view('buyer.dashboard', compact('user', 'orders', 'products'));
    }
}