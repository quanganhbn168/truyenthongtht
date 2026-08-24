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
     * Xử lý ảnh sau khi upload theo lựa chọn của từng media.
     *
     * Khi $outputFormat là null, giữ hành vi tối ưu cũ của các FileUpload
     * thông thường. Khi truyền rõ 'original' hoặc 'webp', đó là lựa chọn
     * chủ động của media trong Curator.
     */
    public function process(
        string $disk,
        string $path,
        ?string $outputFormat = null,
        ?bool $watermarkEnabled = null,
        ?int $quality = null,
        ?string $sourcePath = null,
    ): array
    {
        $storage  = Storage::disk($disk);
        $formatWasExplicit = $outputFormat !== null;
        $outputFormat = in_array($outputFormat, ['original', 'webp'], true) ? $outputFormat : 'original';
        $watermarkEnabled = $watermarkEnabled ?? $this->watermarkEnabled;
        $quality = max(1, min(100, $quality ?? $this->quality));
        $sourcePath = $sourcePath ?: $path;
        $sourceExt = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));

        // Chỉ xử lý ảnh (bỏ GIF vì resize GIF phức tạp)
        if (! in_array($sourceExt, ['jpg', 'jpeg', 'png', 'webp'])) {
            return $this->metadata($storage, $path);
        }

        $sourceFullPath = $storage->path($sourcePath);
        if (! is_file($sourceFullPath)) {
            logger()->warning("ImageService::process source missing for {$sourcePath}");

            return $this->metadata($storage, $path);
        }

        try {
            $image = Image::read($sourceFullPath);

            // 1. Resize nếu vượt maxWidth (giữ tỷ lệ)
            $isResized = $image->width() > $this->maxWidth;
            if ($isResized) {
                $image->scaleDown(width: $this->maxWidth);
            }

            // 2. Watermark
            if ($watermarkEnabled && file_exists($this->watermarkPath)) {
                $this->applyWatermark($image, $image->width(), $image->height());
            }

            // Giữ nguyên hoàn toàn khi người dùng chủ động chọn original,
            // không watermark và ảnh không cần resize.
            if ($formatWasExplicit && $outputFormat === 'original' && ! $watermarkEnabled && ! $isResized && $sourcePath === $path) {
                return $this->metadata($storage, $path);
            }

            $destinationPath = $outputFormat === 'webp'
                ? preg_replace('/\.[^.]+$/', '.webp', $path)
                : $path;
            $destinationPath = $destinationPath ?: $path;
            $destinationFullPath = $storage->path($destinationPath);
            $destinationExt = strtolower(pathinfo($destinationPath, PATHINFO_EXTENSION));
            $tempPath = $destinationFullPath . '.tmp';

            $encoded = match ($destinationExt) {
                'webp' => $image->toWebp($quality),
                'jpg', 'jpeg' => $image->toJpeg($quality),
                'png' => $image->toPng(),
                default => $image->encodeByExtension($destinationExt),
            };
            $encoded->save($tempPath);

            $newSize = filesize($tempPath);
            $currentSize = is_file($destinationFullPath) ? filesize($destinationFullPath) : null;
            $forceSave = $formatWasExplicit || $watermarkEnabled || $isResized || $outputFormat === 'webp';

            // Với Curator, lựa chọn WebP/watermark là bắt buộc. Với upload
            // cũ gọi process() không truyền lựa chọn, chỉ thay khi nhẹ hơn.
            if ($forceSave || $currentSize === null || $newSize < $currentSize) {
                if (is_file($destinationFullPath) && $destinationPath !== $sourcePath) {
                    @unlink($destinationFullPath);
                }
                rename($tempPath, $destinationFullPath);
            } else {
                unlink($tempPath);
            }

            return $this->metadata($storage, $destinationPath);
        } catch (\Throwable $e) {
            // Dọn file tạm nếu có lỗi
            if (isset($tempPath) && file_exists($tempPath)) {
                @unlink($tempPath);
            }
            // Log lỗi nhưng không throw để không ảnh hưởng flow upload
            logger()->error("ImageService::process failed for {$sourcePath}: " . $e->getMessage());

            return $this->metadata($storage, $path);
        }
    }

    protected function metadata($storage, string $path): array
    {
        $fullPath = $storage->path($path);
        if (! is_file($fullPath)) {
            return ['path' => $path];
        }

        try {
            $image = Image::read($fullPath);

            return [
                'path' => $path,
                'width' => $image->width(),
                'height' => $image->height(),
                'size' => filesize($fullPath),
                'type' => mime_content_type($fullPath) ?: 'image/'.strtolower(pathinfo($path, PATHINFO_EXTENSION)),
            ];
        } catch (\Throwable) {
            return [
                'path' => $path,
                'size' => filesize($fullPath),
            ];
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
