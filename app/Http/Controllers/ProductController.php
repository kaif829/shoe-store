<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // FR-03, FR-04, FR-05: Product viewing, search, filtering, pagination
    public function index(Request $request)
    {
        $products = Product::filter($request->only([
                'search', 'brand', 'gender', 'activity_type', 'min_price', 'max_price', 'category_id',
            ]))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::all();
        $brands = Product::distinct()->pluck('brand');

        if ($request->ajax()) {
            return view('products.partials.grid', compact('products'))->render();
        }

        return view('products.index', compact('products', 'categories', 'brands'));
    }

    public function show(Product $product)
    {
        $product->load(['reviews.user' => fn ($q) => $q->latest()]);
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
