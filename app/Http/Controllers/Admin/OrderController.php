<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // FR-10/FR-12: Admin Order Management & Reports
    public function index(Request $request)
    {
        $orders = Order::with('user')
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('details.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
        $order->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Order status updated.']);
        }

        return back()->with('success', 'Order status updated.');
    }
}
