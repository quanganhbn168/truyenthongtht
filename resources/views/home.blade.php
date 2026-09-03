@extends('layouts.master')



@section('content')

{{-- ══════════════════════════════════════════
     1. HERO SLIDER
══════════════════════════════════════════ --}}
@php
    $heroVideoUrl    = $web->hero_video_url ?? null;
    $slideLoop       = $slides->isNotEmpty() ? $slides : collect([(object)[
        'image' => 'images/og-default.jpg',
        'name'  => 'Giải pháp truyền thông toàn diện',
        'link'  => route('services.index')
    ]]);
    $statsData = !empty($web->stats) ? $web->stats : [
        ['number' => 50, 'label' => 'Dự án đã triển khai', 'icon' => 'fa-solid fa-diagram-project'],
        ['number' => 15, 'label' => 'Dịch vụ cung cấp', 'icon' => 'fa-solid fa-briefcase'],
        ['number' => 120, 'label' => 'Bài viết & Tin tức', 'icon' => 'fa-solid fa-newspaper'],
        ['number' => 10, 'label' => 'Năm kinh nghiệm', 'icon' => 'fa-solid fa-award'],
    ];
@endphp

<section class="hero-swiper swiper w-full overflow-hidden" aria-label="Banner chính">
    <div class="swiper-wrapper">
        {{-- Video cài trong Settings là slide đầu tiên, hero vẫn luôn chạy bằng Swiper. --}}
        @if($heroVideoUrl)
            @php $firstSlide = $slideLoop->first(); @endphp
            <div class="swiper-slide relative">
                <video autoplay loop muted playsinline preload="metadata" crossorigin="anonymous">
                @if(Str::endsWith($heroVideoUrl, '.mp4') || Str::endsWith($heroVideoUrl, '.webm'))
                     <source src="{{ Str::startsWith($heroVideoUrl, 'http') ? $heroVideoUrl : asset('storage/'.$heroVideoUrl) }}" type="video/{{ Str::endsWith($heroVideoUrl, '.webm') ? 'webm' : 'mp4' }}">
                @else
                    <source src="{{ $heroVideoUrl }}">
                @endif
                Trình duyệt của bạn không hỗ trợ video HTML5.
                </video>
                <div class="hero-overlay absolute inset-0 flex items-center">
                    <div class="container mx-auto px-6 max-w-7xl">
                        <h2 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight mb-4 max-w-3xl drop-shadow-lg" data-aos="fade-up" data-aos-delay="100">
                            {{ $firstSlide->name }}
                        </h2>
                        @if($firstSlide->link)
                            <a href="{{ $firstSlide->link }}" class="mt-6 btn-brand" data-aos="fade-up" data-aos-delay="200">
                                Khám phá ngay <i class="fa-solid fa-play ml-1 text-xs"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @foreach($slideLoop as $slide)
            <div class="swiper-slide relative">
                <img src="{{ Str::startsWith($slide->image, 'http') || Str::startsWith($slide->image, 'images/') ? asset($slide->image) : asset('storage/'.$slide->image) }}"
                     alt="{{ $slide->name }}"
                     loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                     {!! $loop->first ? 'fetchpriority="high"' : '' !!}>
                <div class="hero-overlay absolute inset-0 flex items-center">
                    <div class="container mx-auto px-6 max-w-7xl">
                        <h2 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight mb-4 max-w-3xl drop-shadow-lg" data-aos="fade-up" data-aos-delay="100">
                            {{ $slide->name }}
                        </h2>
                        @if($slide->link)
                        <a href="{{ $slide->link }}"
                           class="mt-6 btn-brand"
                           data-aos="fade-up" data-aos-delay="200">
                            Xem chi tiết <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</section>

{{-- ══════════════════════════════════════════
     2. VỀ CHÚNG TÔI (ABOUT)
══════════════════════════════════════════ --}}
@php
    $aboutImg = $web->about_image ? asset('storage/'.$web->about_image) : asset('images/og-default.jpg');
    $aboutDesc = $web->site_description ?: 'THT Media tự hào là đơn vị cung cấp giải pháp truyền thông toàn diện. Chúng tôi mang đến những sản phẩm chất lượng cao, sáng tạo và tối ưu nhất cho doanh nghiệp của bạn.';
