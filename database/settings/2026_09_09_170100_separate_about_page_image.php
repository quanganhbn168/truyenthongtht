<?php

use Illuminate\Support\Facades\DB;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('page.about_team_image', json_decode(DB::table('settings')->where('group', 'website')->where('name', 'about_image')->value('payload') ?? 'null', true));
    }
};
