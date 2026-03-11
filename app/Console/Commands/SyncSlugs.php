<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Slug;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Relations\Relation;

class SyncSlugs extends Command
{
    protected $signature   = 'slugs:sync {--fresh : Xoá toàn bộ slugs trước khi sync lại}';
    protected $description = 'Backfill bảng slugs từ tất cả models có HasSlug trait';

    /**
     * Danh sách models cần sync — thêm model mới vào đây nếu cần.
     */
    private array $models = [
        Post::class,
        PostCategory::class,
        Service::class,
        ServiceCategory::class,
        Product::class,
        ProductCategory::class,
        Project::class,
        ProjectCategory::class,
    ];

    public function handle(): void
    {
        if ($this->option('fresh')) {
            Slug::truncate();
            $this->warn('🗑  Đã xoá toàn bộ slugs cũ.');
        }

        $total = 0;

        foreach ($this->models as $modelClass) {
            $shortName  = class_basename($modelClass);
            $morphAlias = array_search($modelClass, Relation::morphMap()) ?: $modelClass;

            $records = $modelClass::all();
            $count   = 0;

            foreach ($records as $record) {
                $slugValue = $record->getAttribute($record->getSlugSourceColumn());

                if (! $slugValue) {
                    continue;
                }

                Slug::updateOrCreate(
                    [
                        'sluggable_type' => $record->getMorphClass(),
                        'sluggable_id'   => $record->getKey(),
                    ],
                    ['slug' => $slugValue]
                );

                $count++;
            }

            $this->line("  ✅ {$shortName}: {$count} slugs");
            $total += $count;
        }

        $this->newLine();
        $this->info("🎉 Xong! Tổng cộng {$total} slugs đã được sync.");
        $this->line('   Kiểm tra: php artisan dev:check-slugs');
    }
}
