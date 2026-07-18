<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function toggleApproval(Review $review)
    {
        $review->update(['is_approved' => ! $review->is_approved]);
        $review->product->recalculateRating();

        return back()->with('success', 'Review status updated.');
    }

    public function destroy(Review $review)
    {
        $product = $review->product;
        $review->delete();
        $product->recalculateRating();

        return back()->with('success', 'Review deleted.');
    }
}
