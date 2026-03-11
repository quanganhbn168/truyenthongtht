<?php

namespace App\Models;

use App\Traits\HasSlug;
use Datlechin\FilamentMenuBuilder\Contracts\MenuPanelable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model implements MenuPanelable
{
    use HasSlug;
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'category_id',
        'image',
        'thumbnail',
        'content',
        'published_at',
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
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function services(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'post_service');
    }

    public function getMenuPanelName(): string
    {
        return 'Bài viết';
    }

    public function getMenuPanelTitleColumn(): string
    {
        return 'title';
    }

    public function getMenuPanelUrlUsing(): callable
    {
        return fn (self $record) => '/' . ltrim($record->slug, '/') . '.html';
    }

    public function getMenuPanelModifyQueryUsing(): callable
    {
        return fn ($query) => $query->where('is_active', true)->orderByDesc('published_at')->limit(100);
    }
}
