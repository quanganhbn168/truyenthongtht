<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasSlug;
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'summary',
        'content',
        'original_price',
        'price',
        'image',
        'thumbnail',
        'published_at',
        'is_bestseller',
        'view_count',
        'meta_title',
        'meta_description',
        'keywords',
        'sort_order',
        'is_active',
        'tags',
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_bestseller' => 'boolean',
        'is_active' => 'boolean',
        'original_price' => 'decimal:0',
        'price' => 'decimal:0',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
}
