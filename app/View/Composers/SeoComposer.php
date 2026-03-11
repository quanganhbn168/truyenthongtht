<?php

namespace App\View\Composers;

use App\Settings\BusinessSettings;
use App\Settings\WebsiteSettings;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SeoComposer
{
    public function __construct(
        protected WebsiteSettings  $web,
        protected BusinessSettings $biz,
    ) {}

    public function compose(View $view): void
    {
        $data   = $view->getData();
        $record = $data['record'] ?? null;

        // Ưu tiên: Settings DB → config → fallback cứng
        $siteName = $this->web->site_name ?: config('app.name', 'THT Media');

        $title       = $data['seoTitle']       ?? ($record?->meta_title ?? $record?->title ?? $record?->name ?? $siteName);
        $description = $data['seoDescription'] ?? ($record?->meta_description ?? $record?->summary ?? $this->web->meta_description ?? '');
        $keywords    = $data['seoKeywords']    ?? ($record?->keywords ?? $this->web->meta_keywords ?? '');
        $image       = $data['seoImage']       ?? ($record?->image ?? $record?->thumbnail ?? null);
        $url         = $data['seoUrl']         ?? request()->url();

        $titleFull = ($title && $title !== $siteName)
            ? $title . ' | ' . $siteName
            : $siteName;

        // OG image: trang cụ thể → settings og_image → fallback cứng
        $ogImagePath = $this->web->og_image ?: null;
        $imageUrl = $image
            ? (Str::startsWith($image, ['http', '//']) ? $image : asset($image))
            : ($ogImagePath
                ? (Str::startsWith($ogImagePath, ['http', '//']) ? $ogImagePath : asset($ogImagePath))
                : asset('images/og-default.jpg'));

        // Logo: Settings DB → public/images/logo.png
        $logoPath = $this->web->site_logo ?: null;
        $logoUrl  = $logoPath ? asset($logoPath) : asset('images/logo.png');

        $logoWhitePath = $this->web->site_logo_white ?: null;
        $logoWhiteUrl  = $logoWhitePath ? asset($logoWhitePath) : asset('images/logo-white.png');

        // Favicon: Settings DB → public/favicon.ico
        $faviconPath = $this->web->site_favicon ?: null;
        $faviconUrl  = $faviconPath ? asset($faviconPath) : asset('favicon.ico');

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
            'faviconUrl'         => $faviconUrl,
            'mainPhone'          => $this->biz->main_phone ?: config('site.phone', ''),
            'mainEmail'          => $this->biz->main_email ?: config('site.email', ''),
            'mainAddress'        => $this->biz->main_address ?: config('site.address', ''),
            'workingHours'       => $this->biz->working_hours ?: '',
            'ogType'             => $data['ogType']     ?? 'website',
            'schemaType'         => $data['schemaType'] ?? 'WebPage',
            'robots'             => $data['robots']     ?? 'index, follow',
            'canonical'          => $data['canonical']  ?? $url,
        ]);
    }
}
