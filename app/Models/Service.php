<?php

namespace App\Models;

use App\Traits\HasSlug;
use Datlechin\FilamentMenuBuilder\Contracts\MenuPanelable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model implements MenuPanelable
{
    use HasSlug;
    protected $fillable = [
        'category_id', 'name', 'slug', 'summary', 'content',
        'pain_points', 'benefits', 'behind_the_scenes', 'process', 'faq',
        'price', 'packages', 'image', 'thumbnail', 'published_at', 'view_count',
        'meta_title', 'meta_description', 'keywords',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_active' => 'boolean',
        'price' => 'decimal:0',
        'process' => 'array',
        'faq' => 'array',
        'packages' => 'array',
        'behind_the_scenes' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_service');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_service');
    }

    public function getMenuPanelName(): string
    {
        return 'Dịch vụ';
    }

    public function getMenuPanelTitleColumn(): string
    {
        return 'name';
    }

    public function getMenuPanelUrlUsing(): callable
    {
        return fn (self $record) => '/' . ltrim($record->slug, '/') . '.html';
    }

    public function getMenuPanelModifyQueryUsing(): callable
    {
        return fn ($query) => $query->where('is_active', true)->orderBy('sort_order');
    }
}
