<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /** Trang danh sách tất cả bài viết */
    public function index(Request $request)
    {
        $category   = null;
        $categories = PostCategory::where('is_active', true)->orderBy('sort_order')->get();

        $query = Post::where('is_active', true)->orderByDesc('published_at');

        if ($request->category) {
            $category = PostCategory::where('slug', $request->category)->firstOrFail();

            // Danh mục có URL slug riêng. Giữ query cũ bằng 301 để tránh
            // /tin-tuc.html?category=... cạnh tranh với /danh-muc.html.
            return redirect()->to(url($category->slug . '.html'), 301);
        }

        $posts = $query->paginate(13)->onEachSide(1);

        return view('posts.index', compact('posts', 'categories', 'category'));
    }

    /** Gọi bởi SlugController khi record là PostCategory */
    public function category(\App\Models\PostCategory $category, Request $request)
    {
        $categories = \App\Models\PostCategory::where('is_active', true)->orderBy('sort_order')->get();

        $posts = Post::where('category_id', $category->id)
            ->where('is_active', true)
            ->orderByDesc('published_at')
            ->paginate(13)
            ->onEachSide(1);

        return view('posts.index', compact('posts', 'categories', 'category'));
    }

    /** Gọi bởi SlugController khi record là Post */
    public function show(Post $post, Request $request)
    {
        // Chỉ tính view một lần per session per bài
        $sessionKey = 'viewed_post_' . $post->id;
        if (! $request->session()->has($sessionKey)) {
            $post->increment('view_count');
            $request->session()->put($sessionKey, true);
        }

        // Inject id vào heading h2/h3 để TOC anchor hoạt động
        $content = $this->injectHeadingIds($post->content ?? '');

        $related = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('is_active', true)
            ->orderByDesc('published_at')
            ->limit(4)
            ->get();

        $post->load('services');

        return view('posts.show', compact('post', 'related', 'content'));
    }

    /**
     * Inject id="toc-{slug}" vào <h2>/<h3> chưa có id.
     * Đồng nhất với logic của Toc component.
     */
    private function injectHeadingIds(string $html): string
    {
        return preg_replace_callback(
            '/<(h[23])([^>]*)>(.*?)<\/\1>/si',
            function ($m) {
                [$full, $tag, $attrs, $inner] = $m;

                // Giữ nguyên nếu đã có id
                if (preg_match('/\bid\s*=/i', $attrs)) {
                    return $full;
                }

                $text = trim(html_entity_decode(strip_tags($inner), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                $id   = 'toc-' . Str::slug($text);

                return "<{$tag}{$attrs} id=\"{$id}\">{$inner}</{$tag}>";
            },
            $html
        );
    }
}
