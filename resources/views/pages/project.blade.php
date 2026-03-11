@extends('layouts.master')

@push('styles')
<style>
    .project-hero {
        position: relative;
        background-color: #111827;
        color: white;
        overflow: hidden;
    }
    
    .project-hero-media {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }

    .project-hero-media img, .project-hero-media iframe, .project-hero-media video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        pointer-events: none; /* If background video */
    }

    .project-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(17,24,39,1) 0%, rgba(17,24,39,0.7) 40%, rgba(17,24,39,0.3) 100%);
        pointer-events: none;
    }

    .project-hero-content {
        position: relative;
        z-index: 10;
        padding: 8rem 0 4rem;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        min-height: 60vh;
    }

    .brief-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    /* Play Video overlay if it's a TVC */
    .play-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 20;
        background: rgba(0,0,0,0.3);
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .project-hero:hover .play-overlay {
        opacity: 1;
    }
</style>
@endpush

@section('content')

{{-- ── HERO / TVC SECTION ── --}}
<section class="project-hero">
    <div class="project-hero-media" id="hero-media-container">
        @if($project->hero_media_type === 'youtube' && $project->hero_media_url)
            @php
                // Extract video ID from youtube URL
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $project->hero_media_url, $match);
                $youtube_id = $match[1] ?? null;
            @endphp
            
            @if($youtube_id)
                <iframe src="https://www.youtube.com/embed/{{ $youtube_id }}?autoplay=1&mute=1&controls=0&loop=1&playlist={{ $youtube_id }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                {{-- Invisible overlay to show play button --}}
                <a href="{{ $project->hero_media_url }}" target="_blank" class="play-overlay group">
                    <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center text-white text-3xl group-hover:scale-110 transition-transform shadow-green-600/50 shadow-2xl">
                        <i class="fa-solid fa-play ml-1"></i>
                    </div>
                </a>
            @endif
        @elseif($project->hero_media_type === 'external' && $project->hero_media_url)
            @php
                $url = $project->hero_media_url;
                $isGoogleDrive = preg_match('%drive\.google\.com/file/d/([^/]+)%i', $url, $gdMatch);
                
                if ($isGoogleDrive) {
                    $driveId = $gdMatch[1];
                    $driveEmbedUrl = "https://drive.google.com/file/d/{$driveId}/preview";
                } else {
                    $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
                    $isVideo = in_array($ext, ['mp4', 'webm', 'ogg']);
                }
            @endphp
            
            @if($isGoogleDrive)
                <iframe src="{{ $driveEmbedUrl }}" width="100%" height="100%" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                {{-- Invisible overlay to show play button on top of drive iframe for consistent UI --}}
                <a href="{{ $url }}" target="_blank" class="play-overlay group">
                    <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center text-white text-3xl group-hover:scale-110 transition-transform shadow-green-600/50 shadow-2xl">
                        <i class="fa-solid fa-play ml-1"></i>
                    </div>
                </a>
            @elseif(isset($isVideo) && $isVideo)
                <video src="{{ $url }}" autoplay loop muted playsinline controlsList="nodownload"></video>
            @else
                <img src="{{ $url }}" alt="{{ $project->name }}">
            @endif
        @elseif($project->image)
            <img src="{{ Storage::url($project->image) }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
        @else
            <div class="bg-gray-800 w-full h-full"></div>
        @endif
    </div>

    <div class="project-hero-content container mx-auto px-4 max-w-7xl">
        <x-breadcrumb :items="[
            ['label' => 'Dự án', 'url' => route('projects.index')],
            ['label' => $category->name ?? 'Tất cả', 'url' => $category ? url($category->slug . '.html') : '#'],
            ['label' => Str::limit($project->name, 40)]
        ]" class="text-gray-300 mb-6" />

        <div class="flex flex-col lg:flex-row gap-10 items-end justify-between">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl lg:text-5xl font-extrabold text-white leading-tight mb-4 drop-shadow-md">
                    {{ $project->name }}
                </h1>
                @if($project->summary)
                    <p class="text-lg text-gray-300 leading-relaxed drop-shadow-sm">{{ $project->summary }}</p>
                @endif
            </div>

            {{-- Brief Card --}}
            <div class="brief-card rounded-2xl p-6 md:p-8 w-full lg:w-96 shrink-0 shadow-2xl">
                <h3 class="text-white font-bold text-lg mb-5 pb-3 border-b border-white/20">Thông tin dự án</h3>
                <ul class="space-y-4 text-sm">
                    @if($project->client_name)
                    <li class="flex items-start gap-4">
                        <i class="fa-regular fa-building text-green-500 mt-1 text-lg"></i>
                        <div>
                            <span class="block text-gray-400 text-xs uppercase tracking-wider mb-1">Đối tác</span>
                            <strong class="text-white text-base">{{ $project->client_name }}</strong>
                        </div>
                    </li>
                    @endif
                    
                    @if($project->project_date)
                    <li class="flex items-start gap-4">
                        <i class="fa-regular fa-calendar-check text-green-500 mt-1 text-lg"></i>
                        <div>
                            <span class="block text-gray-400 text-xs uppercase tracking-wider mb-1">Hoàn thành</span>
                            <strong class="text-white text-base">{{ optional($project->project_date)->format('m/Y') }}</strong>
                        </div>
                    </li>
                    @endif

                    @if($project->services->isNotEmpty())
                    <li class="flex items-start gap-4">
                        <i class="fa-solid fa-cubes text-green-500 mt-1 text-lg"></i>
                        <div>
                            <span class="block text-gray-400 text-xs uppercase tracking-wider mb-1">Dịch vụ áp dụng</span>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($project->services as $sv)
                                    <a href="{{ url($sv->slug . '.html') }}" class="bg-green-600/20 text-green-400 hover:bg-green-500 hover:text-white transition-colors px-2.5 py-1 rounded text-xs font-semibold">
                                        {{ $sv->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ── MAIN STORY & SHOWCASE ── --}}