@endphp
<section class="section-light py-16 md:py-24" aria-label="Giới thiệu về {{ $web->site_name }}">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            
            {{-- Image Content (Asymmetric Layout) --}}
            <div data-aos="fade-right" class="relative z-10">
                 <div class="relative w-full aspect-[4/3] mx-auto">
                     {{-- Offset Frame (Khung lệch) --}}
                     <div class="absolute -inset-4 md:-inset-6 border border-gray-200 z-0 transform translate-x-4 translate-y-4"></div>
                     
                     {{-- Main Image --}}
                     <div class="relative w-full h-full bg-gray-100 z-10 overflow-hidden shadow-2xl">
                         <img src="{{ $aboutImg }}" alt="Về {{ $web->site_name }}" loading="lazy" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-1000 ease-out">
                         
                         @if($web->about_video_url)
                         <a href="{{ $web->about_video_url }}" target="_blank" class="absolute inset-0 flex items-center justify-center bg-black/20 hover:bg-black/30 transition-colors group z-20">
                             <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-white shadow-2xl flex items-center justify-center text-gray-900 group-hover:scale-110 transition-transform duration-300">
                                 <i class="fa-solid fa-play text-xl md:text-2xl ml-1 md:ml-2"></i>
                             </div>
                         </a>
                         @endif
                     </div>
                     
                     {{-- Year / Experience Badge over Image --}}
                      @php
                          $firstStat = $statsData[0];
                         $firstStatArr = (array) $firstStat;
                         $number = $firstStatArr['number'] ?? $firstStatArr['value'] ?? '10';
                         $label = $firstStatArr['label'] ?? 'Năm kinh nghiệm';
                         
                         // Try splitting the label to put it on two lines roughly like "Năm<br>Kinh nghiệm"
                         $labelParts = explode(' ', $label);
                         $labelTop = count($labelParts) > 1 ? array_shift($labelParts) : $label;
                         $labelBottom = count($labelParts) > 0 ? implode(' ', $labelParts) : '';
                     @endphp
                     <div class="absolute -bottom-6 -right-6 lg:-right-10 bg-white p-6 shadow-xl z-30 border border-gray-50 flex items-center gap-4">
                        <div class="text-4xl md:text-5xl font-extrabold text-gray-900 font-serif leading-none">{{ number_format((int)$number) }}<span class="text-orange-600 text-2xl align-top">+</span></div>
                        <div class="text-xs uppercase tracking-widest font-bold text-gray-500 leading-tight">{{ $labelTop }}<br>{{ $labelBottom }}</div>
                     </div>
                 </div>
            </div>
            
            {{-- Text Content (Editorial Layout) --}}
            <div data-aos="fade-left" data-aos-delay="100" class="lg:pl-10 xl:pl-16">
                <span class="brand-badge hidden md:inline-flex">Về chúng tôi</span>
                
                <h1 class="section-heading mt-2">{{ $companyName }}</h1>

                <p class="mt-4 text-xl font-semibold leading-relaxed text-gray-800 md:text-2xl">Đối tác truyền thông đáng tin cậy của doanh nghiệp</p>
                
                <div class="text-base md:text-lg text-gray-500 mb-10 leading-[1.8] font-light">
                    <p>{{ $aboutDesc }}</p>
                </div>
                
                <div class="flex flex-wrap items-center gap-6">
                    <a href="{{ route('about') }}" class="btn-outline-brand inline-flex">
                        Khám phá thêm <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    @if($web->zalo_number)
                    <a href="{{ $web->zalo_number }}" target="_blank" class="flex items-center gap-2 text-sm font-bold text-gray-700 hover:text-blue-600 transition-colors">
                        <span class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-lg overflow-hidden shadow-sm">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Icon_of_Zalo.svg" alt="Zalo" class="w-6 h-6 object-contain">
                        </span>
                        Tư vấn qua Zalo
                    </a>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     3. CON SỐ ẤN TƯỢNG
══════════════════════════════════════════ --}}
@php
    $hasStatsBg = !empty($web->stats_background);
    $statsSectionClasses = $hasStatsBg ? 'stats-section stats-parallax py-12 md:py-20 bg-fixed bg-cover bg-center' : 'stats-section py-10';
    $statsSectionStyle = $hasStatsBg ? "background-image: url('".asset('storage/'.$web->stats_background)."');" : '';
