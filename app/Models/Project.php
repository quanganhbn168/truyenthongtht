<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasSlug;
    protected $fillable = [
        'category_id', 'name', 'slug', 'summary', 'content',
        'tvc_url', 'challenge', 'solution', 'gallery',
        'client_name', 'project_date', 'image', 'thumbnail',
        'hero_media_type', 'hero_media_url',
        'view_count', 'meta_title', 'meta_description', 'keywords',
        'sort_order', 'is_featured', 'is_active',
    ];

    protected $casts = [
        'project_date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'gallery' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'project_service');
    }
}
