<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    /**
     * Max width (px) để resize ảnh lớn hơn sẽ bị scale xuống
     */
    protected int $maxWidth;

    /**
     * Chất lượng nén JPEG/WebP (0-100)
     */
    protected int $quality;

    /**
     * Có bật watermark không
     */
    protected bool $watermarkEnabled;

    /**
     * Đường dẫn file watermark (trong public/)
     */
    protected string $watermarkPath;

    /**
     * Vị trí watermark: bottom-right, bottom-left, bottom-center, center
     */
    protected string $watermarkPosition;

    /**
     * Opacity watermark (0-100)
     */
    protected int $watermarkOpacity;

    public function __construct()
    {
        $this->maxWidth          = (int) config('image-processing.max_width', 1920);
        $this->quality           = (int) config('image-processing.quality', 85);
        $this->watermarkEnabled  = (bool) config('image-processing.watermark.enabled', false);
        $this->watermarkPath     = config('image-processing.watermark.path', public_path('images/watermark.png'));
        $this->watermarkPosition = config('image-processing.watermark.position', 'bottom-right');
        $this->watermarkOpacity  = (int) config('image-processing.watermark.opacity', 60);
    }

    /**
     * Xử lý ảnh sau khi upload: resize + compress + watermark
     */
    public function process(string $disk, string $path): void
    {
        $storage  = Storage::disk($disk);
        $ext      = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        // Chỉ xử lý ảnh (bỏ GIF vì resize GIF phức tạp)
        if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            return;
        }

        $fullPath = $storage->path($path);

        try {
            $image = Image::read($fullPath);

            // 1. Resize nếu vượt maxWidth (giữ tỷ lệ)
            if ($image->width() > $this->maxWidth) {
                $image->scaleDown(width: $this->maxWidth);
            }

            // 2. Watermark
            if ($this->watermarkEnabled && file_exists($this->watermarkPath)) {
                $this->applyWatermark($image, $image->width(), $image->height());
            }

            // 3. Lưu lại với quality compression
            $image->save($fullPath, quality: $this->quality);

        } catch (\Throwable $e) {
            // Log lỗi nhưng không throw để không ảnh hưởng flow upload
            logger()->error("ImageService::process failed for {$path}: " . $e->getMessage());
        }
    }

    /**
     * Apply watermark vào ảnh
     */
    protected function applyWatermark(\Intervention\Image\Interfaces\ImageInterface $image, int $imgW, int $imgH): void
    {
        try {
            $watermark = Image::read($this->watermarkPath);

            // Scale watermark: tối đa 25% chiều rộng ảnh gốc
            $maxWmWidth = (int) ($imgW * 0.25);
            if ($watermark->width() > $maxWmWidth) {
                $watermark->scaleDown(width: $maxWmWidth);
            }

            // Opacity
            $watermark->toWebp(); // Ensure transparency support
            $watermark = Image::read($this->watermarkPath)->scaleDown(width: $maxWmWidth);

            // Tính toạ độ theo position
            $margin = 20;
            [$x, $y] = match ($this->watermarkPosition) {
                'bottom-right'  => [$imgW - $watermark->width() - $margin, $imgH - $watermark->height() - $margin],
                'bottom-left'   => [$margin, $imgH - $watermark->height() - $margin],
                'bottom-center' => [(int)(($imgW - $watermark->width()) / 2), $imgH - $watermark->height() - $margin],
                'top-right'     => [$imgW - $watermark->width() - $margin, $margin],
                'top-left'      => [$margin, $margin],
                'center'        => [(int)(($imgW - $watermark->width()) / 2), (int)(($imgH - $watermark->height()) / 2)],
                default         => [$imgW - $watermark->width() - $margin, $imgH - $watermark->height() - $margin],
            };

            $image->place($watermark, 'top-left', $x, $y, $this->watermarkOpacity);

        } catch (\Throwable $e) {
            logger()->error("ImageService::applyWatermark failed: " . $e->getMessage());
        }
    }
}
