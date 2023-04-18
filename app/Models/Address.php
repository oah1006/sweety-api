<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street_number',
        'street',
        'ward_code',
        'district_code',
        'province_code',
        'name',
        'phone_number',
        'is_default',
        'customer_id',
        'long',
        'lat'
    ];

    protected $with = [
        'province'
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

    public function province() {
        return $this->belongsTo(Province::class);
    }
}
