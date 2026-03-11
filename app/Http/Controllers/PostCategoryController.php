<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    /** Gọi bởi SlugController khi record là PostCategory */
    public function show(PostCategory $category, Request $request)
    {
        $posts = Post::where('category_id', $category->id)
            ->where('is_active', true)
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('posts.category', compact('category', 'posts'));
    }
}
