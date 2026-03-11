@extends('layouts.master')

@push('styles')
<style>
    .service-hero {
        position: relative;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    .service-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(0,0,0,0.85), rgba(0,0,0,0.4));
    }
    .service-hero-content {
        position: relative;
        z-index: 10;
        width: 100%;
    }
    .landing-section {
        padding: 5rem 0;
    }
    .landing-section:nth-child(even) {
        background-color: #f8fafc;
    }
    .section-title {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--color-gray-900);
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
    }
    .section-title::after {
        content: '';
        display: block;
        width: 60px;
        height: 4px;
        background-color: var(--clr-primary, #15803d);
        margin: 1rem auto 0;
        border-radius: 2px;
    }
    .process-timeline {
        position: relative;
    }
    .process-timeline::before {
        content: '';
        position: absolute;
        left: 24px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #e5e7eb;
    }
    .process-step {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 2.5rem;
        position: relative;
    }
    .process-step-number {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: var(--clr-primary, #15803d);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.25rem;
        flex-shrink: 0;
        z-index: 2;
        box-shadow: 0 0 0 4px white;
    }
    .sticky-cta {
        position: sticky;
        top: 6rem;
    }
</style>
@endpush

@section('content')

{{-- ── HERO SECTION ── --}}
<section class="service-hero" style="background-image: url('{{ $service->image ? asset($service->image) : asset('assets/images/placeholder-lg.jpg') }}');">
    <div class="service-hero-content container mx-auto px-4 max-w-7xl">
        <div class="max-w-3xl">
            <x-breadcrumb :items="[
                ['label' => 'Dịch vụ', 'url' => route('services.index')],
                ['label' => optional($category)->name ?? '', 'url' => $category ? url($category->slug . '.html') : null],
                ['label' => $service->name],
            ]" class="text-white/80 mb-6 drop-shadow" />

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6 text-white drop-shadow-lg" itemprop="name">
                {{ $service->name }}
            </h1>

            @if($service->summary)
                <p class="text-lg md:text-xl text-gray-200 mb-8 leading-relaxed max-w-2xl drop-shadow">
                    {{ $service->summary }}
                </p>
            @endif

            <div class="flex flex-wrap items-center gap-6">
                <a href="tel:{{ config('site.phone', '') }}" class="inline-flex items-center gap-2 bg-green-600 text-white hover:bg-green-700 px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                    <i class="fa-solid fa-phone-volume"></i> Nhận Tư Vấn Ngay
                </a>
                
                @if($service->price > 0)
                    <div class="bg-black/40 backdrop-blur-sm border border-white/20 px-6 py-3 rounded-full">
                        <span class="text-sm text-gray-300 block mb-1">Giá chỉ từ</span>
                        <span class="font-bold text-white text-xl">{{ number_format($service->price) }}₫</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ── MAIN LAYOUT ── --}}
