<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    /** @use HasFactory<\Database\Factories\SlideFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'link',
        'image',
        'position',
        'status',
    ];

    /**
     * Lấy ảnh đầy đủ path (nếu dùng asset)
     */
    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset($this->image) : asset('images/setting/no-image.png');
    }

    /**
     * Scope lọc slide đang bật
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
