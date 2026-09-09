<?php

namespace App\Models;

use Datlechin\FilamentMenuBuilder\Models\Menu;
use Datlechin\FilamentMenuBuilder\Models\MenuLocation;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ManagedMenu extends Menu
{
    public function topLevelItems(): HasMany
    {
        return $this->hasMany(ManagedMenuItem::class, 'menu_id')->whereNull('parent_id')->orderBy('order');
    }

    public function menuItems(): HasMany
    {
        return $this->topLevelItems()->with('children');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ManagedMenuItem::class, 'menu_id');
    }

    public function locations(): HasMany
    {
        return $this->hasMany(MenuLocation::class, 'menu_id');
    }
}
