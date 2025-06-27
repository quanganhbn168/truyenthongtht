<?php

return [
    [
        'title' => 'Dashboard',
        'icon' => 'bi bi-speedometer',
        'route' => 'admin.dashboard',
    ],
    /*[
        'title' => 'Quản lý sản phẩm',
        'icon' => 'bi bi-box-seam',
        'submenu' => [
            [
                'title' => 'Danh mục sản phẩm',
                'route' => 'admin.categories.index',
                'icon' => 'bi bi-folder2-open',
            ],
            [
                'title' => 'Sản phẩm',
                'route' => 'admin.products.index',
                'icon' => 'bi bi-bag',
            ],
        ],
    ],*/
    [
        'title' => 'Quản lý khoá học',
        'icon' => 'bi bi-journal-bookmark-fill',
        'submenu' => [
            [
                'title' => 'Danh mục khoá học',
                'route' => 'admin.service_categories.index',
                'icon' => 'bi bi-journal',
            ],
            [
                'title' => 'Khoá học',
                'route' => 'admin.services.index',
                'icon' => 'bi bi-journal-medical',
            ],
        ],
    ],
    [
        'title' => 'Quản lý bài viết',
        'icon' => 'bi bi-file-text',
        'submenu' => [
            [
                'title' => 'Danh mục bài viết',
                'route' => 'admin.post-categories.index',
                'icon' => 'bi bi-folder2',
            ],
            [
                'title' => 'Bài viết',
                'route' => 'admin.posts.index',
                'icon' => 'bi bi-file-earmark',
            ],
        ],
    ],
    [
        'title' => 'Slide',
        'icon' => 'bi bi-images',
        'route' => 'admin.slides.index',
    ],
    [
        'title' => 'Quản lý giới thiệu',
        'icon' => 'bi bi-file-earmark-person',
        'route' => 'admin.intros.index',
    ],
    [
        'title' => 'Đội ngũ giảng viên',
        'icon' => 'bi bi-people-fill',
        'route' => 'admin.teams.index',
    ],
    [
        'title' => 'Cảm nhận học viên',
        'icon' => 'bi bi-chat-square-quote',
        'route' => 'admin.testimonials.index',
    ],
    [
        'title' => 'Liên hệ',
        'icon' => 'bi bi-mailbox-flag',
        'route' => 'admin.contacts.index',
    ],
    [
        'title' => 'Cấu hình',
        'icon' => 'bi bi-gear',
        'route' => 'admin.settings.index',
    ],
];
