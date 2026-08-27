<?php

namespace App\Providers;

use App\Settings\WebsiteSettings;
use App\Support\Branding\FaviconService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class FaviconServiceProvider extends ServiceProvider
{
    public function boot(FaviconService $favicons): void
    {
        View::composer('layouts.master', function ($view) use ($favicons): void {
            $view->with('faviconLinks', $favicons->links(app(WebsiteSettings::class)->site_favicon));
        });
    }
}
