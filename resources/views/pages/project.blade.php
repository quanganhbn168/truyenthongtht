@extends('layouts.master')

@section('content')
<div class="py-10 pb-20 bg-gray-50/30">
    <div class="container mx-auto px-4 max-w-7xl">
        {{-- Breadcrumb --}}
        <x-breadcrumb :items="[
            ['label' => 'Dự án', 'url' => route('projects.index')],
            ['label' => $category->name ?? 'Chi tiết dự án', 'url' => $category ? url($category->slug . '.html') : '#'],
            ['label' => Str::limit($project->name, 40)]
        ]" />

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 mt-6 lg:mt-8">
            {{-- Main Content --}}
            <article class="lg:col-span-8 bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                {{-- Hero Banner --}}
                @if($project->image)
                    <div class="relative w-full aspect-[16/9] md:aspect-[21/9]">
                        <img src="{{ asset($project->image) }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/20 to-transparent"></div>
                        
                        {{-- Floating Info over Image --}}
                        <div class="absolute bottom-6 left-6 right-6 md:bottom-10 md:left-10 md:right-10 flex flex-wrap items-center gap-4 text-white/90">
                            @if($project->services->isNotEmpty())
                                @foreach($project->services as $service)
                                    <span class="bg-red-700 text-white text-[10px] uppercase font-bold tracking-widest px-3 py-1.5 rounded-sm shadow-md">
                                        {{ $service->name }}
                                    </span>
                                @endforeach
                            @elseif($category)
                            <span class="flex items-center gap-1.5 text-sm font-medium"><i class="fa-regular fa-calendar"></i> {{ optional($project->project_date ?? $project->created_at)->format('d/m/Y') }}</span>
                            <span class="flex items-center gap-1.5 text-sm font-medium"><i class="fa-regular fa-eye"></i> {{ number_format($project->view_count ?? 0) }}</span>
                        </div>
                    </div>
                @endif

                <div class="p-6 md:p-10">
                    {{-- Title & Summary --}}
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-4">
                        {{ $project->name }}
                    </h1>
                    
                    @if($project->summary)
                        <div class="text-lg md:text-xl text-gray-600 font-medium leading-relaxed mb-8 pb-8 border-b border-gray-100">
                            {{ $project->summary }}
                        </div>
                    @endif

                    {{-- Client & Meta Info Grid --}}
                    @if($project->client_name)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-6 mb-10 bg-gray-50 rounded-2xl border border-gray-100/60">
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Khách hàng / Đối tác</span>
                            <span class="text-base font-semibold text-gray-900">{{ $project->client_name }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Thời gian thực hiện</span>
                            <span class="text-base font-semibold text-gray-900">{{ optional($project->project_date)->format('m/Y') ?? 'Đã hoàn thành' }}</span>
                        </div>
                    </div>
                    @endif

                    {{-- Main Content HTML (TinyMCE) --}}
                    <div class="prose prose-lg max-w-none prose-img:rounded-xl prose-img:shadow-sm prose-a:text-red-700 hover:prose-a:text-red-800 prose-headings:text-gray-900 prose-p:text-gray-600">
                        @if($project->content)
                            {!! $project->content !!}
                        @else
                            <p class="text-gray-400 italic">Nội dung chi tiết đang được cập nhật...</p>
                        @endif
                    </div>
                    
                    {{-- Social Share (Optional standard block) --}}
                    <div class="mt-12 pt-6 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-500 uppercase tracking-widest">Chia sẻ dự án:</span>
                        <div class="flex items-center gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($project->name) }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center hover:bg-sky-500 hover:text-white transition-colors"><i class="fa-brands fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </article>

            {{-- Sidebar --}}
            <aside class="lg:col-span-4 space-y-8">
                {{-- CTA Widget --}}
                <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl p-8 text-center shadow-lg relative overflow-hidden group">
                    <div class="absolute inset-0 bg-red-700/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out z-0"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-5 backdrop-blur-sm">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Tư vấn dự án tương tự</h3>
                        <p class="text-gray-400 text-sm mb-6">Bạn ấn tượng với dự án này? Hãy liên hệ ngay với THT Media để nhận tư vấn và báo giá chi tiết cho doanh nghiệp của bạn.</p>
                        <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center w-full bg-red-700 hover:bg-red-600 text-white font-bold py-3.5 px-6 rounded-xl transition-colors shadow-lg shadow-red-700/30">
                            Liên hệ tư vấn <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>

                {{-- Related Projects --}}
                @if($related->isNotEmpty())
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 md:p-8">
                        <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-4 mb-6 relative">
                            Dự án cùng dịch vụ
                            <span class="absolute left-0 bottom-0 w-12 h-0.5 bg-red-700"></span>
                        </h3>
                        
                        <div class="space-y-5">
                            @foreach($related as $relProject)
                                <a href="{{ url($relProject->slug . '.html') }}" class="group flex items-start gap-4">
                                    <div class="w-24 h-20 rounded-xl overflow-hidden shrink-0 bg-gray-100">
                                        @if($relProject->image)
                                            <img src="{{ asset($relProject->image) }}" alt="{{ $relProject->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300 relative z-10"><i class="fa-solid fa-image text-xl"></i></div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0 py-1">
                                        <h4 class="font-bold text-gray-900 text-sm line-clamp-2 leading-snug group-hover:text-red-700 transition-colors mb-2">
                                            {{ $relProject->name }}
                                        </h4>
                                        <div class="flex items-center gap-3 text-[10px] text-gray-400 uppercase font-bold tracking-wider">
                                            @if($relProject->services->isNotEmpty())
                                                <span>{{ Str::limit($relProject->services->first()->name, 30) }}</span>
                                            @elseif($relProject->client_name)
                                                <span>{{ Str::limit($relProject->client_name, 15) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </div>
</div>
@endsection
