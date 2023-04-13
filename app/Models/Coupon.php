<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'stock',
        'is_percent_value',
        'min_order_total',
        'status',
        'started_at',
        'expired_at',
        'is_deleted'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
        'started_at' => 'datetime:d-m-Y',
        'expired_at' => 'datetime:d-m-Y',
    ];

    public function order() {
        return $this->hasMany(Order::class);
    }

    protected static function booted() {
        static::creating(function (Coupon $coupon) {
            do {
                $coupon->code = 'CP' . fake()->randomNumber(5, false);
            } while ($coupon->where('code', $coupon->code)->exists());
        });
    }
}
