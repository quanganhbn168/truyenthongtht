<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateMigrationSql extends Command
{
    protected $signature = 'app:generate-migration-sql';
    protected $description = 'Generate a raw SQL file for importing old CodeIgniter data into the new Laravel database';

    public function handle()
    {
        $this->info('Starting data migration SQL generation...');
        $outputFile = database_path('import_old_data.sql');
        
        $sql = "-- THT Media Data Migration\n";
        $sql .= "-- Generated at: " . now()->toDateTimeString() . "\n\n";

        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        // 1. Post Categories (danhmucbaiviet -> post_categories)
        $this->info('Generating Post Categories...');
        $sql .= "-- POST CATEGORIES\n";
        $sql .= "TRUNCATE TABLE post_categories;\n";
        $oldPostCategories = DB::connection('old_mysql')->table('danhmucbaiviet')->get();
        foreach ($oldPostCategories as $cat) {
            $name = addslashes($cat->ten);
            $slug = addslashes($cat->url ?: Str::slug($cat->ten));
            $description = addslashes($cat->mota ?? '');
            $icon = addslashes($cat->anh ?? '');
            // Status map (if active = 1)
            $isActive = $cat->active ?? 1;
            $seoTitle = addslashes($cat->title_tk ?? '');
            $seoDescription = addslashes($cat->description_tk ?? '');
            $createdAt = $cat->ngay ?: now()->toDateTimeString();

            $sql .= "INSERT INTO post_categories (id, name, slug, description, icon, is_active, seo_title, seo_description, created_at, updated_at) VALUES ({$cat->id}, '{$name}', '{$slug}', '{$description}', '{$icon}', {$isActive}, '{$seoTitle}', '{$seoDescription}', '{$createdAt}', '{$createdAt}');\n";
        }
        $sql .= "\n";

        // 2. Posts (tintuc -> posts)
        $this->info('Generating Posts...');
        $sql .= "-- POSTS\n";
        $sql .= "TRUNCATE TABLE posts;\n";
        $oldPosts = DB::connection('old_mysql')->table('tintuc')->get();
        foreach ($oldPosts as $post) {
            $title = addslashes($post->ten ?? 'No Title');
            $slug = addslashes($post->url ?: Str::slug($title));
            $summary = addslashes($post->tomtat ?? '');
            $content = addslashes($post->chitiet ?? '');
            $image = addslashes($post->anh ?? '');
            $thumbnail = addslashes($post->anh_thumb ?? '');
            $categoryId = $post->id_danhmuc ?: 'NULL';
            $isActive = $post->active ?? 1;
            $publishedAt = $post->ngay ?: now()->toDateTimeString();
            
            $sql .= "INSERT INTO posts (id, post_category_id, title, slug, summary, content, image, thumbnail, is_active, published_at, created_at, updated_at) VALUES ({$post->id}, {$categoryId}, '{$title}', '{$slug}', '{$summary}', '{$content}', '{$image}', '{$thumbnail}', {$isActive}, '{$publishedAt}', '{$publishedAt}', '{$publishedAt}');\n";
        }
        $sql .= "\n";

        // 3. Product Categories (danhmucsanpham -> product_categories)
        $this->info('Generating Product Categories...');
        $sql .= "-- PRODUCT CATEGORIES\n";
        $sql .= "TRUNCATE TABLE product_categories;\n";
        $oldProductCats = DB::connection('old_mysql')->table('danhmucsanpham')->get();
        foreach ($oldProductCats as $cat) {
            $name = addslashes($cat->ten);
            $slug = addslashes($cat->url ?: Str::slug($cat->ten));
            $description = addslashes($cat->mota ?? '');
            $image = addslashes($cat->anh ?? '');
            $isActive = $cat->active ?? 1;
            $createdAt = $cat->ngay ?: now()->toDateTimeString();

            $sql .= "INSERT INTO product_categories (id, name, slug, description, image, is_active, created_at, updated_at) VALUES ({$cat->id}, '{$name}', '{$slug}', '{$description}', '{$image}', {$isActive}, '{$createdAt}', '{$createdAt}');\n";
        }
        $sql .= "\n";

        // 4. Products (sanpham -> products)
        $this->info('Generating Products...');
        $sql .= "-- PRODUCTS\n";
        $sql .= "TRUNCATE TABLE products;\n";
        $oldProducts = DB::connection('old_mysql')->table('sanpham')->get();
        foreach ($oldProducts as $prod) {
            $name = addslashes($prod->ten);
            $slug = addslashes($prod->url ?: Str::slug($name));
            $sku = addslashes($prod->maso ?? '');
            $price = floatval(preg_replace('/[^0-9]/', '', $prod->gia ?? 0));
            $oldPrice = floatval(preg_replace('/[^0-9]/', '', $prod->giacu ?? 0));
            $summary = addslashes($prod->tomtat ?? '');
            $content = addslashes($prod->chitiet ?? '');
            $image = addslashes($prod->anh ?? '');
            $thumbnail = addslashes($prod->anh_thumb ?? '');
            $categoryId = $prod->id_danhmuc ?: 'NULL';
            $brandId = $prod->id_hang ?: 'NULL';
            $isActive = $prod->active ?? 1;
            $createdAt = $prod->ngay ?: now()->toDateTimeString();

            $sql .= "INSERT INTO products (id, product_category_id, brand_id, name, slug, sku, price, old_price, summary, content, image, thumbnail, is_active, created_at, updated_at) VALUES ({$prod->id}, {$categoryId}, {$brandId}, '{$name}', '{$slug}', '{$sku}', {$price}, {$oldPrice}, '{$summary}', '{$content}', '{$image}', '{$thumbnail}', {$isActive}, '{$createdAt}', '{$createdAt}');\n";
        }
        $sql .= "\n";

        // 5. Brands (hang -> brands)
        $this->info('Generating Brands...');
        $sql .= "-- BRANDS\n";
        $sql .= "TRUNCATE TABLE brands;\n";
        $oldBrands = DB::connection('old_mysql')->table('hang')->get();
        foreach ($oldBrands as $brand) {
            $name = addslashes($brand->ten);
            $slug = addslashes($brand->url ?: Str::slug($name));
            $logo = addslashes($brand->anh ?? '');
            $description = addslashes($brand->mota ?? '');
            $isActive = $brand->active ?? 1;

            $sql .= "INSERT INTO brands (id, name, slug, logo, description, is_active, created_at, updated_at) VALUES ({$brand->id}, '{$name}', '{$slug}', '{$logo}', '{$description}', {$isActive}, NOW(), NOW());\n";
        }
        $sql .= "\n";

        // 6. Sliders (slider -> sliders)
        $this->info('Generating Sliders...');
        $sql .= "-- SLIDERS\n";
        $sql .= "TRUNCATE TABLE sliders;\n";
        $oldSliders = DB::connection('old_mysql')->table('slider')->get();
        foreach ($oldSliders as $slider) {
            $title = addslashes($slider->ten ?? 'Slider');
            $image = addslashes($slider->anh ?? '');
            $link = addslashes($slider->link ?? '');
            $isActive = $slider->active ?? 1;
            
            // Generate UUID if needed or auto increment. Old ID is probably fine if we use int(11) in migration
            $sql .= "INSERT INTO sliders (id, title, image, link, is_active, created_at, updated_at) VALUES ({$slider->id}, '{$title}', '{$image}', '{$link}', {$isActive}, NOW(), NOW());\n";
        }
        $sql .= "\n";

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        file_put_contents($outputFile, $sql);

        $this->info('SQL file generated successfully at: ' . $outputFile);
    }
}
