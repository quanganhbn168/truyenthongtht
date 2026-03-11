<?php

namespace App\Providers;

use App\Observers\MediaImageObserver;
use Awcodes\Curator\Models\Media;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Media::observe(MediaImageObserver::class);
    }
}


