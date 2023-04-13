<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_number',
        'street',
        'ward',
        'district',
        'city',
        'name',
        'phone_number',
        'is_default',
        'customer_id'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function staff() {
        return $this->belongsTo(Staff::class);
    }

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function order() {
        return $this->hasMany(Order::class, 'address_id');
    }
}
