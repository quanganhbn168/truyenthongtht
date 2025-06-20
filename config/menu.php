<?php

return [
    [
        'title' => 'Dashboard',
        'icon' => 'bi bi-speedometer',
        'route' => 'admin.dashboard',
    ],
  /*  [
        'title' => 'Quản lý dịch vụ',
        'icon' => 'bi bi-briefcase',
        'route' => 'admin.services.index',
    ],*/
    
    [
        'title' => 'Quản lý dịch vụ',
        'icon' => 'bi bi-box-seam',
        'submenu' => [
            [
                'title' => 'Danh mục dịch vụ',
                'route' => 'admin.categories.index',
                'icon' => 'bi bi-folder2-open',
            ],
            [
                'title' => 'Dịch vụ',
                'route' => 'admin.products.index',
                'icon' => 'bi bi-bag',
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
        'icon' => 'bi bi-info-circle',
        'route' => 'admin.intro.index',
    ],
    [
        'title' => 'Liên hệ',
        'icon' => 'bi bi-envelope',
        'route' => 'admin.contacts.index',
    ],
    [
        'title' => 'Cài đặt chung',
        'icon' => 'bi bi-gear',
        'route'  => 'admin.settings.index',
    ],
];
