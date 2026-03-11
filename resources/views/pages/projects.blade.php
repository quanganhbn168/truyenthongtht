@extends('layouts.master')

@section('content')
{{-- ── Premium Hero Header ── --}}
<div class="relative bg-gray-900 overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-900/95 to-red-900/40"></div>
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-red-600/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-red-800/20 rounded-full blur-[80px]"></div>
    </div>
    
    <div class="relative z-10 pt-32 pb-20 md:pt-40 md:pb-28">
        <div class="container mx-auto px-4 max-w-7xl text-center">
            {{-- Breadcrumb (Dark variant) --}}
            <nav class="flex justify-center text-sm mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/10">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-house text-xs"></i>
                            Trang chủ
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-500 text-xs mx-2"></i>
                            <span class="text-white font-medium">
                                @if(isset($category) && $category) {{ $category->name }} @else Dự án tiêu biểu @endif
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 tracking-tight">
                @if(isset($category) && $category) {{ $category->name }} @else Các Dự Án <span class="text-red-500">Nổi Bật</span> @endif
            </h1>
            <p class="text-gray-400 text-lg md:text-xl max-w-3xl mx-auto font-light leading-relaxed">
                @if(isset($category) && $category && $category->description)
                    {{ $category->description }}
                @else
                    Khám phá những chiến dịch và sản phẩm truyền thông mang đậm dấu ấn sáng tạo do THT Media thực hiện, kiến tạo giá trị đột phá cho thương hiệu.
                @endif
            </p>
        </div>
    </div>
</div>

<div class="py-16 md:py-24 bg-zinc-50">
    <div class="container mx-auto px-4 max-w-7xl">

        {{-- ── Category Filter (Modern Pills) ── --}}
        <div class="flex flex-wrap justify-center gap-3 mb-16">
            <a href="{{ route('projects.index') }}"
               class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 transform hover:-translate-y-0.5
                      {{ !isset($category) || !$category ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-white text-gray-600 border border-gray-200 hover:border-red-600 hover:text-red-600 shadow-sm' }}">
                Tất cả dự án
            </a>
            @foreach($categories as $cat)
            <a href="{{ url($cat->slug . '.html') }}"
               class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 transform hover:-translate-y-0.5
                      {{ isset($category) && $category->id === $cat->id ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-white text-gray-600 border border-gray-200 hover:border-red-600 hover:text-red-600 shadow-sm' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>

        {{-- ── Main: Projects Grid ── --}}
        <div class="w-full">
            @if($projects->isEmpty())
                <div class="text-center py-24 text-gray-400 bg-white rounded-3xl border border-dashed border-gray-200">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-50 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-briefcase text-4xl text-gray-300"></i>
                    </div>
                    <p class="text-lg text-gray-500 font-medium">Chưa có dự án nào trong danh mục này.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10 mb-16">
                    @foreach($projects as $index => $project)
                    <article class="group bg-white rounded-3xl shadow-sm hover:shadow-2xl border border-gray-100 overflow-hidden flex flex-col transition-all duration-500 hover:-translate-y-2">
                        {{-- Image Wrapper (Interactive Context) --}}
                        <a href="{{ url($project->slug . ($project->slug ? '.html' : '')) }}" class="relative block overflow-hidden shrink-0">
                            @if($project->image)
                                <img src="{{ asset($project->image) }}"
                                     alt="{{ $project->title }}"
                                     loading="lazy"
                                     class="w-full aspect-[4/3] object-cover transition-transform duration-700 ease-out group-hover:scale-105">
                            @else
                                <div class="w-full aspect-[4/3] bg-zinc-100 flex items-center justify-center">
                                    <i class="fa-regular fa-image text-3xl text-zinc-300"></i>
                                </div>
                            @endif
                            
                            {{-- Dark Overlay --}}
                            <div class="absolute inset-0 bg-gray-900/10 group-hover:bg-gray-900/40 transition-colors duration-500"></div>
                            
                            {{-- View details button floating up --}}
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                <span class="bg-white text-red-600 px-6 py-3 rounded-full text-sm font-bold flex items-center gap-2 transform translate-y-8 group-hover:translate-y-0 transition-transform duration-500 ease-out shadow-xl">
                                    Xem Case Study <i class="fa-solid fa-arrow-right -rotate-45"></i>
                                </span>
                            </div>

                            {{-- Floating Category Badge inside image --}}
                            @if($project->category)
                                <span class="absolute top-4 left-4 z-10 bg-black/50 backdrop-blur-md text-white text-[10px] uppercase font-bold tracking-widest px-3 py-1.5 rounded-full border border-white/20">
                                    {{ $project->category->name }}
                                </span>
                            @endif
                        </a>

                        {{-- Details Content --}}
                        <div class="p-8 flex flex-col flex-1 relative bg-white">
                            @if($project->client_name)
                                <p class="text-xs font-bold text-red-600 tracking-wider uppercase mb-2">Thương hiệu: {{ $project->client_name }}</p>
                            @endif

                            <h2 class="text-xl md:text-2xl font-bold text-gray-900 leading-tight mb-4 group-hover:text-red-600 transition-colors">
                                <a href="{{ url($project->slug . ($project->slug ? '.html' : '')) }}">
                                    {{ $project->name }}
                                </a>
                            </h2>
                            
                            @if($project->summary)
                                <p class="text-base text-gray-500 line-clamp-2 md:line-clamp-3 mb-6 flex-1">{{ $project->summary }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between text-sm text-gray-400 pt-5 border-t border-gray-100/80">
                                <div class="flex items-center gap-4">
                                    <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-gray-300"></i> {{ optional($project->project_date ?? $project->created_at)->format('m/Y') }}</span>
                                </div>
                                <span class="flex items-center gap-1.5 rounded-full bg-gray-50 px-3 py-1 text-xs font-medium text-gray-500"><i class="fa-regular fa-eye"></i> {{ number_format($project->view_count ?? 0) }}</span>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                {{-- Pagination Pagination Template --}}
                @if($projects->hasPages())
                    <div class="flex justify-center mt-8">
                        {{ $projects->appends(request()->query())->links('vendor.pagination.custom') }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
