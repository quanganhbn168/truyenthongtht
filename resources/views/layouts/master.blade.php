<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- SEO Core --}}
    <title>{{ $seoTitleFull }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    @if($seoKeywords)
    <meta name="keywords" content="{{ $seoKeywords }}">
    @endif
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ $canonical }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescriptionFull }}">
    <meta property="og:url" content="{{ $seoUrl }}">
    <meta property="og:image" content="{{ $seoImageUrl }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="vi_VN">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescriptionFull }}">
    <meta name="twitter:image" content="{{ $seoImageUrl }}">

    {{-- JSON-LD Structured Data --}}
    <script type="application/ld+json">{!! json_encode([
        '@context'    => 'https://schema.org',
        '@type'       => $schemaType,
        'name'        => $seoTitle,
        'description' => $seoDescriptionFull,
        'url'         => $seoUrl,
        'image'       => $seoImageUrl,
        'publisher'   => [
            '@type' => 'Organization',
            'name'  => $siteName,
            'url'   => url('/'),
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    @stack('schema')

    @include('partials.head.favicon')

    {{-- Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
    @stack('styles')
</head>
<body class="{{ $bodyClass ?? '' }}">

    <div id="site-chrome"
         x-data="{ scrolled: false }"
         x-init="scrolled = window.scrollY > 24"
         @scroll.window.passive="scrolled = window.scrollY > 24"
         :class="{ 'is-scrolled': scrolled }">
        @include('layouts.partials.topbar')
        @include('layouts.partials.header')
    </div>

    <main id="main-content" role="main">
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    @include('partials.float-widget')

    @stack('scripts')
</body>
</html>
