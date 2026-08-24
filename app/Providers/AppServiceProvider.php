<?php

namespace App\Providers;

use App\Observers\MediaImageObserver;
use App\Models\CuratorMedia;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        CuratorMedia::observe(MediaImageObserver::class);
    }
}

