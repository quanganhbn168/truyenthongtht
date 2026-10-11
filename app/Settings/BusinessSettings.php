<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class BusinessSettings extends Settings
{
    // Thông tin pháp lý
    public string $company_name;           // Tên công ty đầy đủ (pháp lý)
    public string $company_short_name;     // Tên ngắn / thương hiệu
    public string $tax_code;               // Mã số thuế
    public string $legal_representative;   // Người đại diện pháp luật
    public string $founded_year;           // Năm thành lập
    public string $business_license;       // Số giấy phép ĐKKD

    // Liên hệ chính
    public string $main_phone;             // Hotline chính
    public string $main_phone_2;           // Số điện thoại phụ
    public string $main_email;             // Email chính
    public string $main_address;           // Địa chỉ trụ sở chính
    public string $working_hours;          // Giờ làm việc (VD: T2-T6: 8:00-17:30)

    public array $phones = [];

    public static function group(): string
    {
        return 'business';
    }
}
