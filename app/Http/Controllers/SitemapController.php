<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\ServiceCategory;
use Carbon\CarbonImmutable;
use DateTimeInterface;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index(): Sitemap
    {
        $sitemap = Sitemap::create();

        foreach ($this->staticUrls() as $url) {
            $this->addUrl($sitemap, $url, now()->tz('UTC'), Url::CHANGE_FREQUENCY_DAILY, 1.0);
        }

        $this->addModels($sitemap, Service::where('is_active', true)->get(), 'weekly', 0.9);
        $this->addModels($sitemap, Project::where('is_active', true)->get(), 'monthly', 0.8);
        $this->addModels($sitemap, Post::where('is_active', true)->get(), 'monthly', 0.7);

        $this->addModels($sitemap, ProjectCategory::where('is_active', true)->get(), 'weekly', 0.6);
        $this->addModels($sitemap, PostCategory::where('is_active', true)->get(), 'weekly', 0.6);
        $this->addModels($sitemap, ServiceCategory::where('is_active', true)->get(), 'weekly', 0.7);
        $this->addModels($sitemap, ProductCategory::where('is_active', true)->get(), 'weekly', 0.6);
        $this->addModels($sitemap, Product::where('is_active', true)->get(), 'monthly', 0.7);

        return $sitemap;
    }

    /**
     * @return list<string>
     */
    private function staticUrls(): array
    {
        return [
            $this->routeUrl('home'),
            $this->routeUrl('about'),
            $this->routeUrl('contact.index'),
            $this->routeUrl('posts.index'),
            $this->routeUrl('services.index'),
            $this->routeUrl('products.index'),
            $this->routeUrl('projects.index'),
            $this->routeUrl('quote.index'),
        ];
    }

    private function addModels(Sitemap $sitemap, iterable $models, string $changeFrequency, float $priority): void
    {
        foreach ($models as $model) {
            $this->addUrl(
                $sitemap,
                $this->urlForSlug($model->slug),
                $model->updated_at ?? $model->created_at ?? now(),
                $changeFrequency,
                $priority,
            );
        }
    }

    private function addUrl(
        Sitemap $sitemap,
        string $url,
        DateTimeInterface $lastModified,
        string $changeFrequency,
        float $priority,
    ): void {
        $sitemap->add(
            Url::create($url)
                ->setLastModificationDate(CarbonImmutable::instance($lastModified)->utc())
                ->setChangeFrequency($changeFrequency)
                ->setPriority($priority),
        );
    }

    private function urlForSlug(string $slug): string
    {
        return $this->absolutePath(str_ends_with($slug, '.html') ? $slug : $slug.'.html');
    }

    private function routeUrl(string $name): string
    {
        return $this->absolutePath(route($name, [], false));
    }

    private function absolutePath(string $path): string
    {
        $baseUrl = rtrim((string) config('app.url'), '/');

        return $path === '/'
            ? $baseUrl.'/'
            : $baseUrl.'/'.ltrim($path, '/');
    }
}
