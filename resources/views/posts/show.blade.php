@extends('layouts.master')

@section('content')
<div class="post-page py-8 pb-16">
    <div class="container mx-auto px-4 max-w-7xl">

        <x-breadcrumb :items="[
            ['label' => 'Tin tức', 'url' => route('posts.index')],
            ['label' => optional($post->category)->name ?? '', 'url' => $post->category ? url($post->category->slug . '.html') : null],
            ['label' => $post->title],
        ]" />

        <div class="flex flex-col lg:flex-row gap-10 items-start mt-4">

            {{-- ── Main article ── --}}
            <article class="min-w-0 flex-1 bg-white rounded-2xl shadow-sm overflow-hidden"
                     itemscope itemtype="https://schema.org/Article">

                <header class="px-8 pt-8 md:px-10">
                    @if($post->category)
                        <a href="{{ url($post->category->slug . '.html') }}"
                           class="inline-block bg-orange-700 text-white text-xs font-semibold tracking-widest uppercase px-3 py-1 rounded-full mb-4 hover:bg-orange-800 transition-colors">
                            {{ $post->category->name }}
                        </a>
                    @endif

                    <h1 class="post-article__title"
                        itemprop="headline">{{ $post->title }}</h1>

                    <div class="flex flex-wrap gap-4 text-sm text-gray-500 pb-5 border-b border-gray-100 mb-5">
                        <span itemprop="datePublished" content="{{ optional($post->published_at)->toIso8601String() }}">
                            <i class="fa-regular fa-calendar text-orange-700 mr-1"></i>
                            {{ optional($post->published_at)->format('d/m/Y') }}
                        </span>
                        <span>
                            <i class="fa-regular fa-eye text-orange-700 mr-1"></i>
                            {{ number_format($post->view_count) }} lượt xem
                        </span>
                    </div>

                    @if($post->summary)
                        <p class="text-base text-gray-600 leading-relaxed
                                  pl-4 border-l-4 border-orange-700 bg-gray-50 rounded-r-lg py-3 pr-3 mb-0"
                           itemprop="description">{{ $post->summary }}</p>
                    @endif
                </header>

                @if($post->image)
                    <figure class="mt-6">
                        <img src="{{ asset($post->image) }}"
                             alt="{{ $post->title }}"
                             itemprop="image"
                             loading="eager"
                             class="w-full h-auto object-cover max-h-[500px]">
                    </figure>
                @endif

                {{-- Mobile TOC (inline, before body) --}}
                <div class="block lg:hidden px-6 md:px-10 mt-6">
                    <x-toc :content="$content" placement="mobile" />
                </div>

                <div class="post-article__body px-6 md:px-10 py-8 prose prose-lg max-w-none" itemprop="articleBody">
                    {!! $content !!}
                </div>

                @if($post->tags)
                    <div class="flex flex-wrap gap-2 px-8 md:px-10 pb-6 items-center text-sm text-gray-500">
                        <i class="fa-solid fa-hashtag text-orange-700"></i>
                        @foreach(array_filter(array_map('trim', explode(',', $post->tags))) as $tag)
                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs
                                         hover:bg-orange-700 hover:text-white transition-colors cursor-default">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <div class="flex flex-wrap items-center gap-3 px-8 md:px-10 py-4 border-t border-gray-100 text-sm text-gray-500">
                    <span>Chia sẻ:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1.5 bg-[var(--color-social-facebook)] text-white px-4 py-1.5 rounded-md text-xs font-semibold hover:opacity-90 transition-opacity">
                        <i class="fa-brands fa-facebook-f"></i> Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1.5 bg-[var(--color-social-x)] text-white px-4 py-1.5 rounded-md text-xs font-semibold hover:opacity-90 transition-opacity">
                        <i class="fa-brands fa-twitter"></i> Twitter
                    </a>
                </div>

                <x-review model="post" :model-id="$post->id" title="Bình luận" />

                {{-- ── Dịch vụ liên quan (từ pivot) ── --}}
                @if($post->services->isNotEmpty())
                    <div class="px-6 md:px-10 pb-8 border-t border-gray-100 pt-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-5">
                            <i class="fa-solid fa-wand-magic-sparkles text-orange-700 mr-2"></i>
                            Dịch vụ liên quan
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($post->services->where('is_active', true) as $service)
                                <a href="{{ url($service->slug . '.html') }}"
                                   class="group flex gap-3 bg-gray-50 rounded-xl p-3 hover:bg-orange-50 transition-colors">
                                    @if($service->image)
                                        <img src="{{ asset($service->image) }}"
                                             alt="{{ $service->name }}"
                                             loading="lazy"
                                             class="w-20 h-14 object-cover rounded-lg shrink-0">
                                    @else
                                        <div class="w-20 h-14 bg-[var(--color-brand-50)] rounded-lg shrink-0 flex items-center justify-center">
                                            <i class="fa-solid fa-wand-magic-sparkles text-orange-300"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <span class="block text-sm font-semibold text-gray-800 leading-snug
                                                     group-hover:text-orange-700 transition-colors line-clamp-2 mb-1">
                                            {{ $service->name }}
                                        </span>
                                        @if($service->price > 0)
                                            <span class="text-xs text-orange-700 font-semibold">
                                                {{ number_format($service->price) }}₫
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">Liên hệ báo giá</span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </article>

            {{-- ── Sidebar (desktop only) ── --}}
            <aside class="hidden lg:block w-80 shrink-0 space-y-5 sticky top-24 self-start">

                <x-toc :content="$content" placement="desktop" />

                @if($related->isNotEmpty())
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h2 class="text-sm font-bold text-gray-900 pb-3 border-b-2 border-orange-700 mb-4">
                            Bài viết liên quan
                        </h2>
                        <ul class="space-y-4">
                            @foreach($related as $item)
                                <li class="border-t border-gray-50 pt-4 first:border-0 first:pt-0">
                                    <a href="{{ url($item->slug . '.html') }}"
                                       class="flex gap-3 group text-inherit no-underline">
                                        @if($item->image)
                                            <img src="{{ asset($item->image) }}"
                                                 alt="{{ $item->title }}"
                                                 loading="lazy"
                                                 class="w-20 h-14 object-cover rounded-lg shrink-0">
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <span class="block text-sm font-semibold text-gray-800 leading-snug
                                                         group-hover:text-orange-700 transition-colors line-clamp-2 mb-1">
                                                {{ Str::limit($item->title, 55) }}
                                            </span>
                                            <span class="text-xs text-gray-400">
                                                <i class="fa-regular fa-calendar mr-1"></i>
                                                {{ optional($item->published_at)->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </aside>

        </div>
    </div>
</div>
@endsection

@push('head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Article",
  "headline": "{{ addslashes($post->title) }}",
  "description": "{{ addslashes($post->summary ?? '') }}",
  "image": "{{ $post->image ? asset($post->image) : '' }}",
  "datePublished": "{{ optional($post->published_at)->toIso8601String() }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}",
  "author": { "@@type": "Organization", "name": "THT Media" },
  "publisher": { "@@type": "Organization", "name": "THT Media" },
  "mainEntityOfPage": { "@@type": "WebPage", "@@id": "{{ url()->current() }}" }
}
</script>
@endpush
