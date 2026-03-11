<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectCategory extends Model
{
    use HasSlug;
    protected $fillable = [
        'name', 'slug', 'parent_id', 'description', 'content',
        'image', 'thumbnail', 'banner', 'meta_title', 'meta_description',
        'keywords', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ProjectCategory::class, 'parent_id');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'category_id');
    }
}
