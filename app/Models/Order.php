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
        'address_id',
        'store_id',
        'delivery_staff_id',
        'sale_staff_id',
        'customer_id',
        'total',
        'sub_total',
        'status',
        'shipping_fee',
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y h:m',
        'updated_at' => 'datetime:d-m-Y',
    ];

    protected $with = ['items'];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function orderTrackings() {
        return $this->hasMany(OrderTracking::class);
    }

    public function address() {
        return $this->belongsTo(Address::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function saleStaff() {
        return $this->belongsTo(Staff::class, 'sale_staff_id');
    }

    public function deliveryStaff() {
        return $this->belongsTo(Staff::class, 'delivery_staff_id');
    }

    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }

    public function calculateSubTotal() {
        $this->sub_total = $this->items->sum(function ($items) {
            return $items['unit_price'] * $items['qty'];
        });
    }

    public function calculateTotal() {
        if ($this->coupon_id) {
            $coupon = Coupon::where('id', $this->coupon_id)->first();
            $this->total = ($this->sub_total - ($coupon->is_percent_value / 100 * $this->sub_total)) + $this->shipping_fee;
        } else {
            $this->total = $this->sub_total + $this->shipping_fee;
        }
    }

    protected static function booted() {
        static::creating(function (Order $order) {
            do {
                $order->code = 'ODR' . fake()->randomNumber(5, false);
            } while ($order->where('code', $order->code)->exists());
        });
    }


}
