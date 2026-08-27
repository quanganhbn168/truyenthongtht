<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class WebsiteSettings extends Settings
{
    // Danh tính website
    public string $site_name;              // Tên website (hiển thị trình duyệt)
    public string $site_tagline;           // Slogan / tagline
    public string $site_description;       // Mô tả ngắn website

    // Hình ảnh thương hiệu & Hero
    public string $hero_video_url;         // Background Video mp4 dán thẳng vào Hero
    public string $site_logo;              // Logo chính
    public string $site_logo_white;        // Logo nền tối (footer)
    public string $site_favicon;           // Favicon (32×32)
    public string $og_image;              // Ảnh OG mặc định (social share)

    // SEO mặc định
    public string $meta_title;             // Default meta title
    public string $meta_description;       // Default meta description
    public string $meta_keywords;          // Default keywords

    // Mạng xã hội
    public string $facebook_url;
    public string $youtube_url;
    public string $tiktok_url;
    public string $zalo_number;
    public string $linkedin_url;
    public string $instagram_url;

    // Tracking & Script
    public string $google_analytics_id;    // GA4 Measurement ID (G-XXXXXXX)
    public string $google_tag_manager_id;  // GTM Container ID (GTM-XXXXXXX)
    public string $google_map_embed;       // Google Maps iframe src (bản đồ chính)
    public string $header_scripts;         // Custom scripts trước </head>
    public string $footer_scripts;         // Custom scripts trước </body>

    // About / Giới thiệu section
    public string $about_video_url;        // YouTube URL hoặc đường dẫn video trực tiếp
    public string $about_image;            // Ảnh miên họa section giới thiệu

    public array $stats;                   // Con số ấn tượng — JSON array, quản lý qua Repeater
    public string $partners_title;        // Tiêu đề khu vực đối tác khách hàng
    public array $partners;                // Logo đối tác — JSON array, quản lý qua Repeater
    public string $stats_background;       // Ảnh nền parallax cho khu vực Con số ấn tượng
    public string $testimonials_background; // Ảnh nền khu vực Đánh giá khách hàng
    public string $cta_background;         // Ảnh nền khu vực Liên hệ cuối trang
    public static function group(): string
    {
        return 'website';
    }
}
