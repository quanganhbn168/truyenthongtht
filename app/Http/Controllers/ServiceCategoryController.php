<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    /** Gọi bởi SlugController khi record là ServiceCategory */
    public function show(ServiceCategory $category, Request $request)
    {
        $services = Service::where('category_id', $category->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(12);

        return view('pages.service-category', compact('category', 'services'));
    }
}
