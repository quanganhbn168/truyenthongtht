<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;

class ProjectCategoryController extends Controller
{
    public function show(ProjectCategory $category, Request $request)
    {
        $projects = Project::where('category_id', $category->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(12);

        return view('pages.project-category', compact('category', 'projects'));
    }
}
