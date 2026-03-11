<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasSlug;
    protected $fillable = [
        'name',
        'slug',
        'image',
        'thumbnail',
        'content',
        'meta_title',
        'meta_description',
        'keywords',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
