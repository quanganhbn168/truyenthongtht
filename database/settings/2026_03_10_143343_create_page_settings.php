<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('page.about_banner',           '');
        $this->migrator->add('page.about_title',            'Về chúng tôi');
        $this->migrator->add('page.about_description',      '');

        $this->migrator->add('page.news_banner',            '');
        $this->migrator->add('page.news_title',             'Tin tức');
        $this->migrator->add('page.news_description',       '');

        $this->migrator->add('page.services_banner',        '');
        $this->migrator->add('page.services_title',         'Dịch vụ của chúng tôi');
        $this->migrator->add('page.services_description',   '');

        $this->migrator->add('page.products_banner',        '');
        $this->migrator->add('page.products_title',         'Sản phẩm');
        $this->migrator->add('page.products_description',   '');

        $this->migrator->add('page.projects_banner',        '');
        $this->migrator->add('page.projects_title',         'Dự án tiêu biểu');
        $this->migrator->add('page.projects_description',   '');
    }
};
