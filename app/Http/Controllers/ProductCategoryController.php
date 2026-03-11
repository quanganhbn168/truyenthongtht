<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function show(ProductCategory $category, Request $request)
    {
        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(12);

        return view('pages.product-category', compact('category', 'products'));
    }
}
