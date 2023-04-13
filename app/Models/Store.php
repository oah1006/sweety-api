<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'open_store',
        'close_store'
    ];

    public function staff() {
        return $this->hasMany(Staff::class);
    }

    public function address() {
        return $this->hasOne(Address::class);
    }

}
