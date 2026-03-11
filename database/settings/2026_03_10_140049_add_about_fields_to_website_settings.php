<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('website.about_video_url', '');
        $this->migrator->add('website.about_image', '');
    }
};
