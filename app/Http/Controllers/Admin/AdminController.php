<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Hitung statistik untuk dashboard
        $stats = [
            'total_users' => User::count(),
            'total_sellers' => User::where('role', 'seller')->count(),
            'pending_sellers' => User::where('role', 'seller')->where('seller_status', 'pending')->count(),
            'total_buyers' => User::where('role', 'buyer')->count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_categories' => Category::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}