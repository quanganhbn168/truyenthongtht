<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Slide;
use App\Models\Testimonial;
use App\Settings\BusinessSettings;
use App\Settings\HomepageSettings;

class HomeController extends Controller
{
    public function __construct(private readonly BusinessSettings $business) {}

    public function index()
    {
        $slides = Slide::where('is_active', true)->orderBy('sort_order')->get();
        $homepage = app(HomepageSettings::class);
        $intros = collect($homepage->intro_cards)->map(fn (array $card): object => (object) $card);
        $latestPosts = Post::where('is_active', true)->orderByDesc('published_at')->limit(3)->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->get();

        $projects = Project::with('category')->where('is_active', true)->where('is_featured', true)->orderBy('sort_order')->limit(6)->get();
        $projectCategories = ProjectCategory::where('is_active', true)->orderBy('sort_order')->get();

        $companyName = trim($this->business->company_name) ?: config('site.name', config('app.name'));

        return view('home', compact('homepage', 'slides', 'intros', 'latestPosts', 'testimonials', 'projects', 'projectCategories', 'companyName'))
            ->with('seoTitle', config('site.name', config('app.name')))
            ->with('seoDescription', config('site.description', 'Chuyên cung cấp dịch vụ truyền thông, quay phim, chụp ảnh chuyên nghiệp.'))
            ->with('ogType', 'website');
    }
}
