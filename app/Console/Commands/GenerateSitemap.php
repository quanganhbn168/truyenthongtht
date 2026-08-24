<?php

namespace App\Console\Commands;

use App\Http\Controllers\SitemapController;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    protected $signature = 'seo:sitemap:generate {--path= : Full output path; defaults to public/sitemap.xml}';

    protected $description = 'Generate the public XML sitemap from indexable content';

    public function handle(SitemapController $controller): int
    {
        $path = $this->option('path') ?: public_path('sitemap.xml');

        $controller->index()->writeToFile($path);

        $this->components->info('Sitemap generated: '.$path);

        return self::SUCCESS;
    }
}
