<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class BuyerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Statistik untuk dashboard
        $stats = [
            'total_orders' => $user->orders()->count(),
            'pending_orders' => $user->orders()->where('status', 'pending')->count(),
            'processing_orders' => $user->orders()->where('status', 'processing')->count(),
            'completed_orders' => $user->orders()->where('status', 'completed')->count(),
        ];

        // Recent orders
        $recentOrders = $user->orders()
            ->with('orderItems.product')
            ->latest()
            ->limit(5)
            ->get();

        return view('buyer.dashboard', compact('stats', 'recentOrders'));
    }
}