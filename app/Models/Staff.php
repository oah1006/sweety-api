<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'is_active',
        'role',
        'store_id'
    ];

    protected $with = [
        'attachment'
    ];

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function user() {
        return $this->morphOne(User::class, 'profile');
    }

    protected static function booted() {
        static::creating(function (Staff $staff) {
            do {
                $staff->code = 'NV' . fake()->randomNumber(5, false);
            } while($staff->where('code', $staff->code)->exists());
        });

        static::deleted(function (Staff $staff) {
            $staff->user()->delete();
            $staff->attachment()->delete();
        });
    }

    public function attachment() {
        return $this->morphOne(Attachment::class, 'attachmentable');
    }

}
