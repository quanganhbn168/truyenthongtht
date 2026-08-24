<?php

namespace App\Console\Commands;

use App\Models\Slug;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Migrate nội dung từ hệ thống cũ:
 *
 * B1: Tạo post_categories mới (blog thực sự)
 * B2: Remap posts sang post_categories mới (theo parent category cũ)
 * B3: Migrate post_categories cũ (cấp 1) → service_categories
 * B4: Migrate post_categories cũ (cấp 2) → services
 * B5: Update slugs table sluggable_type
 * B6: Xóa post_categories cũ đã migrate
 *
 * Chạy:  php artisan tht:migrate-content
 * Dry run: php artisan tht:migrate-content --dry-run
 */
class MigrateContent extends Command
{
    protected $signature   = 'tht:migrate-content {--dry-run : Xem preview, không thực hiện}';
    protected $description = 'Migrate post_categories → service_categories + services, tạo blog categories mới';

    // Map old post_category parent_id → new blog post_category name
    // Dùng để remap posts sang danh mục blog mới
    private const PARENT_TO_BLOG = [
        6  => 'Giới thiệu',
        23 => 'Kinh nghiệm Marketing & Quảng cáo',
        24 => 'Kinh nghiệm Quay & Chụp ảnh',
        25 => 'Hướng dẫn & Khóa học',
        27 => 'Hướng dẫn & Khóa học',
        54 => 'Bảng giá dịch vụ',
        55 => 'Kinh nghiệm SEO & Thiết kế Web',
        56 => 'Kinh nghiệm Quay & Chụp ảnh',
    ];

    // Blog category slugs
    private const BLOG_SLUGS = [
        'Giới thiệu'                         => 'gioi-thieu.html',
        'Kinh nghiệm Marketing & Quảng cáo'  => 'kinh-nghiem-marketing-quang-cao.html',
        'Kinh nghiệm Quay & Chụp ảnh'        => 'kinh-nghiem-quay-chup-anh.html',
        'Hướng dẫn & Khóa học'               => 'huong-dan-khoa-hoc.html',
        'Bảng giá dịch vụ'                    => 'bang-gia-dich-vu.html',
        'Kinh nghiệm SEO & Thiết kế Web'      => 'kinh-nghiem-seo-thiet-ke-web.html',
    ];

