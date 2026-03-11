<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Ghi đè các stat_ fields đã lỡ tạo bằng cách xóa chúng (nếu có)
        // và thêm stats array thay thế
        $this->migrator->delete('website.stat_projects');
        $this->migrator->delete('website.stat_projects_label');
        $this->migrator->delete('website.stat_years');
        $this->migrator->delete('website.stat_years_label');
        $this->migrator->delete('website.stat_clients');
        $this->migrator->delete('website.stat_clients_label');
        $this->migrator->delete('website.stat_partners');
        $this->migrator->delete('website.stat_partners_label');

        // Thêm stats JSON array với default values mẫu
        $this->migrator->add('website.stats', [
            ['value' => '500+', 'label' => 'Dự án thực hiện',    'icon' => 'fa-solid fa-briefcase'],
            ['value' => '10+',  'label' => 'Năm kinh nghiệm',    'icon' => 'fa-solid fa-calendar-check'],
            ['value' => '1000+','label' => 'Khách hàng tin tưởng','icon' => 'fa-solid fa-users'],
            ['value' => '50+',  'label' => 'Đối tác chiến lược', 'icon' => 'fa-solid fa-handshake'],
        ]);
    }
};
