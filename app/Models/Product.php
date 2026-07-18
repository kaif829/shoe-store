<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'brand', 'gender', 'activity_type',
        'size_range', 'price', 'stock', 'image', 'description',
        'avg_rating', 'review_count', 'is_featured',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Scopes for search & filter (FR-04, FR-05)
    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['search'] ?? null, fn ($q, $v) => $q->where('name', 'like', "%{$v}%")->orWhere('brand', 'like', "%{$v}%"))
            ->when($filters['brand'] ?? null, fn ($q, $v) => $q->where('brand', $v))
            ->when($filters['gender'] ?? null, fn ($q, $v) => $q->where('gender', $v))
            ->when($filters['activity_type'] ?? null, fn ($q, $v) => $q->where('activity_type', $v))
            ->when($filters['min_price'] ?? null, fn ($q, $v) => $q->where('price', '>=', $v))
            ->when($filters['max_price'] ?? null, fn ($q, $v) => $q->where('price', '<=', $v))
            ->when($filters['category_id'] ?? null, fn ($q, $v) => $q->where('category_id', $v));
    }

    public function recalculateRating(): void
    {
        $this->update([
            'avg_rating' => $this->reviews()->where('is_approved', true)->avg('rating') ?? 0,
            'review_count' => $this->reviews()->where('is_approved', true)->count(),
        ]);
    }
}
