<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemOptions extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'topping_id',
        'qty',
        'price'
    ];

    protected $with = ['topping'];

    public function orderItem() {
        return $this->belongsTo(OrderItem::class);
    }

    public function topping() {
        return $this->belongsTo(Topping::class);
    }
}
