<?php

namespace App\Http\Controllers;

use App\Models\Slug;

class SlugController extends Controller
{
    public function resolve($slug)
    {
        $slugModel = Slug::where('slug', $slug)->firstOrFail();
        $model = $slugModel->sluggable;

        return match (get_class($model)) {
            \App\Models\Product::class         => $this->detailProduct($model),
            \App\Models\Service::class         => $this->detailService($model),
            \App\Models\Project::class         => $this->detailProject($model),
            \App\Models\Post::class            => $this->detailPost($model),
            \App\Models\Category::class        => $this->productByCategory($model),
            \App\Models\ServiceCategory::class => $this->serviceByCategory($model),
            \App\Models\PostCategory::class    => $this->postByCategory($model),
            default                            => abort(404),
        };
    }

    protected function detailProduct($product)
    {
        $category = $product->category()->select('id', 'name', 'slug', 'parent_id')->firstOrFail();
        $relatedProduct = Product::whereNot("id",$product->id)->where("category_id",$category->id)->get();
        return view('frontend.product.detail', compact('product','category',));
    }

    protected function detailService($service)
    {
        $category = $service->category;
        return view('frontend.services.detail', compact('service','category'));
    }

    protected function detailProject($project)
    {
        return view('frontend.project.detail', compact('project'));
    }

    protected function detailPost($post)
    {
        return view('frontend.post.detail', compact('post'));
    }

    protected function productByCategory($category)
    {
        $products = $category->products()->where("status",1)->get();
        return view('frontend.product.byCategory', compact('category'));
    }

    protected function serviceByCategory($service)
    {   
        if($service->slug == "tieng-trung-doanh-nghiep")
        {
            return view("frontend.tiengtrungdoanhnghiep");
        }
        $category = $service;
        return view('frontend.services.serviceByCate', compact('category'));
    }

    protected function postByCategory($category)
    {
        if($category->slug == "tieng-trung-doanh-nghiep")
        {
            return view("tiengtrungdoanhnghiep.html");
        }
    // Lấy tất cả danh mục để hiển thị ở sidebar
        $allCategories = \App\Models\PostCategory::where('status', 1)->get();

    // Nếu là danh mục cha thì lấy thêm bài viết từ danh mục con
        if ($category->parent_id === 0) {
            $categoryIds = \App\Models\PostCategory::where('parent_id', $category->id)->pluck('id')->toArray();
            $categoryIds[] = $category->id;
        } else {
            $categoryIds = [$category->id];
        }

    // Lấy danh sách bài viết thuộc các danh mục đã xác định
        $posts = \App\Models\Post::whereIn('post_category_id', $categoryIds)
        ->where('status', 1)
        ->latest()
        ->paginate(10);

    // Các bài viết nổi bật: lấy 5 bài mới nhất (tùy chỉnh thêm điều kiện nếu cần)
        $featuredPosts = \App\Models\Post::where('status', 1)
        ->latest('updated_at')
        ->limit(5)
        ->get();

        return view('frontend.post.postByCate', [
            'category' => $category,
            'posts' => $posts,
            'allCategories' => $allCategories,
            'featuredPosts' => $featuredPosts,
        ]);
        return view('frontend.post.postByCate', compact('category','posts'));
    }
}
