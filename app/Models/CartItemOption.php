<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItemOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_item_id',
        'topping_id',
        'qty',
    ];

    protected $with = ['topping'];

    public function cartItem() {
        return $this->belongsTo(CartItem::class);
    }

    public function topping() {
        return $this->belongsTo(Topping::class);
    }
}
