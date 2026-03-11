<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\ProjectCategory;
use App\Models\PostCategory;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];
        
        // 1. Static Routes
        $staticRoutes = [
            route('home'),
            route('about'),
            route('contact.index'),
            route('posts.index'),
            route('services.index'),
            route('products.index'),
            route('projects.index'),
        ];
        
        foreach ($staticRoutes as $route) {
            $urls[] = [
                'loc' => $route,
                'lastmod' => now()->tz('UTC')->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ];
        }

        // 2. Services
        $services = Service::where('is_active', true)->get();
        foreach ($services as $service) {
            $urls[] = [
                'loc' => url($service->slug . '.html'),
                'lastmod' => $service->updated_at->tz('UTC')->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ];
        }

        // 3. Projects
        $projects = Project::where('is_active', true)->get();
        foreach ($projects as $project) {
            $urls[] = [
                'loc' => url($project->slug . '.html'),
                'lastmod' => $project->updated_at->tz('UTC')->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
        }
        
        // 4. Posts
        $posts = Post::where('is_published', true)->get();
        foreach ($posts as $post) {
            $urls[] = [
                'loc' => url($post->slug . '.html'),
                'lastmod' => $post->updated_at->tz('UTC')->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }
        
        // 5. Categories (Projects & Posts)
        $projectCats = ProjectCategory::where('is_active', true)->get();
        foreach ($projectCats as $cat) {
            $urls[] = [
                'loc' => url($cat->slug . '.html'),
                'lastmod' => $cat->updated_at->tz('UTC')->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
        }

        $postCats = PostCategory::where('is_active', true)->get();
        foreach ($postCats as $cat) {
            $urls[] = [
                'loc' => url($cat->slug . '.html'),
                'lastmod' => $cat->updated_at->tz('UTC')->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
        }

        return response()->view('sitemap', [
            'urls' => $urls
        ])->header('Content-Type', 'text/xml');
    }
}
