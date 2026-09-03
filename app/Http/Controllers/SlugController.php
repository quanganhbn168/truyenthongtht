<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Slug;
use Illuminate\Http\Request;

class SlugController extends Controller
{
    /**
     * Map morph alias → [Controller class, method]
     * SlugController chỉ resolve slug rồi delegate sang controller tương ứng.
     */
    private const DISPATCH_MAP = [
        'post'             => [PostController::class,    'show'],
        'post_category'    => [PostController::class,    'category'],
        'service'          => [ServiceController::class, 'show'],
        'service_category' => [ServiceController::class, 'category'],
        'project'          => [ProjectController::class, 'show'],
        'project_category' => [ProjectController::class, 'category'],
    ];

    public function show(string $slug, Request $request)
    {
        // 1. Resolve slug → Eloquent model
        $record = Slug::resolve($slug);

        if (! $record || (property_exists($record, 'is_active') && ! $record->is_active)) {
            abort(404);
        }

        // Sản phẩm không thuộc hệ sinh thái public THT Media. Giữ model/dữ liệu
        // trong CMS, nhưng không phát hành listing, category hoặc detail ra ngoài.
        if ($record instanceof Product || $record instanceof ProductCategory) {
            abort(404);
        }

        // Chỉ public một URL chuẩn có đuôi .html. Slug cũ không có đuôi vẫn
        // được giữ bằng redirect 301 để không tạo nội dung trùng lặp trên Google.
        $recordSlug = (string) ($record->getAttribute('slug') ?: $slug);
        $canonicalSlug = preg_replace('/\.html$/i', '', ltrim($recordSlug, '/')) . '.html';

        if (strcasecmp(ltrim($slug, '/'), $canonicalSlug) !== 0) {
            $destination = url($canonicalSlug);

            if ($query = $request->getQueryString()) {
                $destination .= '?' . $query;
            }

            return redirect()->to($destination, 301);
        }

        // 2. Increment view count nếu có cột view_count
        if (method_exists($record, 'increment') &&
            $record->getConnection()->getSchemaBuilder()->hasColumn($record->getTable(), 'view_count')) {
            $record->increment('view_count');
        }

        // 3. Xác định morph alias
        $morphAlias = array_search(
            get_class($record),
            \Illuminate\Database\Eloquent\Relations\Relation::morphMap()
        ) ?: $record->getMorphClass();

        // 4. Dispatch sang controller tương ứng
        if (isset(self::DISPATCH_MAP[$morphAlias])) {
            [$controllerClass, $method] = self::DISPATCH_MAP[$morphAlias];
            return app($controllerClass)->$method($record, $request);
        }

        // 5. Fallback: render view pages.default nếu không có controller
        return view('pages.default', ['record' => $record]);
    }
}
