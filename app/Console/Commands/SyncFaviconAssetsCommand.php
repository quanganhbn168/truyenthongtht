<?php

namespace App\Console\Commands;

use App\Settings\WebsiteSettings;
use App\Support\Branding\FaviconService;
use Illuminate\Console\Command;

class SyncFaviconAssetsCommand extends Command
{
    protected $signature = 'favicon:sync';

    protected $description = 'Tạo bộ favicon tĩnh từ favicon trong WebsiteSettings.';

    public function handle(WebsiteSettings $settings, FaviconService $favicons): int
    {
        if (! $settings->site_favicon) {
            $this->components->info('Chưa có favicon được chọn; website dùng favicon mặc định trong public.');

            return self::SUCCESS;
        }

        $favicons->sync($settings->site_favicon);

        $this->components->info('Đã tạo bộ favicon tĩnh từ WebsiteSettings.');

        return self::SUCCESS;
    }
}
