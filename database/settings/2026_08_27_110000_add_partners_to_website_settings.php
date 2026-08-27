<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('website.partners_title', 'Hơn 500+ doanh nghiệp đã đồng hành cùng THT Media');
        $this->migrator->add('website.partners', []);
    }
};
