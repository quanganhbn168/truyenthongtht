<?php

namespace App\View\Composers;

use App\Models\Post;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use App\Models\Slug;
use App\Settings\BusinessSettings;
use App\Settings\PageSettings;
use App\Settings\WebsiteSettings;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SeoComposer
{
    public function __construct(
        protected WebsiteSettings  $web,
        protected BusinessSettings $biz,
        protected PageSettings     $pages,
    ) {}

    public function compose(View $view): void
    {
        $data = $view->getData();
        $routeName = request()->route()?->getName();
        $record = $data['record'] ?? $this->recordForRoute($routeName, $data);
        $pageSeo = $this->pageSeo($routeName);

        // Ưu tiên: Settings DB → config → fallback cứng
        $siteName = $this->web->site_name ?: config('site.name', config('app.name', 'THT Media'));
        $defaultDescription = $this->web->meta_description
            ?: $this->web->site_description
            ?: config('site.description', 'Chuyên cung cấp dịch vụ truyền thông, quay phim, chụp ảnh chuyên nghiệp.');
        $defaultKeywords = $this->web->meta_keywords ?: config('site.keywords', 'truyền thông, quay phim, chụp ảnh, marketing');

        $title = $data['seoTitle']
            ?? ($record?->meta_title ?: $record?->title ?: $record?->name ?: ($pageSeo['title'] ?? null) ?: $siteName);
        $description = $data['seoDescription']
            ?? ($record?->meta_description ?: $record?->summary ?: $record?->description ?: ($pageSeo['description'] ?? null) ?: $defaultDescription);
        $keywords = $data['seoKeywords'] ?? ($record?->keywords ?: ($pageSeo['keywords'] ?? null) ?: $defaultKeywords);
        $image       = $data['seoImage']       ?? ($record?->image ?? $record?->thumbnail ?? null);
        $url         = $data['seoUrl']         ?? request()->url();

        $titleFull = ($title && $title !== $siteName)
            ? $title . ' | ' . $siteName
            : $siteName;

        // OG image: trang cụ thể → settings → config → logo sẵn có.
        $ogImagePath = $this->web->og_image ?: config('site.og_image');
        if ($ogImagePath && ! Str::startsWith($ogImagePath, ['http', '//']) && ! file_exists(public_path(ltrim($ogImagePath, '/')))) {
            $ogImagePath = 'upload/images/THT-media-logo-2023-261x300.png';
        }

        $imageUrl = $image
            ? (Str::startsWith($image, ['http', '//']) ? $image : asset($image))
            : ($ogImagePath
                ? (Str::startsWith($ogImagePath, ['http', '//']) ? $ogImagePath : asset($ogImagePath))
                : asset('upload/images/THT-media-logo-2023-261x300.png'));

        // Logo: Settings DB → public/images/logo.png
        $logoPath = $this->web->site_logo ?: null;
        $logoUrl  = $logoPath ? asset($logoPath) : asset('images/logo.png');

        $logoWhitePath = $this->web->site_logo_white ?: null;
        $logoWhiteUrl  = $logoWhitePath ? asset($logoWhitePath) : asset('images/logo-white.png');

        $view->with([
            'seoTitle'           => $title,
            'seoTitleFull'       => $titleFull,
            'seoDescription'     => Str::limit(strip_tags($description), 160),
            'seoDescriptionFull' => Str::limit(strip_tags($description), 200),
            'seoKeywords'        => $keywords,
            'seoUrl'             => $url,
            'seoImageUrl'        => $imageUrl,
            'siteName'           => $siteName,
            'siteTagline'        => $this->web->site_tagline ?: '',
            'logoUrl'            => $logoUrl,
            'logoWhiteUrl'       => $logoWhiteUrl,
            'mainPhone'          => $this->biz->main_phone ?: config('site.phone', ''),
            'mainEmail'          => $this->biz->main_email ?: config('site.email', ''),
            'mainAddress'        => $this->biz->main_address ?: config('site.address', ''),
            'workingHours'       => $this->biz->working_hours ?: '',
            'ogType'             => $data['ogType']     ?? ($record instanceof Post ? 'article' : 'website'),
            'schemaType'         => $data['schemaType'] ?? $this->schemaTypeFor($record),
            'robots'             => $data['robots']     ?? 'index, follow',
            'canonical'          => $data['canonical']  ?? $url,
        ]);
    }

    /**
     * SEO copy mặc định cho các landing page không có model nội dung riêng.
     */
    private function pageSeo(?string $routeName): array
    {
        return match ($routeName) {
            'about' => [
                'title' => $this->pages->about_title ?: 'Giới thiệu về THT Media',
                'description' => $this->pages->about_description ?: 'Tìm hiểu về THT Media và đội ngũ cung cấp giải pháp truyền thông chuyên nghiệp.',
            ],
            'posts.index' => [
                'title' => $this->pages->news_title ?: 'Tin tức & sự kiện',
                'description' => $this->pages->news_description ?: 'Cập nhật kiến thức, xu hướng và tin tức mới nhất về truyền thông, marketing, quay phim và chụp ảnh.',
            ],
            'services.index' => [
                'title' => $this->pages->services_title ?: 'Dịch vụ truyền thông',
                'description' => $this->pages->services_description ?: 'Khám phá các dịch vụ truyền thông, sản xuất video, quay phim, chụp ảnh và marketing của THT Media.',
            ],
            'projects.index' => [
                'title' => $this->pages->projects_title ?: 'Dự án tiêu biểu',
                'description' => $this->pages->projects_description ?: 'Xem các dự án truyền thông, quay phim, chụp ảnh và marketing tiêu biểu do THT Media thực hiện.',
            ],
            'contact.index' => [
                'title' => 'Liên hệ THT Media',
                'description' => 'Liên hệ THT Media để được tư vấn giải pháp truyền thông, quay phim, chụp ảnh và marketing phù hợp.',
            ],
            'quote.index' => [
                'title' => $this->pages->quote_meta_title ?: 'Nhận báo giá dịch vụ truyền thông',
                'description' => $this->pages->quote_meta_description
                    ?: $this->pages->quote_description
                    ?: 'Gửi yêu cầu để nhận báo giá dịch vụ truyền thông, quay phim, chụp ảnh và marketing từ THT Media.',
                'keywords' => $this->pages->quote_keywords ?: null,
            ],
            default => [],
        };
    }

    private function schemaTypeFor(mixed $record): string
    {
        return match (true) {
            $record instanceof Post => 'Article',
            $record instanceof Service => 'Service',
            $record instanceof Product => 'Product',
            $record instanceof Project => 'CreativeWork',
            default => 'WebPage',
        };
    }

    /**
     * Blade loop variables are also visible to the parent layout. Only inspect
     * content models on the catch-all slug route, otherwise a listing page can
     * accidentally inherit the last article from its foreach loop as its SEO.
     */
    private function recordForRoute(?string $routeName, array $data): mixed
    {
        if ($routeName === 'slug.show') {
            // The layout is composed separately from the child view, so it does
            // not reliably receive `$service`, `$category`, etc. Resolve the
            // current slug again to ensure detail and category pages use their
            // own SEO fields rather than the site's fallback values.
            $slug = request()->route('slug');

            if (is_string($slug) && $slug !== '') {
                return Slug::resolve($slug);
            }

            return $data['post']
                ?? $data['service']
                ?? $data['project']
                ?? $data['product']
                ?? $data['category']
                ?? null;
        }

        return $routeName === 'posts.index' ? ($data['category'] ?? null) : null;
    }
}
