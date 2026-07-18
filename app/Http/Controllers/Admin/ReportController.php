<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // FR-12: Report Generation
    public function index(Request $request)
    {
        $from = $request->from ?? now()->subDays(30)->toDateString();
        $to = $request->to ?? now()->toDateString();

        $salesReport = Order::whereBetween('created_at', [$from, $to])
            ->where('status', '!=', 'cancelled')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'), DB::raw('COUNT(*) as orders_count'))
            ->groupBy('date')->orderBy('date')->get();

        $bestSellers = Product::withCount(['orderDetails as units_sold' => fn ($q) => $q->select(DB::raw('SUM(quantity)'))])
            ->orderByDesc('units_sold')->limit(10)->get();

        return view('admin.reports.index', compact('salesReport', 'bestSellers', 'from', 'to'));
    }
}
