<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'gender',
        'points'
    ];

    protected $with = ['address', 'order'];

    public function user() {
        return $this->morphOne(User::class, 'profile');
    }

    public function order() {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function cart() {
        return $this->hasOne(Cart::class);
    }

    public function couponCustomers() {
        return $this->hasMany(CouponCustomer::class);
    }

    protected static function booted() {
        static::deleted(function (Customer $customer) {
            $customer->user()->delete();
        });

        static::creating(function (Customer $customer) {
            do {
                $customer->code = 'KH' . fake()->randomNumber(5, false);
            } while ($customer->where('code', $customer->code)->exists());
        });
    }

    public function address() {
        return $this->hasMany(Address::class, 'customer_id');
    }
}
