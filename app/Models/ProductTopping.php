<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTopping extends Model
{
    use HasFactory;

    protected $fillable = [
        'topping_id',
        'product_id',
    ];

    protected $with = ['topping', 'product'];

    public function topping() {
        return $this->belongsTo(Topping::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
