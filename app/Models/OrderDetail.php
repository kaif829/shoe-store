<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    // order_details table has no timestamps columns
    public $timestamps = false;

    protected $fillable = ['order_id', 'product_id', 'quantity', 'size', 'unit_price'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
