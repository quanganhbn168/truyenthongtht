<?php

namespace Database\Seeders;

use App\Enums\MenuItemType;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // ── Menu Header ────────────────────────────────────────
        $header = Menu::updateOrCreate(
            ['location' => 'header'],
            ['name' => 'Menu chính', 'is_active' => true]
        );

        $headerItems = [
            ['title' => 'Trang chủ',  'url' => '/',          'sort_order' => 1],
            ['title' => 'Giới thiệu', 'url' => '/gioi-thieu','sort_order' => 2],
            ['title' => 'Dịch vụ',   'url' => '/dich-vu',   'sort_order' => 3],
            ['title' => 'Dự án',     'url' => '/du-an',     'sort_order' => 4],
            ['title' => 'Tin tức',   'url' => '/tin-tuc',   'sort_order' => 5],
            ['title' => 'Liên hệ',   'url' => '/lien-he',   'sort_order' => 6],
        ];

        foreach ($headerItems as $item) {
            MenuItem::updateOrCreate(
                ['menu_id' => $header->id, 'title' => $item['title']],
                [
                    'url'        => $item['url'],
                    'type'       => MenuItemType::Custom->value,
                    'target'     => '_self',
                    'sort_order' => $item['sort_order'],
                    'is_active'  => true,
                    'parent_id'  => null,
                ]
            );
        }

        // ── Menu Footer ────────────────────────────────────────
        $footer = Menu::updateOrCreate(
            ['location' => 'footer'],
            ['name' => 'Menu footer', 'is_active' => true]
        );

        $footerItems = [
            ['title' => 'Về chúng tôi', 'url' => '/gioi-thieu', 'sort_order' => 1],
            ['title' => 'Dịch vụ',      'url' => '/dich-vu',    'sort_order' => 2],
            ['title' => 'Dự án',        'url' => '/du-an',      'sort_order' => 3],
            ['title' => 'Tin tức',      'url' => '/tin-tuc',    'sort_order' => 4],
            ['title' => 'Liên hệ',      'url' => '/lien-he',    'sort_order' => 5],
            ['title' => 'Chính sách',   'url' => '/chinh-sach', 'sort_order' => 6],
        ];

        foreach ($footerItems as $item) {
            MenuItem::updateOrCreate(
                ['menu_id' => $footer->id, 'title' => $item['title']],
                [
                    'url'        => $item['url'],
                    'type'       => MenuItemType::Custom->value,
                    'target'     => '_self',
                    'sort_order' => $item['sort_order'],
                    'is_active'  => true,
                    'parent_id'  => null,
                ]
            );
        }

        $this->command->info('✅ Đã seed menu Header (' . count($headerItems) . ' items) và Footer (' . count($footerItems) . ' items).');
    }
}
