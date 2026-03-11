<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Danh tính website
        $this->migrator->add('website.site_name', config('app.name', 'THT Media'));
        $this->migrator->add('website.site_tagline', '');
        $this->migrator->add('website.site_description', '');

        // Hình ảnh thương hiệu
        $this->migrator->add('website.site_logo', '');
        $this->migrator->add('website.site_logo_white', '');
        $this->migrator->add('website.site_favicon', '');
        $this->migrator->add('website.og_image', '');

        // SEO mặc định
        $this->migrator->add('website.meta_title', config('app.name', 'THT Media'));
        $this->migrator->add('website.meta_description', '');
        $this->migrator->add('website.meta_keywords', '');

        // Mạng xã hội
        $this->migrator->add('website.facebook_url', '');
        $this->migrator->add('website.youtube_url', '');
        $this->migrator->add('website.tiktok_url', '');
        $this->migrator->add('website.zalo_number', '');
        $this->migrator->add('website.linkedin_url', '');
        $this->migrator->add('website.instagram_url', '');

        // Tracking & Script
        $this->migrator->add('website.google_analytics_id', '');
        $this->migrator->add('website.google_tag_manager_id', '');
        $this->migrator->add('website.google_map_embed', '');
        $this->migrator->add('website.header_scripts', '');
        $this->migrator->add('website.footer_scripts', '');
    }
};
