@extends('layouts.master')

@section('content')
<div class="py-8 pb-20">
    <div class="container mx-auto px-4 max-w-7xl">

        {{-- Breadcrumb --}}
        <x-breadcrumb :items="[['label' => 'Tin tức & Sự kiện']]" />

        {{-- ── Hero header ── --}}
        <div class="my-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                @if($category) {{ $category->name }} @else Tin tức & Sự kiện @endif
            </h1>
            <p class="text-gray-500 mt-1 text-sm">
                @if($category && $category->description)
                    {{ $category->description }}
                @else
                    Cập nhật tin tức mới nhất từ THT Media
                @endif
            </p>
        </div>

        {{-- ── Category pills — chỉ hiện trên mobile/tablet (ẩn khi lg+) ── --}}
        <div class="flex flex-wrap gap-2 mb-8 lg:hidden">
            <a href="{{ route('posts.index') }}"
               class="px-4 py-1.5 rounded-full text-xs font-semibold border transition-colors
                      {{ !$category ? 'bg-red-700 text-white border-red-700' : 'bg-white text-gray-600 border-gray-200 hover:border-red-700 hover:text-red-700' }}">
                Tất cả
            </a>
            @foreach($categories as $cat)
            <a href="{{ url($cat->slug . '.html') }}"
               class="px-4 py-1.5 rounded-full text-xs font-semibold border transition-colors
                      {{ $category?->id === $cat->id ? 'bg-red-700 text-white border-red-700' : 'bg-white text-gray-600 border-gray-200 hover:border-red-700 hover:text-red-700' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>

        <div class="flex flex-col lg:flex-row gap-10 items-start">

            {{-- ── Main: post grid ── --}}
            <div class="flex-1 min-w-0">
                @if($posts->isEmpty())
                    <div class="text-center py-24 text-gray-400">
                        <i class="fa-regular fa-newspaper text-5xl mb-4 block opacity-40"></i>
                        <p class="text-sm">Chưa có bài viết nào trong danh mục này.</p>
                    </div>
                @else
                    {{-- Bài nổi bật — bài đầu tiên --}}
                    @php $featured = $posts->first(); @endphp
                    <a href="{{ url($featured->slug . '.html') }}"
                       class="group flex flex-col sm:flex-row gap-0 bg-white rounded-2xl shadow-sm overflow-hidden mb-6 hover:shadow-md transition-shadow">
                        @if($featured->image)
                            <div class="sm:w-2/5 shrink-0 overflow-hidden">
                                <img src="{{ asset($featured->image) }}"
                                     alt="{{ $featured->title }}"
                                     loading="eager"
                                     class="w-full h-56 sm:h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            </div>
                        @endif
                        <div class="flex flex-col justify-center p-6 sm:p-8 flex-1">
                            @if($featured->category)
                                <span class="text-xs font-bold text-red-700 uppercase tracking-widest mb-2">
                                    {{ $featured->category->name }}
                                </span>
                            @endif
                            <h2 class="text-xl md:text-2xl font-bold text-gray-900 leading-snug mb-3
                                       group-hover:text-red-700 transition-colors line-clamp-3">
                                {{ $featured->title }}
                            </h2>
                            @if($featured->summary)
                                <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $featured->summary }}</p>
                            @endif
                            <div class="flex items-center gap-4 text-xs text-gray-400">
                                <span><i class="fa-regular fa-calendar mr-1"></i>{{ optional($featured->published_at)->format('d/m/Y') }}</span>
                                <span><i class="fa-regular fa-eye mr-1"></i>{{ number_format($featured->view_count) }}</span>
                            </div>
                        </div>
                    </a>

                    {{-- Grid các bài còn lại --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
                        @foreach($posts->skip(1) as $post)
                        <article class="group bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col
                                        hover:shadow-md transition-shadow">
                            <a href="{{ url($post->slug . '.html') }}" class="block overflow-hidden shrink-0">
                                @if($post->image)
                                    <img src="{{ asset($post->image) }}"
                                         alt="{{ $post->title }}"
                                         loading="lazy"
                                         class="w-full aspect-[4/3] object-cover transition-transform duration-300 group-hover:scale-105">
                                @else
                                    <div class="w-full aspect-[4/3] bg-gray-100 flex items-center justify-center">
                                        <i class="fa-regular fa-image text-3xl text-gray-300"></i>
                                    </div>
                                @endif
                            </a>
                            <div class="p-5 flex flex-col flex-1">
                                @if($post->category)
                                    <span class="text-xs font-bold text-red-700 uppercase tracking-wide mb-1">
                                        {{ $post->category->name }}
                                    </span>
                                @endif
                                <h2 class="text-[0.95rem] font-bold text-gray-900 leading-snug line-clamp-2 mb-2 flex-1
                                           group-hover:text-red-700 transition-colors">
                                    <a href="{{ url($post->slug . '.html') }}">{{ $post->title }}</a>
                                </h2>
                                @if($post->summary)
                                    <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ $post->summary }}</p>
                                @endif
                                <div class="flex items-center justify-between text-xs text-gray-400 mt-auto pt-3 border-t border-gray-100">
                                    <span><i class="fa-regular fa-calendar mr-1"></i>{{ optional($post->published_at)->format('d/m/Y') }}</span>
                                    <span><i class="fa-regular fa-eye mr-1"></i>{{ number_format($post->view_count) }}</span>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($posts->hasPages())
                        <div class="flex justify-center mt-8">
                            {{ $posts->appends(request()->query())->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                @endif
            </div>

            {{-- ── Sidebar (desktop) ── --}}
            <aside class="hidden lg:block w-64 xl:w-72 shrink-0 sticky top-24 self-start">
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="text-sm font-bold text-gray-900 pb-3 border-b-2 border-red-700 mb-4">
                        Danh mục
                    </h2>
                    <ul class="space-y-0.5">
                        <li>
                            <a href="{{ route('posts.index') }}"
                               class="flex items-center px-3 py-2 rounded-lg text-sm transition-colors gap-2
                                      {{ !$category ? 'bg-red-50 text-red-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-red-700' }}">
                                <i class="fa-solid fa-border-all text-[10px] opacity-50"></i>
                                Tất cả bài viết
                            </a>
                        </li>
                        @foreach($categories as $cat)
                        <li>
                            <a href="{{ url($cat->slug . '.html') }}"
                               class="flex items-center px-3 py-2 rounded-lg text-sm transition-colors gap-2
                                      {{ $category?->id === $cat->id ? 'bg-red-50 text-red-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-red-700' }}">
                                <i class="fa-regular fa-folder text-[10px] opacity-40"></i>
                                {{ $cat->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

        </div>
    </div>
</div>
@endsection
