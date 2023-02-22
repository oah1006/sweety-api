<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'mime_type',
        'size',
        'attachmentable_type',
        'attachmentable_id',
        'user_id'
    ];

    public function attachmentable() {
        return $this->morphTo();
    }
}
