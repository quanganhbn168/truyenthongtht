@extends('layouts.master')

@section('content')
<div class="py-8 pb-20">
    <div class="container mx-auto px-4 max-w-7xl">

        <x-breadcrumb :items="[['label' => 'Dịch vụ']]" />

        <div class="my-8 md:my-12 text-center">
            <span class="brand-badge center">Giải pháp toàn diện</span>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mt-3">Dịch vụ <span class="h-light">nổi bật</span></h1>
            <p class="text-gray-500 mt-4 text-base md:text-lg max-w-2xl mx-auto">THT Media cung cấp hệ sinh thái dịch vụ truyền thông chuyên nghiệp, giúp nâng tầm hệ thống nhận diện thương hiệu của bạn.</p>
        </div>

        <div class="flex flex-col gap-16 md:gap-24">

            @forelse($categories as $category)
                @if($category->services->isNotEmpty())
                    <section class="service-category-section" data-aos="fade-up">
                        {{-- Group Header --}}
                        <div class="flex items-center gap-4 mb-8">
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 uppercase tracking-wide">{{ $category->name }}</h2>
                            <div class="h-px bg-gray-200 flex-1"></div>
                            <a href="{{ url($category->slug . '.html') }}" class="text-sm font-semibold text-green-700 hover:text-green-900 transition-colors whitespace-nowrap">Xem tất cả <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i></a>
                        </div>

                        {{-- Services Grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                            @foreach($category->services as $service)
                            <article class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                                <a href="{{ url($service->slug . '.html') }}" class="block overflow-hidden shrink-0 relative h-56 md:h-64">
                                    @if($service->image)
                                        <img src="{{ asset($service->image) }}" alt="{{ $service->name }}"
                                             loading="lazy"
                                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-green-50 to-emerald-100 flex items-center justify-center">
                                            <i class="fa-solid fa-wand-magic-sparkles text-4xl text-green-300"></i>
                                        </div>
                                    @endif
                                    
                                    {{-- Lớp phủ tối khi hover --}}
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                         <span class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-green-700 transform scale-50 group-hover:scale-100 transition-transform duration-300">
                                             <i class="fa-solid fa-arrow-right"></i>
                                         </span>
                                    </div>
                                </a>
                                <div class="p-6 md:p-8 flex flex-col flex-1 relative bg-white z-10">
                                    <div class="absolute -top-6 right-6 w-12 h-12 bg-white rounded-xl shadow-md flex items-center justify-center text-xl text-green-600 border border-green-50 z-20">
                                        <i class="{{ $service->icon ?: 'fa-solid fa-star' }}"></i>
                                    </div>

                                    <h3 class="text-xl font-bold text-gray-900 leading-snug line-clamp-2 mb-3 pr-8 group-hover:text-green-700 transition-colors">
                                        <a href="{{ url($service->slug . '.html') }}">{{ $service->name }}</a>
                                    </h3>
                                    
                                    @if($service->summary)
                                        <p class="text-sm text-gray-500 line-clamp-3 mb-5 flex-1">{{ $service->summary }}</p>
                                    @endif
                                    
                                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                                        @if($service->price > 0)
                                            <span class="text-base font-bold text-green-700">{{ number_format($service->price) }}₫</span>
                                        @else
                                            <span class="text-xs font-semibold uppercase tracking-widest text-gray-400">Liên hệ báo giá</span>
                                        @endif
                                    </div>
                                </div>
                            </article>
                            @endforeach
                        </div>
                    </section>
                @endif
            @empty
                <div class="text-center py-24 text-gray-400 w-full">
                    <i class="fa-regular fa-folder-open text-5xl mb-4 block opacity-40"></i>
                    <p class="text-sm">Hệ thống đang cập nhật dịch vụ.</p>
                </div>
            @endforelse

        </div>
    </div>
</div>
@endsection