<div class="py-16 md:py-24 bg-white">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex flex-col lg:flex-row gap-12 xl:gap-20">
            
            {{-- Left Column: Challenge & Solution --}}
            <div class="w-full lg:w-5/12 shrink-0 space-y-12">
                @if($project->challenge)
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 uppercase tracking-wider text-sm border-b pb-3">
                        01. Bài toán đặt ra
                    </h2>
                    <div class="prose prose-lg text-gray-600 leading-relaxed max-w-none">
                        {!! $project->challenge !!}
                    </div>
                </div>
                @endif

                @if($project->solution)
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 uppercase tracking-wider text-sm border-b pb-3">
                        02. Giải pháp từ THT
                    </h2>
                    <div class="prose prose-lg text-gray-600 leading-relaxed max-w-none">
                        {!! $project->solution !!}
                    </div>
                </div>
                @endif

                @if($project->result)
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 uppercase tracking-wider text-sm border-b pb-3">
                        03. Kết quả đạt được
                    </h2>
                    <div class="prose prose-lg text-gray-600 leading-relaxed max-w-none bg-green-50/30 p-6 rounded-2xl border border-green-100">
                        {!! $project->result !!}
                    </div>
                </div>
                @endif

                {{-- Legacy text Content --}}
                @if($project->content && !$project->challenge && !$project->solution)
                    <div class="prose prose-lg text-gray-600">
                        {!! $project->content !!}
                    </div>
                @endif
            </div>

            {{-- Right Column: Media Gallery / Visuals --}}
            <div class="w-full lg:w-7/12">
                @if($project->gallery && count($project->gallery) > 0)
                    <div class="grid grid-cols-2 gap-4 auto-rows-[250px] md:auto-rows-[300px]">
                        @foreach($project->gallery as $index => $media)
                            @php
                                $extension = pathinfo($media, PATHINFO_EXTENSION);
                                $isVideo = in_array(strtolower($extension), ['mp4', 'webm', 'ogg', 'mov']);
                                // Large features for odd/even indexes to make masonry dynamic
                                $colSpan = ($index % 3 === 0) ? 'col-span-2' : 'col-span-1';
                            @endphp
                            
                            <div class="relative rounded-2xl overflow-hidden bg-gray-100 group shadow-sm {{ $colSpan }}">
                                @if($isVideo)
                                    <video src="{{ Storage::url($media) }}" class="w-full h-full object-cover" controls preload="metadata"></video>
                                @else
                                    <img src="{{ Storage::url($media) }}" alt="Gallery {{ $index }}" loading="lazy" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                @endif
                                <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors duration-300 pointer-events-none"></div>
                            </div>
                        @endforeach
                    </div>
                @elseif($project->content && ($project->challenge || $project->solution))
                    {{-- If they just put content in the old rich editor --}}
                    <div class="prose prose-lg text-gray-600 max-w-none bg-gray-50 p-8 rounded-3xl">
                        {!! $project->content !!}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

{{-- ── CTA FOOTER ── --}}
<section class="py-20 bg-green-50 border-t border-green-100">
    <div class="container mx-auto px-4 max-w-4xl text-center">
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6">Bạn ấn tượng với dự án này?</h2>
        <p class="text-lg text-gray-600 mb-10">THT Media luôn sẵn sàng đồng hành cùng doanh nghiệp của bạn để tạo ra những chiến dịch bùng nổ tiếp theo.</p>
        
        <div class="flex flex-wrap justify-center gap-4">
            <a href="tel:{{ config('site.phone', '') }}" class="bg-green-700 text-white hover:bg-green-800 px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all flex items-center gap-2">
                <i class="fa-solid fa-phone-volume"></i> Gọi chuyên gia ngay
            </a>
            <a href="{{ route('contact.index') }}" class="bg-white text-green-700 hover:bg-gray-50 px-8 py-4 rounded-full font-bold text-lg shadow-md border border-gray-200 transition-colors">
                Để lại lời nhắn
            </a>
        </div>
    </div>
</section>

{{-- ── RELATED PROJECTS ── --}}
@if($related->isNotEmpty())
<section class="py-16 bg-white border-t border-gray-100">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-3xl font-bold text-gray-900">Dự án Tương tự</h2>
            <a href="{{ route('projects.index') }}" class="hidden md:flex text-green-700 font-semibold hover:text-green-800 transition-colors items-center gap-2">
                Xem tất cả Portfolio <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($related->take(3) as $relProject)
                <a href="{{ url($relProject->slug . '.html') }}" class="group bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 block">
                    <div class="relative w-full aspect-[4/3] overflow-hidden bg-gray-100">
                        @if($relProject->image)
                            <img src="{{ Storage::url($relProject->image) }}" alt="{{ $relProject->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/10 to-transparent opacity-80 group-hover:opacity-100 transition-opacity"></div>
                        
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            @if($relProject->client_name)
                                <span class="text-green-400 text-xs font-bold uppercase tracking-widest block mb-2">{{ $relProject->client_name }}</span>
                            @endif
                            <h3 class="text-xl font-bold text-white leading-snug">{{ Str::limit($relProject->name, 60) }}</h3>
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
  "@@type": "Article",
  "name": "{{ addslashes($project->name) }}",
  "description": "{{ addslashes($project->summary ?? '') }}",
  "image": "{{ $project->image ? url(Storage::url($project->image)) : '' }}",
  "publisher": {
    "@@type": "Organization",
    "name": "THT Media"
  }
}
</script>
@endpush
