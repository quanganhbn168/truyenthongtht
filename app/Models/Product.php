<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'image',
        'banner',
        'price',
        'price_discount',
        'description',
        'content',
        'status',
    ];

    protected $casts = [
        'price' => 'float',
        'price_discount' => 'float',
        'status' => 'boolean',
        'is_featured' => 'boolean',
        'is_on_sale' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . Str::random(5);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