<div class="py-12 bg-white">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex flex-col lg:flex-row gap-12 items-start">

            {{-- ── LEFT CONTENT COLUMN ── --}}
            <div class="flex-1 min-w-0 space-y-16">

                {{-- Nỗi đau khách hàng & Lợi ích --}}
                @if($service->pain_points || $service->benefits)
                <div class="grid md:grid-cols-2 gap-8">
                    @if($service->pain_points)
                    <div class="bg-red-50 rounded-2xl p-8 border border-red-100">
                        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center text-xl mb-6">
                            <i class="fa-solid fa-heart-crack"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Vấn đề của bạn?</h3>
                        <div class="prose prose-red text-gray-700 prose-sm">
                            {!! $service->pain_points !!}
                        </div>
                    </div>
                    @endif

                    @if($service->benefits)
                    <div class="bg-green-50 rounded-2xl p-8 border border-green-100">
                        <div class="w-12 h-12 bg-green-100 text-green-700 rounded-xl flex items-center justify-center text-xl mb-6">
                            <i class="fa-solid fa-check-double"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Giải pháp từ THT Media</h3>
                        <div class="prose prose-green text-gray-700 prose-sm">
                            {!! $service->benefits !!}
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                {{-- Nội dung chi tiết --}}
                @if($service->content)
                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b">Chi tiết Dịch vụ</h2>
                    <div class="prose prose-lg max-w-none text-gray-700" itemprop="description">
                        {!! $service->content !!}
                    </div>
                </section>
                @endif

                {{-- Bảng giá / Subscription Packages --}}
                @if($service->packages && is_array($service->packages) && count($service->packages) > 0)
                <section class="mt-12 scroll-mt-24" id="pricing">
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Bảng Giá Dịch Vụ</h2>
                        <p class="text-gray-500 max-w-2xl mx-auto">Lựa chọn gói giải pháp phù hợp nhất với nhu cầu và quy mô doanh nghiệp của bạn.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start">
                        @foreach($service->packages as $package)
                        @php
                            $isPopular = $package['is_popular'] ?? false;
                            $features = isset($package['features']) ? array_filter(array_map('trim', explode("\n", $package['features']))) : [];
                        @endphp
                        <div class="relative bg-white rounded-3xl border {{ $isPopular ? 'border-green-500 shadow-2xl scale-105 z-10' : 'border-gray-200 shadow-lg' }} p-8 flex flex-col h-full transition-transform duration-300">
                            @if($isPopular)
                                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                    <span class="bg-green-600 text-white text-xs font-bold uppercase tracking-widest py-1.5 px-4 rounded-full shadow-md">Phổ biến nhất</span>
                                </div>
                            @endif
                            
                            <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $package['name'] ?? 'Gói Dịch Vụ' }}</h3>
                            <div class="mb-6 pb-6 border-b border-gray-100 flex-grow-0">
                                <p class="text-3xl font-extrabold text-green-700">{{ $package['price_text'] ?? 'Liên hệ' }}</p>
                            </div>
                            
                            <ul class="space-y-4 mb-8 flex-1">
                                @foreach($features as $feature)
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                    <span class="text-gray-600 text-sm">{{ $feature }}</span>
                                </li>
                                @endforeach
                            </ul>
                            
                            <div class="mt-auto">
                                <a href="tel:{{ config('site.phone', '') }}" class="block w-full py-3 px-4 rounded-xl text-center font-bold transition-all duration-300 {{ $isPopular ? 'bg-green-600 text-white hover:bg-green-700 shadow-lg hover:shadow-xl' : 'bg-green-50 text-green-700 hover:bg-green-100' }}">Chọn gói này</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif

                {{-- Hậu trường / Behind the Scenes (Media Gallery) --}}
                @if($service->behind_the_scenes && is_array($service->behind_the_scenes) && count($service->behind_the_scenes) > 0)
                <section class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b">Hậu trường Thực tế</h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 auto-rows-[200px]">
                        @foreach($service->behind_the_scenes as $index => $media)
                            @php
                                $extension = pathinfo($media, PATHINFO_EXTENSION);
                                $isVideo = in_array(strtolower($extension), ['mp4', 'webm', 'ogg', 'mov']);
                                // Make the first item take up more space for visual interest
                                $colSpan = $index === 0 ? 'col-span-2 row-span-2' : '';
                            @endphp
                            
                            <div class="relative rounded-2xl overflow-hidden bg-gray-100 group {{ $colSpan }}">
                                @if($isVideo)
                                    <video src="{{ asset('storage/' . $media) }}" class="w-full h-full object-cover" controls preload="metadata"></video>
                                @else
                                    <img src="{{ asset('storage/' . $media) }}" alt="Hậu trường {{ $service->name }}" loading="lazy" 
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 cursor-zoom-in">
                                @endif
                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                            </div>
                        @endforeach
                    </div>
                </section>
                @endif

                {{-- Quy trình triển khai --}}
                @if($service->process && is_array($service->process) && count($service->process) > 0)
                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-8 pb-4 border-b">Quy trình Triển khai</h2>
                    <div class="process-timeline mt-8">
                        @foreach($service->process as $index => $step)
                        <div class="process-step">
                            <div class="process-step-number">{{ $index + 1 }}</div>
                            <div class="bg-white border rounded-2xl p-6 shadow-sm flex-1 hover:shadow-md transition-shadow">
                                <h3 class="text-lg font-bold text-green-700 mb-2">{{ $step['title'] ?? '' }}</h3>
                                @if(!empty($step['description']))
                                    <p class="text-gray-600 text-sm leading-relaxed">{{ $step['description'] }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif
                
                {{-- FAQ --}}
                @if($service->faq && is_array($service->faq) && count($service->faq) > 0)
                <section x-data="{ activeAccordion: null }">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b">Câu hỏi thường gặp</h2>
                    <div class="space-y-4">
                        @foreach($service->faq as $index => $faq)
                        <div class="border rounded-2xl overflow-hidden bg-white">
                            <button @click="activeAccordion = activeAccordion === {{ $index }} ? null : {{ $index }}" 
                                    class="w-full px-6 py-4 flex justify-between items-center text-left hover:bg-gray-50 transition-colors">
                                <span class="font-bold text-gray-900">{{ $faq['question'] ?? '' }}</span>
                                <i class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-300" 
                                   :class="activeAccordion === {{ $index }} ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="activeAccordion === {{ $index }}" x-collapse>
                                <div class="px-6 pb-4 pt-2 text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                                    {{ $faq['answer'] ?? '' }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif

                {{-- Chia sẻ --}}
                <div class="flex flex-wrap items-center gap-3 py-6 border-t border-gray-100 text-sm text-gray-500">
                    <span>Chia sẻ dịch vụ:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1.5 bg-[#1877f2] text-white px-4 py-1.5 rounded-md text-xs font-semibold hover:opacity-90 transition-opacity">
                        <i class="fa-brands fa-facebook-f"></i> Facebook
                    </a>
                </div>
            </div>

            {{-- ── RIGHT SIDEBAR (STICKY CTA) ── --}}
            <aside class="w-full lg:w-80 shrink-0">
                <div class="sticky-cta space-y-6">
                    
                    {{-- CTA Box --}}
                    <div class="bg-gradient-to-br from-green-700 to-green-900 rounded-3xl p-6 md:p-8 text-white shadow-xl text-center relative overflow-hidden">
                        <div class="absolute top-0 right-0 opacity-10 transform translate-x-4 -translate-y-4">
                            <i class="fa-solid fa-rocket text-8xl"></i>
                        </div>
                        <div class="relative z-10">
                            <h3 class="font-bold text-xl mb-3">Sẵn sàng bắt đầu?</h3>
                            <p class="text-green-100 text-sm mb-6 leading-relaxed">Đội ngũ chuyên gia THT Media luôn sẵn lòng tư vấn giải pháp tối ưu nhất cho doanh nghiệp của bạn.</p>
                            
                            <a href="tel:{{ config('site.phone', '') }}" class="block w-full bg-white text-green-700 font-bold py-3 px-4 rounded-xl text-center hover:bg-gray-50 transition-colors shadow-lg hover:shadow-xl hover:-translate-y-0.5 transform mb-3">
                                <i class="fa-solid fa-phone-volume mr-2"></i> Gọi tư vấn ngay
                            </a>
                            <a href="{{ config('site.zalo', '#') }}" target="_blank" class="block w-full bg-[#0068FF] text-white font-bold py-3 px-4 rounded-xl text-center hover:bg-opacity-90 transition-colors shadow-lg">
                                Nhắn tin Zalo
                            </a>
                        </div>
                    </div>

                    {{-- Thông tin dịch vụ Box --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 hidden lg:block">
                        <h3 class="font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100">Thông tin tóm tắt</h3>
                        <ul class="space-y-4 text-sm text-gray-600">
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-tag text-green-600 mt-1"></i>
                                <span>
                                    <strong class="block text-gray-900">Chi phí</strong>
                                    {{ $service->price > 0 ? 'Từ ' . number_format($service->price) . '₫' : 'Liên hệ để được báo giá cực ưu đãi' }}
                                </span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-folder-tree text-green-600 mt-1"></i>
                                <span>
                                    <strong class="block text-gray-900">Danh mục</strong>
                                    {{ optional($category)->name ?? 'Chưa phân loại' }}
                                </span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-eye text-green-600 mt-1"></i>
                                <span>
                                    <strong class="block text-gray-900">Lượt quan tâm</strong>
                                    {{ number_format($service->view_count) }} lượt xem
                                </span>
                            </li>
                        </ul>
                    </div>

                </div>
            </aside>

        </div>
    </div>
</div>

{{-- ── DỊCH VỤ LIÊN QUAN BOTTOM GRID ── --}}
@if($related->isNotEmpty())
<section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Các Dịch vụ Xem thêm</h2>
            <a href="{{ route('services.index') }}" class="hidden md:inline-flex text-green-700 font-semibold hover:text-green-800 transition-colors items-center gap-2 text-sm">
                Xem tất cả <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 hover-gap-group">
            @foreach($related->take(4) as $item)
            <a href="{{ url($item->slug . '.html') }}" class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col h-full">
                <div class="relative h-48 overflow-hidden bg-gray-100">
                    @if($item->image)
                        <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <h3 class="text-[0.95rem] font-bold text-gray-900 leading-snug line-clamp-2 mb-2 group-hover:text-green-700 transition-colors flex-1">{{ $item->name }}</h3>
                    <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                        @if($item->price > 0)
                            <span class="text-sm font-bold text-red-600">{{ number_format($item->price) }}₫</span>
                        @else
                            <span class="text-xs text-green-700 font-semibold bg-green-50 px-2 py-1 rounded">Liên hệ</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "{{ addslashes($service->name) }}",
  "description": "{{ addslashes($service->summary ?? '') }}",
  "image": "{{ $service->image ? asset($service->image) : '' }}",
  "provider": { "@@type": "Organization", "name": "THT Media" },
  "url": "{{ url()->current() }}"
}
</script>
@endpush
