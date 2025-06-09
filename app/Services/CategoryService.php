<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Traits\UploadImageTrait;

class CategoryService
{
    use UploadImageTrait;

    public function create(array $data): Category
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['parent_id'] = $data['parent_id'] ?? 0;
        $data['status'] = $data['status'] ?? 1;

        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['parent_id'] = $data['parent_id'] ?? 0;

        // Nếu ảnh mới khác ảnh cũ → xoá ảnh cũ
        if (!empty($data['image']) && $data['image'] !== $category->image) {
            $this->deleteImage($category->image);
        }

        if (!empty($data['banner']) && $data['banner'] !== $category->banner) {
            $this->deleteImage($category->banner);
        }

        $category->update($data);
        return $category;
    }

    public function delete(Category $category): bool
    {
        // Không xoá nếu còn danh mục con
        if (Category::where('parent_id', $category->id)->exists()) {
            return false;
        }

        // Xoá ảnh nếu có
        $this->deleteImage($category->image);
        $this->deleteImage($category->banner);

        return $category->delete();
    }
}
