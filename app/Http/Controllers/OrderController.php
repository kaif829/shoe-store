<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout()
    {
        $items = CartItem::with('product')->where('user_id', auth()->id())->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $items->sum(fn ($i) => $i->quantity * $i->product->price);

        return view('orders.checkout', compact('items', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $data = $request->validate([
            'shipping_name'    => 'required|string|max:255',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'city'             => 'required|string|max:100',
        ]);

        $items = CartItem::with('product')->where('user_id', auth()->id())->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Stock check before transaction
        foreach ($items as $item) {
            if (!$item->product || $item->product->stock < $item->quantity) {
                return back()->with('error', '"'.($item->product->name ?? 'A product').'" does not have enough stock.');
            }
        }

        try {
            $order = DB::transaction(function () use ($data, $items) {
                $total = $items->sum(fn ($i) => $i->quantity * $i->product->price);

                $order = Order::create([
                    'user_id'          => auth()->id(),
                    'order_number'     => 'ORD-' . strtoupper(Str::random(8)),
                    'total_amount'     => $total,
                    'shipping_name'    => $data['shipping_name'],
                    'shipping_phone'   => $data['shipping_phone'],
                    'shipping_address' => $data['shipping_address'],
                    'city'             => $data['city'],
                    'payment_method'   => 'cod',
                    'status'           => 'pending',
                ]);

                foreach ($items as $item) {
                    OrderDetail::create([
                        'order_id'   => $order->id,
                        'product_id' => $item->product_id,
                        'quantity'   => $item->quantity,
                        'size'       => $item->size,
                        'unit_price' => $item->product->price,
                    ]);
                    $item->product->decrement('stock', $item->quantity);
                }

                CartItem::where('user_id', auth()->id())->delete();

                return $order;
            });

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully! Your order number is ' . $order->order_number);

        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong while placing your order. Please try again.');
        }
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id() && !auth()->user()->isAdmin(), 403);
        $order->load('details.product');
        return view('orders.show', compact('order'));
    }
}
