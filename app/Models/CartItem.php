<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['user_id', 'product_id', 'quantity', 'size'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function subtotal(): float
    {
        return $this->quantity * $this->product->price;
    }
}
