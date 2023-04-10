<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'name',
        'phone_number',
        'is_default',
        'customer_id'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function order() {
        return $this->hasMany(Order::class, 'delivery_address_id');
    }
}
