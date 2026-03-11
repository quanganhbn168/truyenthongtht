<?php

namespace App\Observers;

use App\Services\ImageService;
use Awcodes\Curator\Models\Media;

class MediaImageObserver
{
    public function __construct(protected ImageService $imageService)
    {
    }

    /**
     * Sau khi media được tạo (file đã lưu lên disk) → xử lý ảnh
     */
    public function created(Media $media): void
    {
        $this->processImage($media);
    }

    protected function processImage(Media $media): void
    {
        // Chỉ xử lý ảnh, bỏ video/audio/pdf...
        if (! str_starts_with($media->type ?? '', 'image/')) {
            return;
        }

        $this->imageService->process(
            disk: $media->disk ?? config('curator.disk', 'public'),
            path: $media->path,
        );

        // Cập nhật lại size sau khi compress
        if ($media->disk && $media->path) {
            $newSize = \Illuminate\Support\Facades\Storage::disk($media->disk)->size($media->path);
            $media->updateQuietly(['size' => $newSize]);
        }
    }
}
