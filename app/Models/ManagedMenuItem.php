<?php

namespace App\Models;

use Datlechin\FilamentMenuBuilder\Models\MenuItem;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManagedMenuItem extends MenuItem
{
    protected static function booted(): void
    {
        parent::booted();
        static::creating(function (self $item): void {
            if (! $item->menu_id && $item->parent_id) {
                $item->menu_id = self::query()->whereKey($item->parent_id)->value('menu_id');
            }
        });
    }

    protected function casts(): array
    {
        return ['order' => 'integer'];
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(ManagedMenu::class, 'menu_id');
    }

    protected function url(): Attribute
    {
        return Attribute::get(function (?string $value): ?string {
            if (! $this->linkable_type) {
                return $value;
            }
            $record = $this->linkable;
            if (! $record || ! $record->is_active) {
                return '#';
            }
            if ($record instanceof Intro) {
                return $record->getMenuPanelUrl();
            }

            return $record->slug ? url($record->slug.'.html') : '#';
        });
    }
}
