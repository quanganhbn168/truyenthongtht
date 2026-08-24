<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /** Trang tất cả sản phẩm */
    public function index(Request $request)
    {
        $categories = ProductCategory::where('is_active', true)->orderBy('sort_order')->get();
        $query      = Product::where('is_active', true)->orderBy('sort_order');

        if ($request->category) {
            $cat = ProductCategory::where('slug', $request->category)->firstOrFail();

            // Canonical category URL được phục vụ bởi SlugController.
            return redirect()->to(url($cat->slug . '.html'), 301);
        }

        $products = $query->paginate(12);

        return view('pages.products', compact('products', 'categories'));
    }

    /** Gọi bởi SlugController khi record là Product */
    public function show(Product $product, Request $request)
    {
        $related  = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)->orderBy('sort_order')->limit(4)->get();
        $category = ProductCategory::find($product->category_id);

        return view('pages.product', compact('product', 'related', 'category'));
    }
}
