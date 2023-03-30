<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory;

    protected $appends = ['url'];

    protected $fillable = [
        'path',
        'mime_type',
        'size',
        'attachmentable_type',
        'attachmentable_id',
        'user_id',
        'type'
    ];

    public function attachmentable() {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->attributes['path']);
    }
}
