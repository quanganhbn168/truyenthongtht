<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Contact;
use App\Models\Intro;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Slide;
use App\Models\Tag;
use App\Models\Testimonial;
use App\Observers\ModelImageObserver;
use App\Observers\SlugObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class SlugServiceProvider extends ServiceProvider
{
    /**
     * All models that use the HasSlug trait.
     */
    private array $sluggableModels = [
        Post::class,
        PostCategory::class,
        Product::class,
        ProductCategory::class,
        Brand::class,
        Tag::class,
        Service::class,
        ServiceCategory::class,
        Project::class,
        ProjectCategory::class,
    ];

    /**
     * Models có FileUpload ảnh thông thường (disk: public_uploads).
     */
    private array $imageModels = [
        Post::class,
        PostCategory::class,
        Product::class,
        ProductCategory::class,
        Brand::class,
        Service::class,
        ServiceCategory::class,
        Project::class,
        ProjectCategory::class,
        Slide::class,
        Intro::class,
        Testimonial::class,
    ];

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
        Relation::morphMap([
            'post'             => Post::class,
            'post_category'    => PostCategory::class,
            'product'          => Product::class,
            'product_category' => ProductCategory::class,
            'brand'            => Brand::class,
            'tag'              => Tag::class,
            'slider'           => Slide::class,
            'contact'          => Contact::class,
            'service'          => Service::class,
            'service_category' => ServiceCategory::class,
            'project'          => Project::class,
            'project_category' => ProjectCategory::class,
        ]);

        foreach ($this->sluggableModels as $model) {
            $model::observe(SlugObserver::class);
        }

        foreach ($this->imageModels as $model) {
            $model::observe(ModelImageObserver::class);
        }
    }
}
