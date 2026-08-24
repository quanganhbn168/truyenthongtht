<?php

namespace App\Models;

use App\Traits\HasSlug;
use Datlechin\FilamentMenuBuilder\Contracts\MenuPanelable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostCategory extends Model implements MenuPanelable
{
    use HasSlug;
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'description',
        'show_home',
        'show_home2',
        'show_menu',
        'show_footer',
        'image',
        'thumbnail',
        'view_count',
        'content',
        'meta_title',
        'meta_description',
        'keywords',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'show_home' => 'boolean',
        'show_home2' => 'boolean',
        'show_menu' => 'boolean',
        'show_footer' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(PostCategory::class, 'parent_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function getMenuPanelName(): string
    {
        return 'Danh mục bài viết';
    }

    public function getMenuPanelTitle(): string
    {
        return (string) $this->name;
    }

    public function getMenuPanelUrl(): string
    {
        return '/' . ltrim((string) $this->slug, '/') . '.html';
    }

    public function getMenuPanelQuery(): Builder
    {
        return $this->newQuery()
            ->where('is_active', true)
            ->orderBy('sort_order');
    }
}
