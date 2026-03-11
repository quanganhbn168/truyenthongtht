# THT Media — Agent Context

## Dự án
- **Domain:** truyenthongtht.test (dev) → truyenthongtht.com (prod)
- **Stack:** Laravel 11, Filament 5, Livewire 3, Alpine.js, Tailwind 4
- **DB:** MySQL `truyenthongthtmedia`
- **Webserver:** Laragon (Windows)

## Cấu trúc content
| Model | Bảng | Slug type | Ghi chú |
|---|---|---|---|
| Post | posts | `post` | 944 bài SEO |
| PostCategory | post_categories | `post_category` | 5 blog categories (id 67-71) + Giới thiệu |
| Service | services | `service` | 33 dịch vụ (migrate từ post_categories cũ) |
| ServiceCategory | service_categories | `service_category` | 7 danh mục dịch vụ |
| Product | products | `product` | |
| Project | projects | `project` | |
| Slide | slides | — | Trang chủ slider |
| Intro | intros | — | Về chúng tôi: sứ mệnh, tầm nhìn, giá trị |

## URL Convention
- Tất cả slug có đuôi `.html`: `dich-vu-tiktok.html`
- Route duy nhất: `/{slug}` → `SlugController::show()` → dispatch sang đúng controller
- **KHÔNG đổi URL** vì đã indexed Google

## Slug System
- Bảng `slugs`: `slug` UNIQUE globally, `sluggable_type` + `sluggable_id` morphable
- `SlugObserver`: tự động sync slug vào bảng slugs khi save model
- Collision: tự append `-1`, `-2`, `-3`...
- `SlugServiceProvider`: đăng ký morphMap + Observer cho tất cả models
- `Slug::resolve($slug)`: trả về model từ slug

## SlugController dispatch map
```
post             → PostController::show
post_category    → PostController::category
service          → ServiceController::show
service_category → ServiceController::category
product          → ProductController::show
product_category → ProductController::category
project          → ProjectController::show
project_category → ProjectController::category
```

## Views
```
resources/views/
├── layouts/
│   ├── master.blade.php          ← layout chính
│   └── partials/
│       ├── header.blade.php      ← mega menu + offcanvas
│       └── footer.blade.php
├── posts/
│   ├── index.blade.php           ← danh sách bài viết
│   └── show.blade.php            ← chi tiết bài
├── services/
│   ├── index.blade.php           ← tất cả dịch vụ
│   ├── category.blade.php        ← dịch vụ theo danh mục
│   └── show.blade.php            ← chi tiết dịch vụ
```

## Filament Admin
- Panel: `/admin`
- Resources trong `app/Filament/Resources/`
- Mỗi Resource tách Schema: `Schemas/XxxForm.php`, `Tables/XxxTable.php`
- SlugInput component: `app/Filament/Components/SlugInput.php`
  - Dùng: `...SlugInput::make(nameField: 'name', label: 'Tên')` (spread operator)
  - Auto-generate Tiếng Việt → slug + .html, URL prefix hint, unique validation

## Menu System
- Package: `datlechin/filament-menu-builder`
- DB: bảng `menus` + `menu_items` (parent_id cho tree)
- Composer: `MenuComposer` inject `$headerMenu` + `$footerMenu` vào mọi view layout
- Locations: `header` (Menu chính id=1), `footer` (Menu footer id=2)
- **Mega menu:** menu_items hỗ trợ 3 cấp:
  - Level 1: Trang chủ, Dịch vụ, Tin tức, Dự án, Liên hệ
  - Level 2: Service Categories (cột trong mega menu)
  - Level 3: Services (items trong từng cột)
- Class `mega-menu` trên level-1 item → trigger mega menu layout

## Key Providers
- `SlugServiceProvider`: morphMap + SlugObserver + ModelImageObserver
- `AppServiceProvider`: MediaImageObserver cho Curator
- View composers đăng ký trong `config/view.php` hoặc ServiceProvider

## Artisan Commands
- `php artisan tht:migrate-content [--dry-run]` — Migrate post_categories → service_categories + services

## CSS Framework
- Tailwind 4 (không có `tailwind.config.js`, dùng CSS-native)
- `resources/css/app.css` + `resources/js/app.js`

## Image System
- Package: `awcodes/filament-curator`
- Observer `MediaImageObserver`: auto resize/compress khi upload
- Disk: `public_uploads` → `public/upload/`
