<?php

namespace App\Services;

use App\Models\Slide;
use Illuminate\Support\Str;

class FrontendBannerService
{
    /**
     * Banner dùng chung cho các trang không có ảnh banner riêng.
     * Lấy slide active đầu tiên để nội dung banner được quản trị tại Slider.
     */
    public function commonUrl(): string
    {
        $image = Slide::active()
            ->whereNotNull('image')
            ->where('image', '<>', '')
            ->value('image');

        return $this->url($image);
    }

    public function url(?string $path): string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return asset('images/og-default.jpg');
        }

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        $path = ltrim($path, '/');

        if (Str::startsWith($path, ['images/', 'storage/'])) {
            return asset($path);
        }

        return asset('storage/' . $path);
    }
}
