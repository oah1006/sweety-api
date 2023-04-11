<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'stock',
        'price',
        'category_id',
        'user_id',
        'published'
    ];

    protected $with = [
        'attachment'
    ];

    public function items() {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function attachment() {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }
}
