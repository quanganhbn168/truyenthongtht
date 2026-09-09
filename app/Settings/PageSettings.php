<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PageSettings extends Settings
{
    // Trang Giới thiệu
    public string $about_team_image = '';

    public string $about_banner;           // Ảnh banner hero /gioi-thieu.html

    public string $about_title;            // Tiêu đề hero

    public string $about_description;     // Mô tả ngắn trang giới thiệu

    public string $about_ceo_image;        // Ảnh người sáng lập

    public string $about_ceo_name;

    public string $about_ceo_role;

    public string $about_ceo_heading;

    public string $about_ceo_greeting;

    public string $about_ceo_content;

    public string $about_ceo_signature;

    public string $about_values_kicker;

    public string $about_values_title;

    public array $about_core_values;

    public string $about_team_kicker;

    public string $about_team_title;

    public string $about_team_content;

    public array $about_team_stats;

    public string $about_cta_title;

    public string $about_cta_description;

    public string $about_cta_button_label;

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

    // Trang Báo giá
    public string $quote_title;

    public string $quote_description;

    public string $quote_content;

    public string $quote_meta_title;

    public string $quote_meta_description;

    public string $quote_keywords;

    public static function group(): string
    {
        return 'page';
    }
}
