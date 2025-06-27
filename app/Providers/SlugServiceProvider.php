<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Service;
use App\Models\Project;
use App\Observers\SlugObserver;
class SlugServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Product::observe(SlugObserver::class);
        Category::observe(SlugObserver::class);
        Service::observe(SlugObserver::class);
        Project::observe(SlugObserver::class);
    }
}
