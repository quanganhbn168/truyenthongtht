<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Xoá các keys cũ của group 'general' (từ GeneralSettings cũ)
        $keys = [
            'site_name', 'site_email', 'site_phone', 'site_address',
            'site_logo', 'site_favicon',
            'meta_title', 'meta_description', 'meta_keywords',
            'facebook_url', 'youtube_url', 'zalo_number',
            'google_analytics_id', 'google_tag_manager_id',
        ];

        foreach ($keys as $key) {
            try {
                $this->migrator->delete("general.{$key}");
            } catch (\Throwable $e) {
                // ignore if key doesn't exist
            }
        }
    }
};
