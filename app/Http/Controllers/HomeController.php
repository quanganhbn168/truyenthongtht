<?php

namespace App\Http\Controllers;

use App\Models\Intro;
use App\Models\Post;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Testimonial;
use App\Models\Slide;

class HomeController extends Controller
{
    public function index()
    {
        $slides       = Slide::where('is_active', true)->orderBy('sort_order')->get();
        $intros       = Intro::where('is_active', true)->orderBy('sort_order')->get();
        $services     = ServiceCategory::where('is_active', true)->whereNull('parent_id')->orderBy('sort_order')->limit(6)->get();
        $latestPosts  = Post::where('is_active', true)->orderByDesc('published_at')->limit(3)->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->get();
        
        $projects           = Project::with('category')->where('is_active', true)->where('is_featured', true)->orderBy('sort_order')->limit(6)->get();
        $projectCategories  = ProjectCategory::where('is_active', true)->orderBy('sort_order')->get();

        return view('home', compact('slides', 'intros', 'services', 'latestPosts', 'testimonials', 'projects', 'projectCategories'))
            ->with('seoTitle', config('site.name', config('app.name')))
            ->with('seoDescription', config('site.description', 'Chuyên cung cấp dịch vụ truyền thông, quay phim, chụp ảnh chuyên nghiệp.'))
            ->with('ogType', 'website')
            ->with('schemaType', 'Organization');
    }
}
