<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /** Trang tất cả dự án / công trình */
    public function index(Request $request)
    {
        $categories = ProjectCategory::where('is_active', true)->orderBy('sort_order')->get();
        $projects   = Project::where('is_active', true)->orderByDesc('created_at')->paginate(12)->onEachSide(1);

        return view('pages.projects', compact('projects', 'categories'));
    }

    /** Gọi bởi Slash-Link filter khi User Click vào Tabs */
    public function category(\App\Models\ProjectCategory $category, Request $request)
    {
        $categories = \App\Models\ProjectCategory::where('is_active', true)->orderBy('sort_order')->get();

        $projects = Project::where('category_id', $category->id)
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->paginate(12)
            ->onEachSide(1);

        return view('pages.projects', compact('projects', 'categories', 'category'));
    }

    /** Gọi bởi SlugController khi record là Project */
    public function show(Project $project, Request $request)
    {
        $project->load('category', 'services');
        
        // Lấy danh sách ID dịch vụ của dự án hiện tại
        $serviceIds = $project->services->pluck('id')->toArray();

        // Lấy các dự án có chung ít nhất 1 dịch vụ (ngoại trừ dự án hiện tại)
        $relatedQuery = Project::where('id', '!=', $project->id)->where('is_active', true);
        
        if (!empty($serviceIds)) {
            $relatedQuery->whereHas('services', function($q) use ($serviceIds) {
                $q->whereIn('services.id', $serviceIds);
            });
        } else {
            // Fallback: Nếu không có dịch vụ nào, load theo category cũ
            $relatedQuery->where('category_id', $project->category_id);
        }

        $related = $relatedQuery->orderBy('sort_order')->limit(4)->get();
        $category = $project->category;

        return view('pages.project', compact('project', 'related', 'category'));
    }
}
