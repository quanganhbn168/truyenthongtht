<?php

namespace App\Providers;

use App\View\Composers\MenuComposer;
use App\View\Composers\SeoComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // SEO meta variables cho tất cả views dùng layouts.master
        View::composer('layouts.master', SeoComposer::class);

        // Header + footer menu
        View::composer([
            'layouts.partials.header',
            'layouts.partials.footer',
        ], MenuComposer::class);
    }
}
