<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_type',
        'file_size',
        'file_path',
        'relationship_table_type',
        'relationship_table_id',
        'user_id'
    ];

    public function relationship_table() {
        return $this->morphTo();
    }
}


