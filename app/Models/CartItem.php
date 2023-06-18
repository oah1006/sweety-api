<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_variant_id',
        'cart_id',
        'product_id',
        'qty',
    ];

    protected $with = ['product', 'productVariant'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function cartItemOptions() {
        return $this->hasMany(CartItemOption::class);
    }

    public function cart() {
        return $this->belongsTo(Cart::class);
    }

    public function ProductVariant() {
        return $this->belongsTo(ProductVariant::class);
    }

    protected static function booted() {
        static::creating(function (CartItem $cartItem) {
            $productVariant = ProductVariant::where('id', $cartItem->product_variant_id)->first();

            $cartItem->product_id = $productVariant->product->id;
        });
    }
}
