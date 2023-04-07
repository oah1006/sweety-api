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
}
