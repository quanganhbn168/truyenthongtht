<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Thông tin website
    |--------------------------------------------------------------------------
    */
    'name'        => env('SITE_NAME', config('app.name')),
    'description' => env('SITE_DESCRIPTION', 'Chuyên cung cấp dịch vụ truyền thông, quay phim, chụp ảnh chuyên nghiệp.'),
    'phone'       => env('SITE_PHONE', ''),
    'email'       => env('SITE_EMAIL', ''),
    'address'     => env('SITE_ADDRESS', ''),

    /*
    |--------------------------------------------------------------------------
    | Mạng xã hội
    |--------------------------------------------------------------------------
    */
    'facebook'    => env('SITE_FACEBOOK', ''),
    'youtube'     => env('SITE_YOUTUBE', ''),
    'zalo'        => env('SITE_ZALO', ''),
    'instagram'   => env('SITE_INSTAGRAM', ''),

    /*
    |--------------------------------------------------------------------------
    | SEO defaults
    |--------------------------------------------------------------------------
    */
    'og_image'    => env('SITE_OG_IMAGE', '/images/og-default.jpg'),
];
