@extends('layouts.master')

@section('content')
<div class="py-10 pb-20">
    <div class="container mx-auto px-4 max-w-7xl">

        {{-- Breadcrumb --}}
        <x-breadcrumb :items="[['label' => 'Dự án tiêu biểu']]" />

        {{-- ── Hero header ── --}}
        <div class="my-8 text-center max-w-2xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                @if(isset($category) && $category) {{ $category->name }} @else Dự án tiêu biểu @endif
            </h1>
            <p class="text-gray-500 text-sm md:text-base">
                @if(isset($category) && $category && $category->description)
                    {{ $category->description }}
                @else
                    Khám phá những dự án và giải pháp truyền thông nổi bật do THT Media thực hiện, mang lại giá trị bền vững cho đối tác và khách hàng.
                @endif
            </p>
        </div>

        {{-- ── Category Filter (Horizontal Tabs) ── --}}
        <div class="flex flex-wrap justify-center gap-2 mb-10">
            <a href="{{ route('projects.index') }}"
               class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200
                      {{ !isset($category) || !$category ? 'bg-red-700 text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:border-red-700 hover:text-red-700 shadow-sm' }}">
                Tất cả dự án
            </a>
            @foreach($categories as $cat)
            <a href="{{ url($cat->slug . '.html') }}"
               class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200
                      {{ isset($category) && $category->id === $cat->id ? 'bg-red-700 text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:border-red-700 hover:text-red-700 shadow-sm' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>

        {{-- ── Main: Projects Grid ── --}}
        <div class="w-full">
            @if($projects->isEmpty())
                <div class="text-center py-24 text-gray-400 bg-gray-50 rounded-3xl border border-gray-100 border-dashed">
                    <i class="fa-solid fa-briefcase text-5xl mb-4 block opacity-30"></i>
                    <p class="text-base text-gray-500 font-medium">Chưa có dự án nào trong danh mục này.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach($projects as $project)
                    <article class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        {{-- Image Wrapper (16:9 Aspect Ratio) --}}
                        <a href="{{ url($project->slug . ($project->slug ? '.html' : '')) }}" class="relative block overflow-hidden shrink-0">
                            @if($project->image)
                                <img src="{{ asset($project->image) }}"
                                     alt="{{ $project->title }}"
                                     loading="lazy"
                                     class="w-full aspect-[16/9] md:aspect-video object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="w-full aspect-[16/9] md:aspect-video bg-gray-100 flex items-center justify-center">
                                    <i class="fa-regular fa-image text-3xl text-gray-300"></i>
                                </div>
                            @endif
                            
                            {{-- Overlay Gradient on Hover --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            {{-- View details icon on hover --}}
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-75">
                                <span class="bg-white/90 text-red-700 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-bold flex items-center gap-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 shadow-lg">
                                    Xem chi tiết <i class="fa-solid fa-arrow-right"></i>
                                </span>
                            </div>
                        </a>

                        {{-- Content --}}
                        <div class="p-6 flex flex-col flex-1 relative bg-white">
                            {{-- Tucked-in Category Badge --}}
                            @if($project->category)
                                <span class="absolute -top-3 left-6 z-10 bg-red-700 text-white text-[10px] uppercase font-bold tracking-widest px-3 py-1 rounded-sm shadow-md">
                                    {{ $project->category->name }}
                                </span>
                            @endif
                            
                            <h2 class="text-lg font-bold text-gray-900 leading-snug line-clamp-2 mb-3 mt-1 group-hover:text-red-700 transition-colors">
                                <a href="{{ url($project->slug . ($project->slug ? '.html' : '')) }}" class="relative inline-block">
                                    {{ $project->title }}
                                    <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-red-700 transition-all duration-300 group-hover:w-full"></span>
                                </a>
                            </h2>
                            
                            @if($project->summary)
                                <p class="text-sm text-gray-500 line-clamp-2 mb-4 flex-1">{{ $project->summary }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between text-xs text-gray-400 pt-4 border-t border-gray-100">
                                <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar"></i> {{ optional($project->published_at ?? $project->created_at)->format('d/m/Y') }}</span>
                                <span class="flex items-center gap-1.5"><i class="fa-regular fa-eye"></i> {{ number_format($project->view_count ?? 0) }}</span>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                {{-- Pagination using the custom Tailwind template --}}
                @if($projects->hasPages())
                    <div class="flex justify-center mt-4">
                        {{ $projects->appends(request()->query())->links('vendor.pagination.custom') }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
