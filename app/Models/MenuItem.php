<?php

namespace App\Models;

use App\Enums\MenuItemType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_id',
        'parent_id',
        'title',
        'type',
        'url',
        'target',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'type'      => MenuItemType::class,
    ];

    protected static function boot(): void
    {
        parent::boot();

        // Khi tạo item con trong nested Repeater, tự kế thừa menu_id từ parent
        static::creating(function (self $item) {
            if ($item->parent_id && empty($item->menu_id)) {
                $item->menu_id = static::where('id', $item->parent_id)->value('menu_id');
            }
        });
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort_order');
    }
}
