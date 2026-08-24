<?php

namespace App\Observers;

use App\Models\CuratorMedia;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class MediaImageObserver
{
    public function __construct(protected ImageService $imageService)
    {
    }

    /** Process a newly-created Curator image using its own media settings. */
    public function created(CuratorMedia $media): void
    {
        $this->processImage($media);
    }

    /** Re-process only when the file or its processing choices changed. */
    public function updated(CuratorMedia $media): void
    {
        if ($media->wasChanged(['path', 'processing_format', 'watermark_enabled', 'processing_quality'])) {
            $this->processImage($media);
        }
    }

    /** Keep the preserved source in sync when Curator replaces an upload. */
    public function saving(CuratorMedia $media): void
    {
        if (! $media->exists || ! isset($media->file) || ! $media->original_path) {
            return;
        }

        Storage::disk($media->disk)->delete($media->original_path);
        $media->original_path = null;
        $media->original_ext = null;
    }

    /** Remove a preserved source when the Curator media is deleted. */
    public function deleted(CuratorMedia $media): void
    {
        if ($media->original_path) {
            Storage::disk($media->disk)->delete($media->original_path);
        }
    }

    protected function processImage(CuratorMedia $media): void
    {
        if (! str_starts_with($media->type ?? '', 'image/')) {
            return;
        }

        $storage = Storage::disk($media->disk ?? config('curator.default_disk', 'public'));
        $currentPath = $media->path;
        $format = in_array($media->processing_format, ['original', 'webp'], true)
            ? $media->processing_format
            : 'original';
        $watermarkEnabled = (bool) ($media->watermark_enabled ?? false);
        $quality = (int) ($media->processing_quality ?: 90);

        $basePath = trim(($media->directory ? $media->directory.'/' : '').$media->name, '/');
        $sourcePath = $media->original_path ?: $currentPath;
        $sourceExt = strtolower($media->original_ext ?: pathinfo($sourcePath, PATHINFO_EXTENSION));
        $needsSourceBackup = ! $media->original_path
            && ($format === 'webp' || $watermarkEnabled || (int) $media->width > (int) config('image-processing.max_width', 1920));

        if ($needsSourceBackup) {
            $backupPath = $basePath.'.original.'.$sourceExt;

            if (! $storage->exists($backupPath) && $storage->exists($currentPath)) {
                $storage->copy($currentPath, $backupPath);
            }

            if (! $storage->exists($backupPath)) {
                return;
            }

            $sourcePath = $backupPath;
            $media->original_path = $backupPath;
            $media->original_ext = $sourceExt;
        }

        $destinationPath = $format === 'webp'
            ? $basePath.'.webp'
            : $basePath.'.'.$sourceExt;

        $result = $this->imageService->process(
            disk: $media->disk,
            path: $destinationPath,
            outputFormat: $format,
            watermarkEnabled: $watermarkEnabled,
            quality: $quality,
            sourcePath: $sourcePath,
        );

        $finalPath = $result['path'] ?? $destinationPath;
        if (! $storage->exists($finalPath)) {
            return;
        }

        if ($currentPath !== $finalPath && $currentPath !== $sourcePath && $storage->exists($currentPath)) {
            $storage->delete($currentPath);
        }

        $media->forceFill([
            'path' => $finalPath,
            'ext' => strtolower(pathinfo($finalPath, PATHINFO_EXTENSION)),
            'type' => $result['type'] ?? $media->type,
            'width' => $result['width'] ?? $media->width,
            'height' => $result['height'] ?? $media->height,
            'size' => $result['size'] ?? $media->size,
        ])->saveQuietly();
    }
}
