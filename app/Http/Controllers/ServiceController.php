<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /** Trang tất cả dịch vụ */
    public function index(Request $request)
    {
        // Tải danh mục cha kèm theo các dịch vụ đang hoạt động bên trong nó
        $categories = ServiceCategory::with(['services' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            }])
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return view('services.index', compact('categories'));
    }

    /** Trang danh mục dịch vụ — gọi bởi SlugController khi record là ServiceCategory */
    public function category(ServiceCategory $category, Request $request)
    {
        $services = Service::with('category')
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(12);

        $allCategories = ServiceCategory::where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return view('services.category', compact('category', 'services', 'allCategories'));
    }

    /** Trang chi tiết dịch vụ — gọi bởi SlugController khi record là Service */
    public function show(Service $service, Request $request)
    {
        $service->load('posts', 'category');

        $related = Service::where('category_id', $service->category_id)
            ->where('id', '!=', $service->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        $category = $service->category;

        return view('services.show', compact('service', 'related', 'category'));
    }
}
