<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Feature 5: Shopping Cart (Add/Remove/Update/View Total) via AJAX
    public function index()
    {
        $items = CartItem::with('product')->where('user_id', auth()->id())->get();
        $total = $items->sum(fn ($i) => $i->subtotal());

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'size' => 'nullable|string',
        ]);

        $product = Product::findOrFail($data['product_id']);

        if ($product->stock < ($data['quantity'] ?? 1)) {
            return response()->json(['success' => false, 'message' => 'Not enough stock available.'], 422);
        }

        $item = CartItem::firstOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $product->id, 'size' => $data['size'] ?? null],
            ['quantity' => 0]
        );
        $item->increment('quantity', $data['quantity'] ?? 1);

        $cartCount = CartItem::where('user_id', auth()->id())->sum('quantity');

        return response()->json(['success' => true, 'message' => 'Added to cart!', 'cart_count' => $cartCount]);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $this->authorizeOwner($cartItem);

        $data = $request->validate(['quantity' => 'required|integer|min:1']);
        $cartItem->update(['quantity' => $data['quantity']]);

        return response()->json([
            'success' => true,
            'subtotal' => number_format($cartItem->subtotal(), 2),
            'total' => number_format(CartItem::with('product')->where('user_id', auth()->id())->get()->sum(fn ($i) => $i->subtotal()), 2),
        ]);
    }

    public function remove(CartItem $cartItem)
    {
        $this->authorizeOwner($cartItem);
        $cartItem->delete();

        return response()->json(['success' => true, 'message' => 'Item removed from cart.']);
    }

    private function authorizeOwner(CartItem $cartItem): void
    {
        abort_if($cartItem->user_id !== auth()->id(), 403);
    }
}
