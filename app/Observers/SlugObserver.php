<?php

namespace App\Observers;

use App\Models\Slug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugObserver
{
    /**
     * Suffix ngắn để phân biệt khi slug trùng giữa các model type.
     * Chỉ dùng khi conflict — model nào save SAU sẽ nhận suffix.
     */
    private const TYPE_SUFFIX = [
        'post'             => 'tin',
        'post_category'    => 'dm-tin',
        'service'          => 'dv',
        'service_category' => 'dm-dv',
        'product'          => 'sp',
        'product_category' => 'dm-sp',
        'project'          => 'da',
        'project_category' => 'dm-da',
    ];

    /**
     * After saving (create or update), sync slug to centralized slugs table.
     * Nếu slug đã tồn tại ở model type KHÁC, tự append suffix để tránh collision.
     * Model cũ (đang indexed) KHÔNG bị đụng tới.
     */
    public function saved(Model $model): void
    {
        $slugValue = $model->getAttribute($model->getSlugSourceColumn());

        if (! $slugValue) {
            return;
        }

        $morphType = $model->getMorphClass();
        $slugValue = $this->resolveUniqueSlug($slugValue, $morphType, $model->getKey());

        // Nếu slug bị đổi → cập nhật lại cột slug trên model (không trigger observer lại)
        if ($slugValue !== $model->getAttribute($model->getSlugSourceColumn())) {
            $model->getConnection()
                ->table($model->getTable())
                ->where($model->getKeyName(), $model->getKey())
                ->update([$model->getSlugSourceColumn() => $slugValue]);
        }

        Slug::updateOrCreate(
            [
                'sluggable_type' => $morphType,
                'sluggable_id'   => $model->getKey(),
            ],
            ['slug' => $slugValue]
        );
    }

    /**
     * Đảm bảo slug unique globally. Nếu slug đã tồn tại ở type khác,
     * append -1, -2, -3... vào trước phần extension cho đến khi tìm được slug trống.
     *
     * Ví dụ: "dich-vu-tiktok.html" → "dich-vu-tiktok-1.html"
     */
    private function resolveUniqueSlug(string $slug, string $morphType, int|string $modelId): string
    {
        // Kiểm tra slug đã có ở type khác chưa
        $conflictExists = Slug::where('slug', $slug)
            ->where('sluggable_type', '!=', $morphType)
            ->exists();

        if (! $conflictExists) {
            return $slug; // Không có conflict → giữ nguyên
        }

        // Tách base + extension
        $base      = str_ends_with($slug, '.html') ? substr($slug, 0, -5) : $slug;
        $extension = str_ends_with($slug, '.html') ? '.html' : '';

        // Tăng số suffix cho đến khi tìm được slug trống
        $counter = 1;
        do {
            $candidate = "{$base}-{$counter}{$extension}";
            $taken = Slug::where('slug', $candidate)
                ->where('sluggable_type', '!=', $morphType)
                ->exists();
            $counter++;
        } while ($taken && $counter <= 99);

        return $candidate;
    }

    /**
     * Before deleting, remove the slug record.
     */
    public function deleting(Model $model): void
    {
        Slug::where('sluggable_type', $model->getMorphClass())
            ->where('sluggable_id', $model->getKey())
            ->delete();
    }
}
