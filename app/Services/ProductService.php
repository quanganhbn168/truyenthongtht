<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Traits\UploadImageTrait;

class ProductService
{
    use UploadImageTrait;

    public function create(array $data): Product
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['status'] = $data['status'] ?? 1;

        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        if (!empty($data['image']) && $data['image'] !== $product->image) {
            $this->deleteImage($product->image);
        }

        if (!empty($data['banner']) && $data['banner'] !== $product->banner) {
            $this->deleteImage($product->banner);
        }

        $product->update($data);
        return $product;
    }

    public function delete(Product $product): bool
    {
        $this->deleteImage($product->image);
        $this->deleteImage($product->banner);
        return $product->delete();
    }
}
