<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Import data từ database cũ (CodeIgniter / truyenthongt) sang Laravel.
 *
 * Yêu cầu:
 *  1. Import file truyenthongt.sql vào database `truyenthongt_old` (đã có connection sẵn)
 *  2. Connection `old_mysql` đã được cấu hình sẵn trong config/database.php
 *     trỏ đến database: truyenthongt_old
 *  3. Chạy migrate trước: php artisan migrate
 *  4. Chạy import: php artisan import:old-db
 */
class ImportFromOldDb extends Command
{
    protected $signature = 'import:old-db
                            {--step= : Chỉ chạy bước cụ thể (categories|posts|products|services|projects|brands|sliders|contacts)}
                            {--fresh : Xóa dữ liệu cũ trước khi import}';

    protected $description = 'Import dữ liệu từ database cũ CodeIgniter sang Laravel';

    // Key: status cũ (0=hiển thị, 1=ẩn) → is_active mới
    private function toActive(int $status): bool
    {
        return $status === 0;
    }

    public function handle(): int
    {
        $step = $this->option('step');
        $fresh = $this->option('fresh');

        $steps = [
            'categories' => 'importPostCategories',
            'posts'      => 'importPosts',
            'products'   => 'importProducts',
            'services'   => 'importServices',
            'projects'   => 'importProjects',
            'brands'     => 'importBrands',
            'sliders'    => 'importSliders',
            'contacts'   => 'importContacts',
        ];

        if ($step) {
            if (! array_key_exists($step, $steps)) {
                $this->error("Bước không hợp lệ: {$step}. Hợp lệ: " . implode(', ', array_keys($steps)));
                return 1;
            }
            $steps = [$step => $steps[$step]];
        }

        foreach ($steps as $name => $method) {
            $this->info("▶ Bắt đầu: {$name}...");
            if ($fresh) {
                $this->truncateTable($name);
            }
            $this->{$method}();
            $this->info("✓ Hoàn thành: {$name}");
        }

        $this->info('');
        $this->info('✅ Import hoàn tất!');
        $this->info('⚠️  Nhớ copy thư mục upload/ sang public/upload/');
        $this->info('⚠️  Nhớ reset password admin bằng: php artisan tinker → User::first()->update([\'password\' => bcrypt(\'mattkhaumoi\')])');

        return 0;
    }