@endphp
<section class="{{ $statsSectionClasses }}" aria-label="Thống kê hoạt động" style="{{ $statsSectionStyle }}">
    @if($hasStatsBg)
        {{-- Nền overlay đen nhám để làm nổi chữ --}}
        <div class="absolute inset-0 bg-black/60 z-[2]"></div>
    @endif
    <div class="container mx-auto px-4 max-w-7xl relative z-10">
        {{-- Safelist helper (hidden): sm:grid-cols-4 --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach($statsData as $i => $stat)
            @php 
                $sArr = (array) $stat; 
                $sRaw = trim((string) ($sArr['number'] ?? $sArr['value'] ?? '0'));
                $sNum = (int) preg_replace('/[^0-9]/', '', $sRaw);
                $sSuffix = str_contains($sRaw, '%') ? '%' : '+';
                $sLabel = $sArr['label'] ?? '';
                $sIcon = $sArr['icon'] ?? 'fa-solid fa-star';
            @endphp
            <div class="stat-item" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                <div class="stat-icon">
                    <i class="{{ $sIcon }}"></i>
                </div>
                <div class="stat-number js-count" data-target="{{ $sNum }}" data-suffix="{{ $sSuffix }}">
                    {{ number_format($sNum, 0, ',', '.') }}{{ $sSuffix }}
                </div>
                <p class="stat-label">{{ $sLabel }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     3. TẠI SAO CHỌN CHÚNG TÔI
══════════════════════════════════════════ --}}
@php
    $introLoop = $intros->isNotEmpty() ? $intros : collect([
        (object)['icon' => 'fa-solid fa-layer-group', 'title' => 'Dịch vụ đa dạng', 'subtitle' => 'Giải pháp toàn diện', 'content' => 'Cung cấp hệ sinh thái dịch vụ truyền thông đầy đủ từ lên ý tưởng đến thực thi.', 'link' => '', 'link_text' => ''],
        (object)['icon' => 'fa-solid fa-people-group', 'title' => 'Đội ngũ chuyên nghiệp', 'subtitle' => 'Nhân sự chất lượng cao', 'content' => 'Tập hợp những chuyên gia giàu kinh nghiệm thực chiến trong ngành media.', 'link' => '', 'link_text' => ''],
        (object)['icon' => 'fa-solid fa-handshake-angle', 'title' => 'Hỗ trợ tận tâm', 'subtitle' => 'Đồng hành cùng phát triển', 'content' => 'Cam kết hỗ trợ khách hàng xuyên suốt quá trình dự án và hậu mãi chu đáo.', 'link' => '', 'link_text' => ''],
    ]);
@endphp
<section class="section-light py-12 md:py-16 border-t border-gray-100" aria-label="Tại sao chọn chúng tôi">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex flex-col lg:flex-row gap-10 lg:gap-16 items-start">
            {{-- Left column: Title & Description --}}
            <div class="w-full lg:w-1/3" data-aos="fade-right">
                <span class="brand-badge hidden md:inline-flex">Giá trị cốt lõi</span>
                <h2 class="section-heading mt-2 mb-4">Tại sao chọn <span class="h-light">chúng tôi?</span></h2>
                <p class="text-sm md:text-base text-gray-500 mb-6">Chúng tôi cam kết mang lại những giá trị thiết thực và sự hài lòng tuyệt đối thông qua phong cách làm việc chuyên nghiệp, sáng tạo và tận tâm.</p>
                <a href="{{ route('about') }}" class="btn-outline-brand inline-flex">
                    Tìm hiểu thêm <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            {{-- Right column: Compact feature list --}}
            <div class="w-full lg:w-2/3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 md:gap-y-10">
                    @foreach($introLoop as $i => $intro)
                    <div class="flex items-start gap-4" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-orange-50 text-orange-700 flex items-center justify-center text-xl shadow-sm border border-orange-100/50">
                            @if(isset($intro->icon) && $intro->icon)
                                <i class="{{ $intro->icon }}"></i>
                            @elseif(isset($intro->image) && $intro->image)
                                <img src="{{ Str::startsWith($intro->image, 'http') ? $intro->image : asset('storage/'.$intro->image) }}" alt="{{ $intro->title }}" class="w-6 h-6 object-contain">
                            @else
                                <i class="fa-solid fa-circle-check"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base mb-1">{{ $intro->title }}</h3>
                            @if(isset($intro->content) && $intro->content)
                                <p class="text-[13px] md:text-sm text-gray-500 leading-relaxed">{{ Str::limit(strip_tags($intro->content), 120) }}</p>
                            @endif
                            @if(isset($intro->link) && $intro->link)
                            <a href="{{ $intro->link }}" class="inline-block mt-2 text-xs font-semibold text-orange-700 hover:text-orange-900 transition-colors">
                                {{ $intro->link_text ?: 'Xem thêm' }} <i class="fa-solid fa-chevron-right text-[10px] ml-0.5"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@php
    // Tạm thời cố định theo hồ sơ năng lực THT Media; khi chốt CMS sẽ chuyển sang quản trị.
    $ecosystemSolutions = [
        [
            'id' => 'san-xuat-thuong-hieu',
            'number' => '01',
            'tone' => 'warm',
            'label' => 'Sản xuất thương hiệu & nội dung',
            'title' => 'Biến câu chuyện thương hiệu thành nội dung có sức lan toả',
            'description' => 'Từ ý tưởng đến sản phẩm hoàn chỉnh, THT Media xây dựng hình ảnh thương hiệu nhất quán qua video, hình ảnh thương mại và hệ thống nhận diện chuyên nghiệp.',
            'items' => [
                ['title' => 'Sản xuất Video & Phim', 'description' => 'Phim doanh nghiệp, phim thương hiệu, TVC quảng cáo, video sản phẩm, short video và TikTok trọn gói.'],
                ['title' => 'Nhiếp ảnh thương mại', 'description' => 'Chụp profile lãnh đạo, doanh nghiệp, nhà máy, sản phẩm, lookbook và food photography.'],
                ['title' => 'Thiết kế Profile & Đồ hoạ', 'description' => 'Logo, profile doanh nghiệp, catalog, banner, poster và các ấn phẩm truyền thông.'],
            ],
        ],
        [
            'id' => 'marketing-tang-truong-so',
            'number' => '02',
            'tone' => 'cool',
            'label' => 'Marketing & tăng trưởng số',
            'title' => 'Xây chiến lược, vận hành kênh và tạo tăng trưởng bền vững',
            'description' => 'THT Media đồng hành như một phòng marketing mở rộng: nghiên cứu thị trường, sáng tạo nội dung, quảng cáo đa nền tảng và tối ưu hiện diện số.',
            'items' => [
                ['title' => 'Phòng Marketing thuê ngoài', 'description' => 'Nghiên cứu và hoạch định chiến lược marketing ngắn hạn, dài hạn phù hợp với doanh nghiệp.'],
                ['title' => 'Quản trị kênh & Content Marketing', 'description' => 'Vận hành Fanpage, Website, TikTok, YouTube; xây bài SEO, PR, kịch bản video và nội dung quảng cáo.'],
                ['title' => 'Website, SEO & quảng cáo', 'description' => 'Thiết kế website chuẩn SEO, tối ưu UX/UI, đẩy từ khoá Google và triển khai Facebook Ads, Google Ads, TikTok Ads.'],
            ],
        ],
        [
            'id' => 'su-kien-trai-nghiem',
            'number' => '03',
            'tone' => 'plain',
            'label' => 'Sự kiện & trải nghiệm',
            'title' => 'Ghi lại khoảnh khắc, kiến tạo trải nghiệm và kết nối cộng đồng',
            'description' => 'Từ sự kiện doanh nghiệp đến hoạt động tập thể, THT Media đảm nhiệm truyền thông, sản xuất hình ảnh, livestream và vận hành sự kiện trọn gói.',
            'items' => [
                ['title' => 'Media sự kiện & đời sống', 'description' => 'Quay phim, chụp ảnh Gala Dinner, Year End Party, hội thảo, khai trương, kỷ niệm thành lập và hoạt động tập thể.'],
                ['title' => 'Tổ chức sự kiện trọn gói', 'description' => 'Xây dựng ý tưởng, kịch bản, nhân sự và thiết bị cho sự kiện doanh nghiệp, Gala và các chương trình quy mô.'],
                ['title' => 'Livestream sự kiện', 'description' => 'Truyền hình trực tiếp với hệ thống thiết bị chất lượng cao, bảo đảm trải nghiệm ổn định và chỉn chu.'],
            ],
        ],
        [
            'id' => 'dao-tao-chuyen-giao',
            'number' => '04',
            'tone' => 'warm',
            'label' => 'Đào tạo & chuyển giao năng lực',
            'title' => 'Trang bị kỹ năng hình ảnh để đội ngũ tự tin phát triển',
            'description' => 'Các chương trình đào tạo thực hành giúp cá nhân và doanh nghiệp làm chủ thiết bị, hình ảnh thương mại và quy trình hậu kỳ chuyên nghiệp.',
            'items' => [
                ['title' => 'Nhiếp ảnh căn bản', 'description' => 'Làm chủ thiết bị, bố cục và ánh sáng để tạo nên những khung hình đúng kỹ thuật.'],
                ['title' => 'Nhiếp ảnh thương mại', 'description' => 'Kỹ thuật chụp sản phẩm, food photography, chân dung và profile phục vụ truyền thông.'],
                ['title' => 'Hậu kỳ hình ảnh', 'description' => 'Thành thạo Photoshop và Lightroom để hoàn thiện sản phẩm đúng tiêu chuẩn chuyên nghiệp.'],
            ],
        ],
    ];
@endphp
<section class="ecosystem" id="he-sinh-thai" aria-label="Hệ sinh thái dịch vụ THT Media">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="ecosystem__intro" data-aos="fade-up">
            <span class="brand-badge">Hệ sinh thái THT Media</span>
            <h2 class="section-heading">Giải pháp truyền thông <span class="h-light">toàn diện</span></h2>
            <p>Từ chiến lược, sáng tạo nội dung, sản xuất hình ảnh đến truyền thông số, tổ chức sự kiện và đào tạo chuyên môn — mọi điểm chạm thương hiệu được triển khai trong một hệ sinh thái thống nhất.</p>
        </div>
    </div>

    <nav class="ecosystem-nav" aria-label="Các cụm dịch vụ chính">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="ecosystem-nav__list">
                @foreach($ecosystemSolutions as $solution)
                    <a href="#{{ $solution['id'] }}"><span>{{ $solution['number'] }}</span>{{ $solution['label'] }}</a>
                @endforeach
            </div>
        </div>
    </nav>

    <div class="ecosystem__solutions">
        @foreach($ecosystemSolutions as $solution)
            <article id="{{ $solution['id'] }}" class="ecosystem-solution ecosystem-solution--{{ $solution['tone'] }}">
                <div class="container mx-auto px-4 max-w-7xl">
                    <div class="ecosystem-solution__layout">
                        <div class="ecosystem-solution__summary" data-aos="fade-up">
                            <span class="ecosystem-solution__number">{{ $solution['number'] }}</span>
                            <h3 class="ecosystem-solution__label">{{ $solution['label'] }}</h3>
                            <p class="ecosystem-solution__title">{{ $solution['title'] }}</p>
                            <p class="ecosystem-solution__description">{{ $solution['description'] }}</p>
                            <div class="ecosystem-solution__actions">
                                <a href="{{ route('services.index') }}" class="btn-outline-brand">Khám phá dịch vụ <i class="fa-solid fa-arrow-right text-xs"></i></a>
                                <a href="{{ route('quote.index') }}" class="btn-brand">Nhận báo giá <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i></a>
                            </div>
                        </div>

                        <div class="ecosystem-solution__items" data-aos="fade-up" data-aos-delay="100">
                            @foreach($solution['items'] as $item)
                                <div class="ecosystem-item">
                                    <span class="ecosystem-item__marker" aria-hidden="true"></span>
                                    <div>
                                        <h4>{{ $item['title'] }}</h4>
                                        <p>{{ $item['description'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>

{{-- ══════════════════════════════════════════
     5. DỰ ÁN ĐÃ TRIỂN KHAI
══════════════════════════════════════════ --}}
<section class="section-light py-12 md:py-20" aria-label="Dự án đã triển khai">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="text-center mb-8 md:mb-10" data-aos="fade-up">
            <span class="brand-badge center">Dự án & Portfolio</span>
            <h2 class="section-heading center">Case Studies <span class="h-light">nổi bật</span></h2>
        </div>

        {{-- Filter Tabs --}}
        <div class="project-filter mb-8 md:mb-10" data-aos="fade-up" data-aos-delay="100">
            <button class="filter-btn active" data-filter="all">Tất cả dự án</button>
            @foreach($projectCategories as $cat)
                <button class="filter-btn" data-filter="cat-{{ $cat->id }}">{{ $cat->name }}</button>
            @endforeach
        </div>

        {{-- Project Master Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 project-grid" id="projectGrid">
            @foreach($projects as $i => $project)
            <div class="project-item cat-{{ $project->category_id }}" data-aos="fade-up" data-aos-delay="{{ $i * 50 }}">
                <a href="{{ url($project->slug . '.html') }}" class="project-card {{ $i === 0 ? 'project-card--large lg:col-span-2 lg:row-span-2' : '' }}">
                    @if($project->image)
                        <img src="{{ asset($project->image) }}" 
                             alt="{{ $project->name }}" loading="lazy" class="project-card__img">
                    @else
                        <div class="h-full w-full flex items-center justify-center project-card__img" style="background:var(--clr-border)">
                            <i class="fa-solid fa-image text-4xl text-gray-400"></i>
                        </div>
                    @endif
                    <div class="project-card__content">
                        @if($project->category)
                            <span class="project-card__category">{{ $project->category->name }}</span>
                        @endif
                        <h3 class="project-card__title">{{ $project->name }}</h3>
                        @if($project->client_name)
                        <span class="project-card__client">
                            <i class="fa-regular fa-building"></i> {{ $project->client_name }}
                        </span>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10 md:mt-12" data-aos="fade-up">
            <a href="{{ route('projects.index') }}" class="btn-outline-brand inline-flex">
                Xem toàn bộ dự án <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const projectItems = document.querySelectorAll('.project-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Update active button
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.getAttribute('data-filter');

                // Filter items
                projectItems.forEach(item => {
                    if (filter === 'all' || item.classList.contains(filter)) {
                        item.classList.remove('hide');
                        // Remove grid span classes if filtered (to prevent layout break)
                        if (filter !== 'all') {
                            const card = item.querySelector('.project-card');
                            if(card) card.classList.remove('lg:col-span-2', 'lg:row-span-2');
                        } else {
                            // Restore grid span for the first item when showing "all"
                            if(item === projectItems[0]){
                                const card = item.querySelector('.project-card');
                                if(card) card.classList.add('lg:col-span-2', 'lg:row-span-2');
                            }
                        }
                    } else {
                        item.classList.add('hide');
                    }
                });
            });
        });
    });
</script>
@endpush

{{-- ══════════════════════════════════════════
     6. TIN TỨC MỚI NHẤT
══════════════════════════════════════════ --}}
@php
    $postLoop = $latestPosts->isNotEmpty() ? $latestPosts : collect([
        (object)['slug' => '#', 'title' => 'THT Media ký kết đối tác chiến lược với đài truyền hình địa phương', 'summary' => 'Sự kiện đánh dấu bước phát triển mới...', 'image' => '', 'category' => (object)['name' => 'Sự kiện công ty'], 'published_at' => now()->subDays(2), 'view_count' => 1250],
        (object)['slug' => '#', 'title' => 'Xu hướng Video Marketing 2026: Điều gì sẽ lên ngôi?', 'summary' => 'Phân tích các trào lưu short video...', 'image' => '', 'category' => (object)['name' => 'Kiến thức'], 'published_at' => now()->subDays(5), 'view_count' => 840],
        (object)['slug' => '#', 'title' => 'Cách tổ chức một sự kiện doanh nghiệp ấn tượng với chi phí tối ưu', 'summary' => 'Chia sẻ từ chuyên gia tổ chức sự kiện...', 'image' => '', 'category' => (object)['name' => 'Chia sẻ'], 'published_at' => now()->subDays(10), 'view_count' => 500],
    ]);
@endphp
<section class="section-tinted py-12 md:py-20" aria-label="Tin tức mới nhất">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex flex-wrap items-end justify-between gap-4 mb-8 md:mb-12" data-aos="fade-up">
            <div>
                <span class="brand-badge">Blog & Kiến thức</span>
                <h2 class="section-heading">Tin tức <span class="h-light">mới nhất</span></h2>
            </div>
            <a href="{{ route('posts.index') }}" class="btn-outline-brand inline-flex">
                Xem tất cả <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Featured post (2/3 width on md) --}}
            @php $featured = $postLoop->first(); @endphp
            <a href="{{ url($featured->slug . '.html') }}"
               class="news-featured md:col-span-2 group border border-gray-100" data-aos="fade-right">
                <div class="news-featured__img">
                    @if($featured->image)
                        <img src="{{ Str::startsWith($featured->image, 'http') ? $featured->image : asset('storage/'.$featured->image) }}" alt="{{ $featured->title }}" loading="lazy">
                    @else
                        <div class="flex items-center justify-center border-b border-gray-100" style="background:var(--clr-bg);height:280px">
                            <i class="fa-regular fa-newspaper text-5xl" style="color:var(--clr-border)"></i>
                        </div>
                    @endif
                    @if($featured->category)
                    <span class="absolute top-3 left-3 text-white text-xs font-bold px-3 py-1 bg-orange-700 z-10">{{ $featured->category->name }}</span>
                    @endif
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <h3 class="font-bold text-gray-900 text-xl md:text-2xl line-clamp-2 mb-2 group-hover:text-orange-800 transition-colors">{{ $featured->title }}</h3>
                    @if($featured->summary)
                        <p class="text-sm md:text-base text-gray-500 line-clamp-3 mb-4">{{ $featured->summary }}</p>
                    @endif
                    <div class="flex items-center gap-4 text-xs text-gray-400 mt-auto pt-3 border-t border-gray-100">
                        <span><i class="fa-regular fa-calendar mr-1"></i>{{ optional($featured->published_at)->format('d/m/Y') }}</span>
                        <span><i class="fa-regular fa-eye mr-1"></i>{{ number_format($featured->view_count) }}</span>
                        <span class="ml-auto font-semibold" style="color:var(--clr-primary)">
                            Đọc thêm <i class="fa-solid fa-arrow-right text-xs"></i>
                        </span>
                    </div>
                </div>
            </a>

            {{-- Side posts --}}
            <div class="flex flex-col gap-4" data-aos="fade-left">
                @foreach($postLoop->skip(1) as $i => $post)
                <a href="{{ url($post->slug . '.html') }}" class="news-small group border border-gray-100 bg-white">
                    <div class="news-small__thumb flex-shrink-0">
                        @if($post->image)
                            <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : asset('storage/'.$post->image) }}" alt="{{ $post->title }}" loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center border-r border-gray-100" style="background:var(--clr-bg)">
                                <i class="fa-regular fa-image text-xl" style="color:var(--clr-border)"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0 p-3">
                        @if($post->category)
                            <span class="block text-[10px] md:text-xs font-bold uppercase tracking-wide mb-1"
                                  style="color:var(--clr-primary)">{{ $post->category->name }}</span>
                        @endif
                        <h4 class="font-semibold text-gray-900 text-sm md:text-base line-clamp-2 leading-snug mb-2 group-hover:text-orange-800 transition-colors">{{ $post->title }}</h4>
                        <span class="text-[10px] md:text-xs text-gray-400">
                            <i class="fa-regular fa-calendar mr-0.5"></i>{{ optional($post->published_at)->format('d/m/Y') }}
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     7. ĐÁNH GIÁ KHÁCH HÀNG
══════════════════════════════════════════ --}}
@php
    $testiLoop = $testimonials->isNotEmpty() ? $testimonials : collect([
        (object)['content' => 'THT Media đã giúp thương hiệu của chúng tôi tiếp cận đúng khách hàng mục tiêu nhờ TVC xuất sắc.', 'name' => 'Anh Hoàng', 'position' => 'Giám đốc Vận hành', 'rating' => 5],
        (object)['content' => 'Đội ngũ quay phim rất tâm huyết. Hình ảnh trong các sự kiện của công ty luôn được chỉn chu tuyệt đối.', 'name' => 'Chị Mai', 'position' => 'Trưởng phòng Marketing', 'rating' => 5],
        (object)['content' => 'Mức giá hợp lý so với chất lượng dịch vụ. Tôi đánh giá cao sự thân thiện và tốc độ chuyên môn của cả team.', 'name' => 'Tuấn Anh', 'position' => 'Phó Giám đốc', 'rating' => 4],
    ]);
