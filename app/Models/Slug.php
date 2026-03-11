<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Slug extends Model
{
    protected $fillable = ['slug', 'sluggable_type', 'sluggable_id'];

    public function sluggable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Resolve a slug string to its owning model.
     * Slug là globally unique → luôn trả về đúng một model.
     */
    public static function resolve(string $slug): ?Model
    {
        // 1. Thử truy vấn chính xác slug được truyền vào (có thể slug trong DB chứa sẵn đuôi .html)
        $record = static::where('slug', $slug)->first();

        // 2. Nếu không có, thử cắt đuôi .html đi và truy vấn lại
        // (Trường hợp URL người dùng gõ có .html nhưng DB lưu slug sạch)
        if (! $record) {
            $cleanSlug = preg_replace('/\.html$/i', '', $slug);
            if ($cleanSlug !== $slug) {
                $record = static::where('slug', $cleanSlug)->first();
            }
        }

        return $record?->sluggable;
    }
}
