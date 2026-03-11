<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PageSettings extends Settings
{
    // Trang Giới thiệu
    public string $about_banner;           // Ảnh banner hero /gioi-thieu.html
    public string $about_title;            // Tiêu đề hero
    public string $about_description;     // Mô tả ngắn trang giới thiệu

    // Trang Tin tức
    public string $news_banner;
    public string $news_title;
    public string $news_description;

    // Trang Dịch vụ
    public string $services_banner;
    public string $services_title;
    public string $services_description;

    // Trang Sản phẩm
    public string $products_banner;
    public string $products_title;
    public string $products_description;

    // Trang Dự án
    public string $projects_banner;
    public string $projects_title;
    public string $projects_description;

    public static function group(): string
    {
        return 'page';
    }
}
