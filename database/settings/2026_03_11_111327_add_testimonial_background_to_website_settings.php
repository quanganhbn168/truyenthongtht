<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('website.testimonials_background', '');
        $this->migrator->add('website.cta_background', '');
    }
};
