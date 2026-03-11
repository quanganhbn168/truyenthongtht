<?php

namespace App\Traits;

use App\Models\Slug;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;

/**
 * Trait HasSlug
 *
 * Add to any model that needs SEO-friendly slug resolution.
 * The model must have a `slug` column (used as source).
 * Observer is registered in AppServiceProvider.
 */
trait HasSlug
{
    public function slugRecord(): MorphOne
    {
        return $this->morphOne(Slug::class, 'sluggable');
    }

    /**
     * The column used as the slug source. Override if needed.
     */
    public function getSlugSourceColumn(): string
    {
        return 'slug';
    }

    /**
     * Generate a slug from the given name/title.
     * Appends .html suffix for SEO preservation.
     */
    public static function generateSlug(string $value, string $suffix = '.html'): string
    {
        return Str::slug($value) . $suffix;
    }
}
