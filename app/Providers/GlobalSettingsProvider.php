<?php

namespace App\Providers;

use App\Settings\BusinessSettings;
use App\Settings\PageSettings;
use App\Settings\WebsiteSettings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class GlobalSettingsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Chỉ chia sẻ biến Settings cho giao diện Frontend thực sự.
        // Bỏ qua khi chạy console (artisan) hoặc trang Admin.
        if (! $this->app->runningInConsole() && ! request()->is('admin*')) {
            View::share('web', app(WebsiteSettings::class));
            View::share('page', app(PageSettings::class));
            View::share('business', app(BusinessSettings::class));
        }
    }
}
