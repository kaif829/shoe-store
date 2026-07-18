<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Wishlist::with('product')->where('user_id', auth()->id())->get();
        return view('products.wishlist', compact('items'));
    }

    public function toggle(Product $product)
    {
        $existing = Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['success' => true, 'status' => 'removed']);
        }

        Wishlist::create(['user_id' => auth()->id(), 'product_id' => $product->id]);
        return response()->json(['success' => true, 'status' => 'added']);
    }
}
