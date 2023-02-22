<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
    ];

    public function user() {
        return $this->morphOne(User::class, 'profile');
    }

    protected static function booted() {
        static::deleted(function (Customer $customer) {
            $customer->user()->delete();
        });
    }
}
