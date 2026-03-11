<?php

namespace App\Observers;

use App\Services\ImageService;
use Illuminate\Database\Eloquent\Model;

/**
 * Observer dùng cho các model có FileUpload thông thường (disk: public_uploads).
 * Sau khi saved, tự động resize + compress ảnh qua ImageService.
 *
 * Các field ảnh được kiểm tra: 'image', 'avatar'
 */
class ModelImageObserver
{
    /**
     * Field ảnh cần xử lý (FileUpload lưu đường dẫn tương đối)
     */
    protected array $imageFields = ['image', 'avatar'];

    /**
     * Disk dùng cho FileUpload thông thường
     */
    protected string $disk = 'public_uploads';

    public function __construct(protected ImageService $imageService)
    {
    }

    public function saved(Model $model): void
    {
        foreach ($this->imageFields as $field) {
            // Bỏ qua nếu model không có field này
            if (! array_key_exists($field, $model->getAttributes())) {
                continue;
            }

            $path = $model->getAttribute($field);

            // Bỏ qua nếu rỗng hoặc là URL ngoài (http...)
            if (! $path || str_starts_with($path, 'http')) {
                continue;
            }

            // Chỉ xử lý khi field vừa thay đổi (tạo mới hoặc đổi ảnh)
            if (! $model->wasRecentlyCreated && ! $model->wasChanged($field)) {
                continue;
            }

            $this->imageService->process(
                disk: $this->disk,
                path: $path,
            );
        }
    }
}