    private function truncateTable(string $step): void
    {
        // Thứ tự quan trọng: xóa bảng con trước bảng cha
        // Dùng DELETE FROM thay TRUNCATE để tránh lỗi FK constraint
        $map = [
            'categories' => ['posts', 'post_categories'],
            'posts'      => ['posts'],
            'products'   => ['products', 'product_categories'],
            'services'   => ['services'],
            'projects'   => ['projects'],
            'brands'     => ['brands'],
            'sliders'    => ['sliders'],
            'contacts'   => ['contacts'],
        ];
        if (isset($map[$step])) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            foreach ($map[$step] as $table) {
                DB::table($table)->delete();
                $this->warn("  [fresh] Đã xóa dữ liệu bảng: {$table}");
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    // =====================================================================
    // 1. POST CATEGORIES — từ bảng `danhmucbaiviet`
    // =====================================================================
    private function importPostCategories(): void
    {
        $old = DB::connection('old_mysql')->table('danhmucbaiviet')
            ->orderBy('cha') // cha=0 (root) trước, cha>0 (con) sau
            ->get();

        $usedSlugs = [];
        $count = 0;
        $duplicates = 0;

        foreach ($old as $row) {
            // Xử lý slug trùng trong DB cũ (vd: id=27 và id=58 cùng slug)
            $slug = $row->url;
            if (isset($usedSlugs[$slug])) {
                if (str_ends_with($slug, '.html')) {
                    $slug = substr($slug, 0, -5) . '-' . $row->id . '.html';
                } else {
                    $slug = $slug . '-' . $row->id;
                }
                $duplicates++;
                $this->warn("  [dup] id={$row->id} → slug đổi thành: {$slug}");
            }
            $usedSlugs[$slug] = true;

            DB::table('post_categories')->updateOrInsert(
                ['id' => $row->id],
                [
                    'name'             => $row->danhmuc,
                    'slug'             => $slug,
                    'parent_id'        => $row->cha > 0 ? $row->cha : null,
                    'description'      => null,
                    'show_home'        => (bool) $row->home,
                    'show_home2'       => (bool) $row->home2,
                    'show_menu'        => (bool) $row->menu,
                    'show_footer'      => (bool) $row->foot,
                    'image'            => $row->anh ?: null,
                    'thumbnail'        => $row->anh_thumb ?: null,
                    'view_count'       => (int) $row->view,
                    'content'          => $row->theh ?: null,
                    'meta_title'       => $row->meta_title ?: null,
                    'meta_description' => $row->meta_des ?: null,
                    'keywords'         => $row->keyword ?: null,
                    'sort_order'       => (int) $row->ordernum,
                    'is_active'        => $this->toActive((int) $row->status),
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]
            );
            $count++;
        }
        $this->line("  → {$count} danh mục bài viết" . ($duplicates ? " ({$duplicates} slug trùng đã được đổi tự động)" : ''));
    }

    // =====================================================================
    // 2. POSTS — từ bảng `tintuc`
    //    tintuc.danhmuc → post_categories.id (là varchar id số)
    // =====================================================================
    private function importPosts(): void
    {
        $old = DB::connection('old_mysql')->table('tintuc')->get();

        // Track slugs đã dùng trong lần import này để xử lý trùng trong DB cũ
        $usedSlugs = [];
        $count = 0;
        $duplicates = 0;

        foreach ($old as $row) {
            // danhmuc field là varchar, cast sang int
            $categoryId = ($row->danhmuc && is_numeric($row->danhmuc)) ? (int) $row->danhmuc : null;

            // Xử lý slug trùng: nếu slug đã tồn tại thì thêm -{id} vào
            $slug = $row->url;
            if (isset($usedSlugs[$slug])) {
                // Tách phần extension nếu có (.html)
                if (str_ends_with($slug, '.html')) {
                    $slug = substr($slug, 0, -5) . '-' . $row->id . '.html';
                } else {
                    $slug = $slug . '-' . $row->id;
                }
                $duplicates++;
                $this->warn("  [dup] id={$row->id} → slug đổi thành: {$slug}");
            }
            $usedSlugs[$slug] = true;

            DB::table('posts')->updateOrInsert(
                ['id' => $row->id],
                [
                    'title'            => $row->ten,
                    'slug'             => $slug,
                    'summary'          => $row->tomtat ?: null,
                    'category_id'      => $categoryId,
                    'image'            => $row->anh ?: null,
                    'thumbnail'        => $row->anh_thumb ?: null,
                    'content'          => $row->chitiet ?: null,
                    'published_at'     => $row->ngaydang ?: null,
                    'view_count'       => (int) ($row->view ?? 0),
                    'meta_title'       => $row->meta_title ?: null,
                    'meta_description' => $row->meta_des ?: null,
                    'keywords'         => $row->keyword ?: null,
                    'sort_order'       => (int) ($row->ordernum ?? 0),
                    'is_active'        => $this->toActive((int) $row->status),
                    'tags'             => $row->tag ?: null,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]
            );
            $count++;
        }
        $this->line("  → {$count} bài viết" . ($duplicates ? " ({$duplicates} slug trùng đã được đổi tự động)" : ''));
    }

    // =====================================================================
    // 3. PRODUCT CATEGORIES — từ bảng `danhmucsanpham`
    // =====================================================================
    private function importProductCategories(): void
    {
        // Kiểm tra bảng có tồn tại không
        $exists = DB::connection('old_mysql')
            ->select("SHOW TABLES LIKE 'danhmucsanpham'");

        if (empty($exists)) {
            $this->warn('  Bỏ qua: bảng danhmucsanpham không tồn tại');
            return;
        }

        $old = DB::connection('old_mysql')->table('danhmucsanpham')->get();
        $count = 0;
        foreach ($old as $row) {
            DB::table('product_categories')->updateOrInsert(
                ['id' => $row->id],
                [
                    'name'      => $row->ten ?? $row->danhmuc ?? 'N/A',
                    'slug'      => $row->url ?? '',
                    'parent_id' => isset($row->cha) && $row->cha > 0 ? $row->cha : null,
                    'image'     => $row->anh ?? null,
                    'thumbnail' => $row->anh_thumb ?? null,
                    'sort_order'=> (int) ($row->ordernum ?? 0),
                    'is_active' => $this->toActive((int) ($row->status ?? 0)),
                    'created_at'=> now(),
                    'updated_at'=> now(),
                ]
            );
            $count++;
        }
        $this->line("  → {$count} danh mục sản phẩm");
    }

    // =====================================================================
    // 4. PRODUCTS — từ bảng `sanpham`
    // =====================================================================
    private function importProducts(): void
    {
        // Import product categories trước
        $this->importProductCategories();

        $old = DB::connection('old_mysql')->table('sanpham')->get();
        $count = 0;
        foreach ($old as $row) {
            $categoryId = isset($row->danhmuc) && is_numeric($row->danhmuc) ? (int) $row->danhmuc : null;

            DB::table('products')->updateOrInsert(
                ['id' => $row->id],
                [
                    'category_id'    => $categoryId,
                    'name'           => $row->ten,
                    'slug'           => $row->url,
                    'summary'        => $row->tomtat ?? null,
                    'content'        => $row->chitiet ?? null,
                    'original_price' => (float) ($row->gia_cu ?? 0),
                    'price'          => (float) ($row->gia ?? 0),
                    'image'          => $row->anh ?? null,
                    'thumbnail'      => $row->anh_thumb ?? null,
                    'is_bestseller'  => (bool) ($row->hot ?? false),
                    'view_count'     => (int) ($row->view ?? 0),
                    'meta_title'     => $row->meta_title ?? null,
                    'meta_description'=> $row->meta_des ?? null,
                    'keywords'       => $row->keyword ?? null,
                    'sort_order'     => (int) ($row->ordernum ?? 0),
                    'is_active'      => $this->toActive((int) $row->status),
                    'tags'           => $row->tag ?? null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]
            );
            $count++;
        }
        $this->line("  → {$count} sản phẩm");
    }

    // =====================================================================
    // 5. SERVICES — từ bảng `dichvu`
    //    Lưu ý: dichvu cũ CHỈ có ten/link/anh/ordernum/status — không có content
    // =====================================================================
    private function importServices(): void
    {
        $old = DB::connection('old_mysql')->table('dichvu')->get();
        $count = 0;
        foreach ($old as $row) {
            DB::table('services')->updateOrInsert(
                ['id' => $row->id],
                [
                    'category_id'  => null,
                    'name'         => $row->ten,
                    'slug'         => $row->link ?? \Str::slug($row->ten),
                    'summary'      => null,
                    'content'      => null,
                    'price'        => 0,
                    'image'        => $row->anh ?? null,
                    'thumbnail'    => $row->anh_thumb ?? null,
                    'sort_order'   => (int) $row->ordernum,
                    'is_active'    => $this->toActive((int) $row->status),
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]
            );
            $count++;
        }
        $this->line("  → {$count} dịch vụ (chú ý: dịch vụ cũ không có nội dung chi tiết)");
    }

    // =====================================================================
    // 6. PROJECTS — từ bảng `duan` (nếu có)
    //    Bảng duan có thể không tồn tại trong DB dump này
    // =====================================================================
    private function importProjects(): void
    {
        $exists = DB::connection('old_mysql')->select("SHOW TABLES LIKE 'duan'");
        if (empty($exists)) {
            $this->warn('  Bỏ qua: bảng duan không tồn tại trong DB cũ');
            return;
        }

        $old = DB::connection('old_mysql')->table('duan')->get();
        $count = 0;
        foreach ($old as $row) {
            DB::table('projects')->updateOrInsert(
                ['id' => $row->id],
                [
                    'category_id'      => null,
                    'name'             => $row->ten,
                    'slug'             => $row->url ?? \Str::slug($row->ten),
                    'summary'          => $row->tomtat ?? null,
                    'content'          => $row->chitiet ?? null,
                    'client_name'      => $row->khachhang ?? null,
                    'project_date'     => $row->ngayhoanthanh ?? null,
                    'image'            => $row->anh ?? null,
                    'thumbnail'        => $row->anh_thumb ?? null,
                    'is_featured'      => (bool) ($row->hot ?? false),
                    'view_count'       => (int) ($row->view ?? 0),
                    'meta_title'       => $row->meta_title ?? null,
                    'meta_description' => $row->meta_des ?? null,
                    'keywords'         => $row->keyword ?? null,
                    'sort_order'       => (int) ($row->ordernum ?? 0),
                    'is_active'        => $this->toActive((int) $row->status),
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]
            );
            $count++;
        }
        $this->line("  → {$count} dự án");
    }

    // =====================================================================
    // 7. BRANDS — từ bảng `thuonghieu`
    // =====================================================================
    private function importBrands(): void
    {
        $old = DB::connection('old_mysql')->table('thuonghieu')->get();
        $count = 0;
        foreach ($old as $row) {
            DB::table('brands')->updateOrInsert(
                ['id' => $row->id],
                [
                    'name'       => $row->ten,
                    'slug'       => \Str::slug($row->ten) . '-' . $row->id,
                    'image'      => $row->anh ?? null,
                    'thumbnail'  => $row->anh_thumb ?? null,
                    'sort_order' => (int) $row->ordernum,
                    'is_active'  => $this->toActive((int) $row->status),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            $count++;
        }
        $this->line("  → {$count} thương hiệu");
    }

    // =====================================================================
    // 8. SLIDERS — từ bảng `slider`
    // =====================================================================
    private function importSliders(): void
    {
        // DB cũ có thể tên bảng là `slider` hoặc `slide`
        $tableName = 'slider';
        $exists = DB::connection('old_mysql')->select("SHOW TABLES LIKE '{$tableName}'");
        if (empty($exists)) {
            $tableName = 'slide';
            $exists = DB::connection('old_mysql')->select("SHOW TABLES LIKE '{$tableName}'");
        }
        if (empty($exists)) {
            $this->warn('  Bỏ qua: không tìm thấy bảng slider/slide');
            return;
        }

        $old = DB::connection('old_mysql')->table($tableName)->get();
        $count = 0;
        foreach ($old as $row) {
            DB::table('sliders')->updateOrInsert(
                ['id' => $row->id],
                [
                    'name'       => $row->tieu_de ?? $row->ten ?? 'Slide ' . $row->id,
                    'link'       => $row->link ?? null,
                    'image'      => $row->anh ?? null,
                    'thumbnail'  => $row->anh_thumb ?? null,
                    'sort_order' => (int) ($row->ordernum ?? $row->ind ?? 0),
                    'is_active'  => $this->toActive((int) $row->status),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            $count++;
        }
        $this->line("  → {$count} slider");
    }

    // =====================================================================
    // 9. CONTACTS — từ bảng `lienhe`
    // =====================================================================
    private function importContacts(): void
    {
        $old = DB::connection('old_mysql')->table('lienhe')->get();
        $count = 0;
        foreach ($old as $row) {
            DB::table('contacts')->insert([
                'name'       => $row->ten,
                'email'      => $row->email ?? null,
                'phone'      => $row->dienthoai ?? null,
                'subject'    => $row->tieude ?? null,
                'message'    => $row->noidung ?? null,
                'is_read'    => false,
                'is_active'  => true,
                'created_at' => $row->ngaygui ?? now(),
                'updated_at' => now(),
            ]);
            $count++;
        }
        $this->line("  → {$count} liên hệ");
    }
}

