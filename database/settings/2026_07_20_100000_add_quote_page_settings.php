<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('page.quote_title', 'Yêu Cầu Báo Giá');
        $this->migrator->add('page.quote_description', '');
        $this->migrator->add('page.quote_content', '');
        $this->migrator->add('page.quote_meta_title', '');
        $this->migrator->add('page.quote_meta_description', '');
        $this->migrator->add('page.quote_keywords', '');
    }
};
