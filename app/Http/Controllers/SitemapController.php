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
            route('home'),
            route('about'),
            route('contact.index'),
            route('posts.index'),
            route('services.index'),
            route('products.index'),
            route('projects.index'),
            route('quote.index'),
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
        return url(str_ends_with($slug, '.html') ? $slug : $slug . '.html');
    }
}
