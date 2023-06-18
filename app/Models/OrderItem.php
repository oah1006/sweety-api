<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'unit_price',
        'product_variant_id'
    ];

    protected $with = [
        'product',
        'productVariant',
        'orderItemOptions'
    ];

    protected static function booted() {
        static::saving(function (OrderItem $orderItem) {
            $product = Product::where('id', $orderItem->product_id)->first();

            $orderItem->unit_price = $product->price;
        });
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function ProductVariant() {
        return $this->belongsTo(ProductVariant::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function orderItemOptions() {
        return $this->hasMany(OrderItemOptions::class);
    }
}
