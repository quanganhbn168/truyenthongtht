<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Thông tin pháp lý
        $this->migrator->add('business.company_name', config('app.name', 'THT Media'));
        $this->migrator->add('business.company_short_name', 'THT');
        $this->migrator->add('business.tax_code', '');
        $this->migrator->add('business.legal_representative', '');
        $this->migrator->add('business.founded_year', '');
        $this->migrator->add('business.business_license', '');

        // Liên hệ chính
        $this->migrator->add('business.main_phone', '');
        $this->migrator->add('business.main_phone_2', '');
        $this->migrator->add('business.main_email', '');
        $this->migrator->add('business.main_address', '');
        $this->migrator->add('business.working_hours', 'T2 - T7: 8:00 - 17:30');
    }
};
