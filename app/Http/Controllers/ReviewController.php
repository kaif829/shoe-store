<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // Must be logged in
        if (!auth()->check()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Please login to leave a review.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to leave a review.');
        }

        $data = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        Review::updateOrCreate(
            ['product_id' => $product->id, 'user_id' => auth()->id()],
            ['rating' => $data['rating'], 'comment' => $data['comment'] ?? null, 'is_approved' => true]
        );

        $product->recalculateRating();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully!',
                'avg_rating' => number_format($product->fresh()->avg_rating, 1),
                'review_count' => $product->fresh()->review_count,
            ]);
        }

        return back()->with('success', 'Review submitted successfully!');
    }

    public function destroy(Review $review)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ($review->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'You are not allowed to delete this review.');
        }

        $product = $review->product;
        $review->delete();
        $product->recalculateRating();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Review deleted.']);
        }

        return back()->with('success', 'Review removed successfully.');
    }
}
