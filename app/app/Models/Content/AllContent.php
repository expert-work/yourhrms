<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'keywords',
        'meta_image',
        'created_by',
        'updated_by',
    ];
}
