<?php

use Illuminate\Support\Facades\DB;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $read = fn (string $group, string $name) => json_decode(DB::table('settings')->where('group', $group)->where('name', $name)->value('payload') ?? 'null', true);
        $this->migrator->add('homepage.intro_title', $read('business', 'company_name') ?: config('site.name', config('app.name')));
        $this->migrator->add('homepage.intro_description', $read('website', 'site_description') ?: 'THT Media tự hào là đơn vị cung cấp giải pháp truyền thông toàn diện. Chúng tôi mang đến những sản phẩm chất lượng cao, sáng tạo và tối ưu nhất cho doanh nghiệp của bạn.');
        $this->migrator->add('homepage.intro_cards', DB::table('intros')->where('kind', 'block')->where('is_active', true)->orderBy('sort_order')->get(['title', 'subtitle', 'icon', 'content', 'link', 'link_text'])->map(fn ($row) => (array) $row)->all());
    }
};
