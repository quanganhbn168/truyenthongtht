@extends('layouts.master')

@section('content')
<div class="service-page py-8 pb-16">
    <div class="container mx-auto px-4 max-w-7xl">

        <x-breadcrumb :items="[
            ['label' => 'Dịch vụ', 'url' => route('services.index')],
            ['label' => optional($category)->name ?? '', 'url' => $category ? url($category->slug . '.html') : null],
            ['label' => $service->name],
        ]" />

        <div class="flex flex-col lg:flex-row gap-10 items-start mt-4">

            {{-- ── Article ── --}}
            <article class="min-w-0 flex-1 bg-white rounded-2xl shadow-sm overflow-hidden"
                     itemscope itemtype="https://schema.org/Service">

                <header class="px-8 pt-8 md:px-10">
                    @if($category)
                        <a href="{{ url($category->slug . '.html') }}"
                           class="inline-block bg-red-700 text-white text-xs font-semibold tracking-widest uppercase px-3 py-1 rounded-full mb-4 hover:bg-red-800 transition-colors">
                            {{ $category->name }}
                        </a>
                    @endif

                    <h1 class="text-2xl md:text-3xl font-bold leading-snug text-gray-900 mb-4" itemprop="name">
                        {{ $service->name }}
                    </h1>

                    <div class="flex flex-wrap gap-4 text-sm text-gray-500 pb-5 border-b border-gray-100 mb-5">
                        @if($service->price > 0)
                            <span class="font-bold text-red-700 text-base">
                                <i class="fa-solid fa-tag mr-1"></i>{{ number_format($service->price) }}₫
                            </span>
                        @else
                            <span><i class="fa-solid fa-tag text-red-700 mr-1"></i>Liên hệ để được báo giá</span>
                        @endif
                        <span>
                            <i class="fa-regular fa-eye text-red-700 mr-1"></i>
                            {{ number_format($service->view_count) }} lượt xem
                        </span>
                    </div>

                    @if($service->summary)
                        <p class="text-base text-gray-600 leading-relaxed pl-4 border-l-4 border-red-700 bg-gray-50 rounded-r-lg py-3 pr-3 mb-0"
                           itemprop="description">{{ $service->summary }}</p>
                    @endif
                </header>

                @if($service->image)
                    <figure class="mt-6">
                        <img src="{{ asset($service->image) }}" alt="{{ $service->name }}"
                             itemprop="image" loading="eager"
                             class="w-full h-auto object-cover max-h-[500px]">
                    </figure>
                @endif

                <div class="service-article__body px-6 md:px-10 py-8 prose prose-lg max-w-none">
                    {!! $service->content !!}
                </div>

                {{-- Chia sẻ --}}
                <div class="flex flex-wrap items-center gap-3 px-8 md:px-10 py-4 border-t border-gray-100 text-sm text-gray-500">
                    <span>Chia sẻ:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1.5 bg-[#1877f2] text-white px-4 py-1.5 rounded-md text-xs font-semibold hover:opacity-90 transition-opacity">
                        <i class="fa-brands fa-facebook-f"></i> Facebook
                    </a>
                </div>

                {{-- Bài viết liên quan từ pivot --}}
                @if($service->posts->isNotEmpty())
                    <div class="px-6 md:px-10 pb-8 border-t border-gray-100 pt-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-5">
                            <i class="fa-regular fa-newspaper text-red-700 mr-2"></i>Bài viết liên quan
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($service->posts->where('is_active', true)->take(4) as $post)
                                <a href="{{ url($post->slug . '.html') }}"
                                   class="group flex gap-3 bg-gray-50 rounded-xl p-3 hover:bg-red-50 transition-colors">
                                    @if($post->image)
                                        <img src="{{ asset($post->image) }}" alt="{{ $post->title }}"
                                             loading="lazy" class="w-20 h-14 object-cover rounded-lg shrink-0">
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <span class="block text-sm font-semibold text-gray-800 leading-snug group-hover:text-red-700 transition-colors line-clamp-2">
                                            {{ $post->title }}
                                        </span>
                                        <span class="text-xs text-gray-400">{{ optional($post->published_at)->format('d/m/Y') }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </article>

            {{-- ── Sidebar ── --}}
            <aside class="hidden lg:block w-80 shrink-0 space-y-5 sticky top-24 self-start">

                @if($related->isNotEmpty())
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h2 class="text-sm font-bold text-gray-900 pb-3 border-b-2 border-red-700 mb-4">Dịch vụ liên quan</h2>
                        <ul class="space-y-4">
                            @foreach($related as $item)
                                <li class="border-t border-gray-50 pt-4 first:border-0 first:pt-0">
                                    <a href="{{ url($item->slug . '.html') }}" class="flex gap-3 group">
                                        @if($item->image)
                                            <img src="{{ asset($item->image) }}" alt="{{ $item->name }}"
                                                 loading="lazy" class="w-20 h-14 object-cover rounded-lg shrink-0">
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <span class="block text-sm font-semibold text-gray-800 group-hover:text-red-700 transition-colors line-clamp-2 mb-1">
                                                {{ Str::limit($item->name, 55) }}
                                            </span>
                                            @if($item->price > 0)
                                                <span class="text-xs text-red-700 font-semibold">{{ number_format($item->price) }}₫</span>
                                            @endif
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-red-700 rounded-2xl p-6 text-white text-center">
                    <i class="fa-solid fa-phone-volume text-3xl mb-3 block"></i>
                    <h3 class="font-bold text-lg mb-1">Tư vấn miễn phí</h3>
                    <p class="text-sm text-red-100 mb-4">Liên hệ ngay để được tư vấn chi tiết</p>
                    <a href="tel:{{ config('site.phone', '') }}"
                       class="inline-block bg-white text-red-700 font-bold px-6 py-2 rounded-full text-sm hover:bg-red-50 transition-colors">
                        Gọi ngay
                    </a>
                </div>

            </aside>

        </div>
    </div>
</div>
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
