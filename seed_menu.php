<?php
// Seed menu chính với 3 cấp: nav top → service_categories → services

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

DB::transaction(function () {
    // Xóa menu chính cũ
    DB::table('menu_items')->where('menu_id', 1)->delete();

    $now = now();

    // Level 1: Top nav
    $nav = [
        ['title' => 'Trang chủ',  'url' => '/',         'order' => 1, 'classes' => null],
        ['title' => 'Dịch vụ',    'url' => '/dich-vu',  'order' => 2, 'classes' => 'mega'],
        ['title' => 'Dự án',      'url' => '/du-an',    'order' => 3, 'classes' => null],
        ['title' => 'Tin tức',    'url' => '/tin-tuc',  'order' => 4, 'classes' => null],
        ['title' => 'Liên hệ',    'url' => '/lien-he',  'order' => 5, 'classes' => null],
    ];

    $dichVuId = null;
    foreach ($nav as $item) {
        $id = DB::table('menu_items')->insertGetId([
            'menu_id'    => 1,
            'parent_id'  => null,
            'title'      => $item['title'],
            'url'        => $item['url'],
            'order'      => $item['order'],
            'classes'    => $item['classes'],
            'target'     => '_self',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        if ($item['classes'] === 'mega') {
            $dichVuId = $id;
        }
    }

    // Level 2: Service categories → children of "Dịch vụ"
    // Chỉ lấy top-level service_categories thực sự (bỏ Báo Giá id=54)
    $cats = DB::table('service_categories')
        ->where('is_active', 1)
        ->whereNull('parent_id')
        ->whereNotIn('id', [54]) // bỏ "Báo Giá"
        ->orderBy('id')
        ->get();

    foreach ($cats as $k => $cat) {
        $catMenuId = DB::table('menu_items')->insertGetId([
            'menu_id'    => 1,
            'parent_id'  => $dichVuId,
            'title'      => $cat->name,
            'url'        => '/' . ltrim($cat->slug, '/'),
            'order'      => $k + 1,
            'target'     => '_self',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Level 3: Services → children of service_category
        $services = DB::table('services')
            ->where('category_id', $cat->id)
            ->where('is_active', 1)
            ->orderBy('id')
            ->get();

        foreach ($services as $j => $svc) {
            DB::table('menu_items')->insert([
                'menu_id'    => 1,
                'parent_id'  => $catMenuId,
                'title'      => $svc->name,
                'url'        => '/' . ltrim($svc->slug, '/'),
                'order'      => $j + 1,
                'target'     => '_self',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    $total = DB::table('menu_items')->where('menu_id', 1)->count();
    echo "✅ Seeded {$total} menu items\n";
});
