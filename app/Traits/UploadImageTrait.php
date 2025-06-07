<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait UploadImageTrait
{
    /**
     * Upload ảnh với resize, WebP và watermark.
     */
    public function uploadImage(
        UploadedFile $file,
        string $folder = 'uploads/images',
        int $resizeWidth = 1920,
        bool $convertToWebp = true,
        string $watermarkPath = ''
    ): string {
        // Tạo tên file mới
        $ext = strtolower($file->getClientOriginalExtension());
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $slug = Str::slug($name);
        $filename = uniqid() . '-' . $slug;

        // Tạo image từ file và auto xoay đúng chiều
        $image = Image::make($file->getRealPath())->orientate();

        // Resize nếu cần
        if ($resizeWidth > 0 && $image->width() > $resizeWidth) {
            $image->resize($resizeWidth, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Thêm watermark nếu có
        if ($watermarkPath && file_exists(public_path($watermarkPath))) {
            $watermark = Image::make(public_path($watermarkPath));
            $image->insert($watermark, 'bottom-right', 10, 10);
        }

        // Encode và lưu ảnh
        if ($convertToWebp) {
            $filename .= '.webp';
            $image->encode('webp', 85);
        } else {
            $filename .= '.' . $ext;
            $image->encode($ext, 85);
        }

        // Lưu vào storage
        $path = $folder . '/' . $filename;
        Storage::disk('public')->put($path, $image);

        return 'storage/' . $path;
    }

    /**
     * Xóa ảnh đã lưu.
     */
    public function deleteImage(?string $path): void
    {
        if ($path && Str::startsWith($path, 'storage/')) {
            $path = Str::replaceFirst('storage/', '', $path);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
