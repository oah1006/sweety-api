<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'coupon_id',
        'delivery_address_id',
        'total',
        'sub_total',
        'status'
    ];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function deliveryAddress() {
        return $this->belongsTo(DeliveryAddress::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function staff() {
        return $this->belongsTo(Staff::class);
    }

    protected static function booted() {
        static::creating(function (Order $order) {
            do {
                $order->code = 'OD' . fake()->randomNumber(5, false);
            } while ($order->where('code', $order->code)->exists());
        });
    }
}