    // Post_categories (level 1, parent_id = NULL) sẽ migrate → service_categories
    // id=6 (Giới thiệu) — giữ lại làm post_category, không migrate
    private const SKIP_AS_SERVICE_CATEGORY = [6];

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('=== DRY RUN — không thực hiện thay đổi ===');
        }

        $this->info('Bắt đầu migrate content...');

        try {
            DB::beginTransaction();
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // ── B1: Tạo blog post_categories mới ──────────────────────────────
            $this->info('[B1] Tạo blog post_categories mới...');
            $blogCategoryIds = [];

            foreach (self::BLOG_SLUGS as $name => $slug) {
                $existing = DB::table('post_categories')->where('slug', $slug)->first();
                if ($existing) {
                    $blogCategoryIds[$name] = $existing->id;
                    $this->line("  ✓ Đã tồn tại: {$name} (id={$existing->id})");
                    continue;
                }

                if (! $dryRun) {
                    $id = DB::table('post_categories')->insertGetId([
                        'name'       => $name,
                        'slug'       => $slug,
                        'parent_id'  => null,
                        'is_active'  => 1,
                        'sort_order' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $blogCategoryIds[$name] = $id;

                    // Thêm vào slugs table
                    DB::table('slugs')->insert([
                        'slug'          => $slug,
                        'sluggable_type' => 'post_category',
                        'sluggable_id'  => $id,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);

                    $this->line("  + Tạo mới: {$name} (id={$id})");
                } else {
                    $this->line("  [preview] Sẽ tạo: {$name} → {$slug}");
                }
            }

            // ── B2: Remap posts sang blog categories mới ───────────────────────
            $this->info('[B2] Remap posts sang blog categories...');
            $remapCount = 0;

            // Lấy tất cả posts với category_id hiện tại
            $posts = DB::table('posts')->select('id', 'category_id')->get();

            // Lấy sub-categories → parent mapping
            $subToParent = DB::table('post_categories')
                ->whereNotNull('parent_id')
                ->pluck('parent_id', 'id')
                ->toArray();

            // Root categories (parent_id = NULL)
            $rootCategories = DB::table('post_categories')
                ->whereNull('parent_id')
                ->pluck('id')
                ->toArray();

            foreach ($posts as $post) {
                // Xác định parent category
                $catId   = $post->category_id;
                $parentId = in_array($catId, $rootCategories)
                    ? $catId
                    : ($subToParent[$catId] ?? $catId);

                $blogName   = self::PARENT_TO_BLOG[$parentId] ?? 'Kinh nghiệm Marketing & Quảng cáo';
                $newCatId   = $blogCategoryIds[$blogName] ?? null;

                if (! $newCatId && ! $dryRun) {
                    // Fallback nếu chưa insert (dry-run)
                    $newCatId = DB::table('post_categories')->where('slug', self::BLOG_SLUGS[$blogName])->value('id');
                }

                if ($newCatId && ! $dryRun) {
                    DB::table('posts')->where('id', $post->id)->update([
                        'category_id' => $newCatId,
                        'updated_at'  => now(),
                    ]);
                    $remapCount++;
                }
            }

            $this->line("  → Đã remap {$remapCount} posts");

            // ── B3: Migrate level 1 post_categories → service_categories ────────
            $this->info('[B3] Migrate level 1 post_categories → service_categories...');

            $level1Cats = DB::table('post_categories')
                ->whereNull('parent_id')
                ->whereNotIn('id', self::SKIP_AS_SERVICE_CATEGORY)
                ->get();

            $migratedServiceCategoryIds = [];

            foreach ($level1Cats as $cat) {
                if (! $dryRun) {
                    DB::table('service_categories')->insert([
                        'id'          => $cat->id,
                        'name'        => $cat->name,
                        'slug'        => $cat->slug,
                        'parent_id'   => null,
                        'description' => $cat->description ?? null,
                        'content'     => $this->contentForDetail($cat->content ?? null),
                        'image'       => $cat->image ?? null,
                        'thumbnail'   => $cat->thumbnail ?? null,
                        'meta_title'  => $cat->meta_title ?? null,
                        'meta_description' => $cat->meta_description ?? null,
                        'keywords'    => $cat->keywords ?? null,
                        'is_active'   => $cat->is_active,
                        'sort_order'  => $cat->sort_order ?? 0,
                        'created_at'  => $cat->created_at,
                        'updated_at'  => now(),
                    ]);
                    $migratedServiceCategoryIds[] = $cat->id;
                    $this->line("  + ServiceCategory: [{$cat->id}] {$cat->name}");
                } else {
                    $this->line("  [preview] ServiceCategory: [{$cat->id}] {$cat->name} → {$cat->slug}");
                }
            }

            // ── B4: Migrate level 2 post_categories → services ──────────────────
            $this->info('[B4] Migrate level 2 post_categories → services...');

            $level2Cats = DB::table('post_categories')
                ->whereNotNull('parent_id')
                ->whereNotIn('parent_id', self::SKIP_AS_SERVICE_CATEGORY)
                ->get();

            $migratedServiceIds = [];

            foreach ($level2Cats as $cat) {
                if (! $dryRun) {
                    DB::table('services')->insert([
                        'id'          => $cat->id,
                        'name'        => $cat->name,
                        'slug'        => $cat->slug,
                        'category_id' => $cat->parent_id,
                        'summary'     => $cat->description ?? null,
                        'content'     => $this->contentForDetail($cat->content ?? null),
                        'image'       => $cat->image ?? null,
                        'thumbnail'   => $cat->thumbnail ?? null,
                        'meta_title'  => $cat->meta_title ?? null,
                        'meta_description' => $cat->meta_description ?? null,
                        'keywords'    => $cat->keywords ?? null,
                        'price'       => 0,
                        'view_count'  => $cat->view_count ?? 0,
                        'is_active'   => $cat->is_active,
                        'sort_order'  => $cat->sort_order ?? 0,
                        'created_at'  => $cat->created_at,
                        'updated_at'  => now(),
                    ]);
                    $migratedServiceIds[] = $cat->id;
                    $this->line("  + Service: [{$cat->id}] {$cat->name} (cat={$cat->parent_id})");
                } else {
                    $this->line("  [preview] Service: [{$cat->id}] {$cat->name} → {$cat->slug}");
                }
            }

            // ── B5: Update slugs table ───────────────────────────────────────────
            $this->info('[B5] Update slugs table sluggable_type...');

            if (! $dryRun) {
                // Level 1 → service_category
                DB::table('slugs')
                    ->where('sluggable_type', 'post_category')
                    ->whereIn('sluggable_id', $migratedServiceCategoryIds)
                    ->update([
                        'sluggable_type' => 'service_category',
                        'updated_at'     => now(),
                    ]);

                // Level 2 → service
                DB::table('slugs')
                    ->where('sluggable_type', 'post_category')
                    ->whereIn('sluggable_id', $migratedServiceIds)
                    ->update([
                        'sluggable_type' => 'service',
                        'updated_at'     => now(),
                    ]);

                $this->line('  ✓ Slugs table updated');
            } else {
                $this->line('  [preview] Sẽ update slugs table');
            }

            // ── B6: Xóa post_categories cũ đã migrate ───────────────────────────
            $this->info('[B6] Xóa post_categories cũ đã migrate...');

            // CHỈ xóa các ID đã migrate sang service_categories/services
            // KHÔNG xóa blog categories mới vừa tạo ở B1
            $idsToDelete = array_merge($migratedServiceCategoryIds, $migratedServiceIds);
            $idsToDelete = array_diff($idsToDelete, array_values($blogCategoryIds)); // bảo vệ

            if (! $dryRun) {
                DB::table('post_categories')->whereIn('id', $idsToDelete)->delete();
                $this->line('  ✓ Đã xóa ' . count($idsToDelete) . ' post_categories cũ');
            } else {
                $this->line('  [preview] Sẽ xóa ' . count(array_merge($migratedServiceCategoryIds, $migratedServiceIds)) . ' post_categories');
            }

            // ── Kết thúc ─────────────────────────────────────────────────────────
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            if ($dryRun) {
                DB::rollBack();
                $this->warn('=== DRY RUN kết thúc — rollback ===');
            } else {
                DB::commit();
                $this->info('✅ Migrate thành công!');
            }

            return Command::SUCCESS;

        } catch (\Throwable $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            DB::rollBack();
            $this->error('❌ Lỗi: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            return Command::FAILURE;
        }
    }

    /**
     * Detail templates already render the record name as the page H1.
     * Demote the first legacy H1 to avoid duplicate H1 headings after import.
     */
    private function contentForDetail(?string $content): ?string
    {
        if (! $content) {
            return $content;
        }

        $content = preg_replace('/<h1\b[^>]*>/i', '<h2>', $content, 1);

        return preg_replace('/<\/h1>/i', '</h2>', $content, 1);
    }
}