@endphp
@php
    $hasTestiBg = !empty($web->testimonials_background);
    $testiSectionClasses = $hasTestiBg ? 'section-light py-12 md:py-20 relative overflow-hidden bg-fixed bg-center bg-cover' : 'section-light py-12 md:py-20';
    $testiSectionStyle = $hasTestiBg ? "background-image: url('".asset('storage/'.$web->testimonials_background)."');" : '';
@endphp
<section class="{{ $testiSectionClasses }}" aria-label="Đánh giá khách hàng" style="{{ $testiSectionStyle }}">
    @if($hasTestiBg)
        {{-- Nền overlay mờ tối khi có ảnh nền --}}
        <div class="absolute inset-0 bg-slate-900/60 z-[2]"></div>
    @endif
    <div class="container mx-auto px-4 max-w-7xl relative z-10">
        <div class="text-center mb-8 md:mb-12" data-aos="fade-up">
            <span class="brand-badge center {{ $hasTestiBg ? 'bg-white/10 text-white backdrop-blur-sm border-white/20' : '' }}">Nhận xét từ khách hàng</span>
            <h2 class="section-heading center {{ $hasTestiBg ? 'text-white' : '' }}">
                <span class="text-white">Khách hàng</span>
                <span class="h-light {{ $hasTestiBg ? 'text-orange-300' : '' }}">nói gì về chúng tôi?</span>
            </h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testiLoop as $i => $testimonial)
            <div class="testi-card border border-gray-100 bg-white" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                <div class="testi-quote text-orange-100">"</div>
                {{-- Stars --}}
                <div class="flex gap-0.5 mb-3">
                    @for($s = 1; $s <= 5; $s++)
                        <i class="fa-solid fa-star text-sm {{ $s <= ($testimonial->rating ?? 5) ? 'text-amber-400' : 'text-gray-200' }}"></i>
                    @endfor
                </div>
                <p class="text-sm text-gray-600 leading-relaxed mb-4 italic relative z-10">
                    "{{ $testimonial->content }}"
                </p>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    @if(isset($testimonial->avatar) && $testimonial->avatar)
                        <img src="{{ Str::startsWith($testimonial->avatar, 'http') ? $testimonial->avatar : asset('storage/'.$testimonial->avatar) }}" alt="{{ $testimonial->name }}"
                             loading="lazy"
                             class="w-11 h-11 rounded-none object-cover shrink-0 ring-1 ring-offset-1"
                             style="ring-color:var(--clr-lime)">
                    @else
                        <div class="w-11 h-11 rounded-none flex items-center justify-center shrink-0 font-bold text-white text-lg tracking-wider bg-[var(--color-brand-primary-dark)] shadow-inner">
                            {{ mb_substr($testimonial->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <p class="font-semibold text-sm text-gray-900 uppercase tracking-widest">{{ $testimonial->name }}</p>
                        @if($testimonial->position)
                            <p class="text-[10px] uppercase tracking-wider text-gray-500 mt-0.5">{{ $testimonial->position }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     8. ĐỐI TÁC KHÁCH HÀNG (MARQUEE)
══════════════════════════════════════════ --}}
@php
    $partners = collect($web->partners ?? [])
        ->filter(fn (mixed $partner): bool => is_array($partner) && filled($partner['logo'] ?? null))
        ->map(function (array $partner): array {
            $logo = $partner['logo'];
            $url = Str::startsWith($logo, ['http://', 'https://', '//'])
                ? $logo
                : (Str::startsWith($logo, ['images/', 'assets/'])
                    ? asset($logo)
                    : asset('storage/'.$logo));

            return [
                'url' => $url,
                'name' => $partner['name'] ?? 'Đối tác THT Media',
            ];
        })
        ->values();

    // Giữ fallback cũ nếu chưa upload logo nào trong quản trị.
    if ($partners->isEmpty()) {
        $partners = collect(array_fill(0, 8, [
            'url' => asset('images/logo.png'),
            'name' => 'Đối tác THT Media',
        ]));
    }
@endphp
<section class="py-12 bg-white border-y border-gray-100 overflow-hidden" aria-label="Đối tác khách hàng">
    <div class="container mx-auto px-4 max-w-7xl mb-6 text-center">
        <h2 class="text-sm font-bold uppercase tracking-widest text-gray-500">{{ $web->partners_title ?: 'Hơn 500+ doanh nghiệp đã đồng hành cùng THT Media' }}</h2>
    </div>
    
    <div class="partner-marquee-wrap">
        <div class="partner-marquee-track">
            <div class="partner-marquee-group">
                @foreach($partners as $partner)
                    <div class="partner-marquee-item">
                        <img src="{{ $partner['url'] }}" alt="{{ $partner['name'] }}" loading="lazy" class="partner-marquee-image">
                    </div>
                @endforeach
            </div>
            <div class="partner-marquee-group" aria-hidden="true">
                @foreach($partners as $partner)
                    <div class="partner-marquee-item">
                        <img src="{{ $partner['url'] }}" alt="" loading="lazy" class="partner-marquee-image">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     9. FORM ĐĂNG KÝ TƯ VẤN (CTA)
══════════════════════════════════════════ --}}
@php
    // Ưu tiên dùng ảnh nền CTA được cấu hình cài đặt
    if (!empty($web->cta_background)) {
        $parallaxUrl = asset('storage/'.$web->cta_background);
    } else {
        // Fallback về slide thứ 2 nếu không setup
        $parallaxBg = $slides->count() > 1 ? $slides[1]->image : 'images/og-default.jpg';
        $parallaxUrl = Str::startsWith($parallaxBg, 'http') || Str::startsWith($parallaxBg, 'images/') ? asset($parallaxBg) : asset('storage/'.$parallaxBg);
    }
