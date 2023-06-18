<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_en',
        'full_name',
        'full_name_en',
        'code_name',
        'district_code',
        'administrative_unit_id'
    ];

    protected $primaryKey = 'code';

    public function district() {
        return $this->belongsTo(District::class);
    }

    public function address() {
        return $this->hasMany(Address::class);
    }
}
