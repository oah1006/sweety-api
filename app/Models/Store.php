<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_name',
        'open_store',
        'close_store',
        'address_id'
    ];

    protected $casts = [
        'open_store' => 'datetime:H:i',
        'close_store' => 'datetime:H:i',
    ];

    protected $with = [
        'address',
        'attachment'
    ];

    public function staff() {
        return $this->hasMany(Staff::class);
    }

    public function address() {
        return $this->hasOne(Address::class);
    }

    public function attachment() {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

}