@endphp
<section class="py-16 md:py-24 relative overflow-hidden bg-fixed bg-center bg-cover" 
         style="background-image: url('{{ $parallaxUrl }}');"
         aria-label="Đăng ký tư vấn">
    
    {{-- Lớp phủ xanh lá cây mờ --}}
    <div class="brand-solid-overlay absolute inset-0"></div>
    
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-orange-500/20 rounded-full blur-[100px] pointer-events-none z-0"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-orange-400/20 rounded-full blur-[100px] pointer-events-none z-0"></div>
    
    <div class="container mx-auto px-4 max-w-5xl relative z-10">
        <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8 md:p-14 lg:p-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                {{-- Text column --}}
                <div data-aos="fade-right">
                    <span class="inline-block px-3 py-1 mb-4 text-xs font-black tracking-widest text-orange-800 bg-orange-100 rounded-lg uppercase">Bắt đầu ngay</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 leading-tight">Sẵn sàng nâng tầm <br> <span class="text-[var(--color-brand-primary)]">Thương hiệu</span> của bạn?</h2>
                    <p class="text-gray-500 mb-8 leading-relaxed text-sm md:text-base">Để lại thông tin để chuyên viên của hệ thống THT Media liên hệ tư vấn giải pháp và báo giá chi tiết nhất cho doanh nghiệp của bạn trong vòng 30 phút.</p>
                    
                    <ul class="space-y-4 text-sm font-semibold text-gray-700">
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-orange-500"></i> Tư vấn chiến lược miễn phí 100%</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-orange-500"></i> Báo giá minh bạch, không phí ẩn</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-orange-500"></i> Hỗ trợ triển khai nhanh chóng</li>
                    </ul>
                </div>
                
                {{-- Form column --}}
                <div data-aos="fade-left" class="bg-gray-50/50 p-6 md:p-8 rounded-2xl border border-gray-100">
                    <form action="#" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-xs font-bold text-gray-700 mb-1">Họ và tên *</label>
                            <input type="text" id="name" name="name" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all placeholder-gray-400" placeholder="Nguyễn Văn A">
                        </div>
                        <div>
                            <label for="phone" class="block text-xs font-bold text-gray-700 mb-1">Số điện thoại *</label>
                            <input type="tel" id="phone" name="phone" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all placeholder-gray-400" placeholder="0987 654 321">
                        </div>
                        <div>
                            <label for="service" class="block text-xs font-bold text-gray-700 mb-1">Dịch vụ quan tâm</label>
                            <select id="service" name="service" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all text-gray-600">
                                <option value="">Chọn dịch vụ đang quan tâm...</option>
                                <option value="quay-tvc">Quay TVC / Phim Doanh nghiệp</option>
                                <option value="chup-anh">Chụp ảnh Sự kiện / Sản phẩm</option>
                                <option value="booking">Booking KOLs / Báo chí</option>
                                <option value="khac">Dịch vụ khác</option>
                            </select>
                        </div>
                        <div>
                            <label for="note" class="block text-xs font-bold text-gray-700 mb-1">Ghi chú thêm</label>
                            <textarea id="note" name="note" rows="3" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all placeholder-gray-400 resize-none" placeholder="Yêu cầu cụ thể của bạn..."></textarea>
                        </div>
                        
                        <button type="button" class="btn-brand w-full justify-center py-3.5 px-6 rounded-xl text-sm hover:-translate-y-0.5 mt-2">
                            GỬI YÊU CẦU TƯ VẤN <i class="fa-solid fa-paper-plane ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── Hero Swiper
    if (document.querySelector('.hero-swiper')) {
        new Swiper('.hero-swiper', {
            loop: true,
            autoHeight: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            effect: 'fade',
            fadeEffect: { crossFade: true },
        });
    }

    // ── Counter animation for Stats
    (function () {
        const counters = document.querySelectorAll('.js-count');
        if (!counters.length) return;

        const format = n => n >= 1000 ? n.toLocaleString('vi-VN') : String(n);

        const observe = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                const target = Number(el.dataset.target);
                const suffix = el.dataset.suffix || '+';
                if (!Number.isFinite(target)) return;
                const duration = 1200;
                const step = Math.ceil(duration / 60);
                const increment = target / (duration / step);
                let current = 0;
                const timer = setInterval(() => {
                    current = Math.min(current + increment, target);
                    el.textContent = format(Math.floor(current)) + suffix;
                    if (current >= target) clearInterval(timer);
                }, step);
                observe.unobserve(el);
            });
        }, { threshold: 0.5 });

        counters.forEach(el => observe.observe(el));
    })();
});
</script>
@endpush
