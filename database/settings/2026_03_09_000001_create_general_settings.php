<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', config('app.name', 'Truyền Thông THT'));
        $this->migrator->add('general.site_email', '');
        $this->migrator->add('general.site_phone', '');
        $this->migrator->add('general.site_address', '');
        $this->migrator->add('general.site_logo', '');
        $this->migrator->add('general.site_favicon', '');

        $this->migrator->add('general.meta_title', config('app.name', 'Truyền Thông THT'));
        $this->migrator->add('general.meta_description', '');
        $this->migrator->add('general.meta_keywords', '');

        $this->migrator->add('general.facebook_url', '');
        $this->migrator->add('general.youtube_url', '');
        $this->migrator->add('general.zalo_number', '');

        $this->migrator->add('general.google_analytics_id', '');
        $this->migrator->add('general.google_tag_manager_id', '');
    }
};
