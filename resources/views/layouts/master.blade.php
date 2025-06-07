{{-- resources/views/layouts/master.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- Basic --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Title & SEO --}}
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Mô tả ngắn gọn về trang, giúp tăng CTR trên Google')">
    <meta name="keywords" content="@yield('meta_keywords', 'từ khóa, cách, phân cách, bởi, dấu, phẩy')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}" />

    {{-- Open Graph --}}
    <meta property="og:type"        content="@yield('og_type','website')" />
    <meta property="og:title"       content="@yield('title') | {{ config('app.name') }}" />
    <meta property="og:description" content="@yield('meta_description')" />
    <meta property="og:url"         content="{{ url()->current() }}" />
    <meta property="og:site_name"   content="{{ config('app.name') }}" />
    <meta property="og:image"       content="@yield('meta_image', asset('images/default-og.jpg'))" />

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image" />
    <meta name="twitter:title"       content="@yield('title') | {{ config('app.name') }}" />
    <meta name="twitter:description" content="@yield('meta_description')" />
    <meta name="twitter:image"       content="@yield('meta_image', asset('images/default-og.jpg'))" />

    {{-- Schema.org JSON-LD --}}
    <script type="application/ld+json">
    {!! json_encode([
        "@context" => "https://schema.org",
        "@type"    => "Organization",
        "name"     => config('app.name'),
        "url"      => url('/'),
        "logo"     => asset('images/logo.png'),
        "sameAs"   => [
            "https://www.facebook.com/YourPage",
            "https://www.instagram.com/YourPage",
            // thêm link mạng xã hội khác nếu có
        ],
    ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
    </script>

    {{-- Fonts, Favicons --}}
    <link rel="icon" href="{{ asset('images/setting/THT-media-logo.png') }}" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />
    {{-- CSS & JS --}}
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/swiper/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}?{{time()}}">
    
    @stack('css')
</head>

<body>
    
    @include('partials.frontend.header')
    @yield('content')
    @include('partials.frontend.footer')
    <script src="{{asset('/js/jquery-3.7.1.min.js')}}?{{time()}}"></script>
    <script src="{{asset('/vendor/bootstrap/popper.min.js')}}?{{time()}}"></script>
    <script src="{{asset('/vendor/bootstrap/js/bootstrap.min.js')}}?{{time()}}"></script>
    <script src="{{asset('/vendor/swiper/swiper-bundle.min.js')}}?{{time()}}"></script>
    <script src="{{asset('/js/main.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.toggle-sidebar').on('click', function () {
              $('#mobileSidebar').addClass('show');
              $('#mobileSidebarOverlay').addClass('active');
          });

            $('.close-sidebar, #mobileSidebarOverlay').on('click', function () {
              $('#mobileSidebar').removeClass('show');
              $('#mobileSidebarOverlay').removeClass('active');
          });
        });
    </script>

    @stack('js')
</body>
</html>
