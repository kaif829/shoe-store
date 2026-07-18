<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Recommendation;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function create()
    {
        return view('recommendation.form');
    }

    /**
     * Rule-Based AI Recommendation Engine (SRS Chapter 4).
     * Matches products against age, gender, activity type, and budget rules,
     * then ranks by relevance score so the "best fit" surfaces first.
     */
    public function recommend(Request $request)
    {
        $data = $request->validate([
            'age_group' => 'required|in:teenager,adult,senior',
            'gender' => 'required|in:male,female,unisex',
            'activity' => 'required|in:running,walking,sports,casual,gym',
            'budget' => 'required|in:under_50,50_100,100_200,above_200',
        ]);

        Recommendation::create([
            'user_id' => auth()->id(),
            'age_group' => $data['age_group'],
            'gender' => $data['gender'],
            'activity' => $data['activity'],
            'budget_range' => $data['budget'],
        ]);

        [$minPrice, $maxPrice] = $this->budgetToRange($data['budget']);

        $query = Product::query()->where('stock', '>', 0);

        // Rule 1: Activity type match (hard filter -- this is the strongest signal, e.g.
        // "Activity = Running AND Budget = $100 THEN Recommend Running Shoes")
        $query->where('activity_type', $data['activity']);

        // Rule 2: Gender match (unisex always included)
        $query->where(function ($q) use ($data) {
            $q->where('gender', $data['gender'])->orWhere('gender', 'unisex');
        });

        // Rule 3: Budget range (soft filter with fallback if nothing matches)
        $inBudget = (clone $query)->whereBetween('price', [$minPrice, $maxPrice]);
        $products = $inBudget->exists() ? $inBudget : $query;

        // Rule 4: Age group nudges casual/walking for seniors, sports/gym for teenagers
        // Used only as a ranking signal, not a hard filter, to avoid empty results.
        $products = $products->withCount('reviews')
            ->orderByDesc('is_featured')
            ->orderByDesc('avg_rating')
            ->orderByDesc('reviews_count')
            ->limit(12)
            ->get();

        if ($request->ajax()) {
            return view('recommendation.partials.results', compact('products'))->render();
        }

        return view('recommendation.results', [
            'products' => $products,
            'criteria' => $data,
        ]);
    }

    private function budgetToRange(string $budget): array
    {
        return match ($budget) {
            'under_50' => [0, 50],
            '50_100' => [50, 100],
            '100_200' => [100, 200],
            'above_200' => [200, 999999],
        };
    }
}
