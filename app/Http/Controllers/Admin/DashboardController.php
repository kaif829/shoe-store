<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Admin Dashboard Features: Dashboard Statistics
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'customer')->count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'low_stock' => Product::where('stock', '<', 5)->count(),
        ];

        $salesByDay = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topProducts = Product::orderByDesc('review_count')->limit(5)->get();
        $recentOrders = Order::with('user')->latest()->limit(8)->get();

        return view('admin.dashboard', compact('stats', 'salesByDay', 'topProducts', 'recentOrders'));
    }
}
