<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'full_name',
        'is_active',
        'is_admin',
    ];

    public function user() {
        return $this->morphOne(User::class, 'profile');
    }
}
