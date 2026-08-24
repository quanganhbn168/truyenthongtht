@extends('layouts.master')

@section('content')
<div class="py-8 pb-20">
    <div class="container mx-auto px-4 max-w-7xl">

        <x-breadcrumb :items="[
            ['label' => 'Dịch vụ', 'url' => route('services.index')],
            ['label' => $category->name],
        ]" />

        <div class="my-6">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">{{ $category->name }}</h1>
            @if($category->description)
                <p class="w-full text-gray-500 mt-2 text-base md:text-lg leading-relaxed">{{ $category->description }}</p>
            @endif
        </div>

        <div class="flex flex-col lg:flex-row gap-10 items-start">

            <div class="flex-1 min-w-0">
                @if($services->isEmpty())
                    <div class="text-center py-24 text-gray-400 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-sm">Chưa có dịch vụ nào trong danh mục này.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
                        @foreach($services as $service)
                        <article class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                            <a href="{{ url($service->slug . '.html') }}" class="block overflow-hidden shrink-0 relative h-56">
                                @if($service->image)
                                    <img src="{{ asset($service->image) }}" alt="{{ $service->name }}"
                                         loading="lazy"
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-[var(--color-brand-50)]"></div>
                                @endif
                                
                                {{-- Lớp phủ tối khi hover --}}
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                     <span class="bg-white rounded-full px-5 py-2 text-sm font-semibold text-orange-700 transform scale-90 group-hover:scale-100 transition-transform duration-300">Xem chi tiết</span>
                                </div>
                            </a>
                            <div class="p-6 flex flex-col flex-1 relative bg-white z-10">
                                <h2 class="text-lg font-bold text-gray-900 leading-snug line-clamp-2 mb-2 group-hover:text-orange-700 transition-colors">
                                    <a href="{{ url($service->slug . '.html') }}">{{ $service->name }}</a>
                                </h2>
                                
                                @if($service->summary)
                                    <p class="text-sm text-gray-500 line-clamp-3 mb-4 flex-1">{{ $service->summary }}</p>
                                @endif
                                
                                <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-100">
                                    @if($service->price > 0)
                                        <span class="text-base font-bold text-orange-700">{{ number_format($service->price) }}₫</span>
                                    @else
                                        <span class="text-xs font-semibold uppercase tracking-widest text-gray-400">Liên hệ báo giá</span>
                                    @endif
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>

                    @if($services->hasPages())
                        <div class="flex justify-center mt-10">{{ $services->links() }}</div>
                    @endif
                @endif

                @if($category->content)
                    <section class="mt-12 pt-10 border-t border-gray-100">
                        <div class="prose prose-lg max-w-none text-gray-700" itemprop="description">
                            {!! $category->content !!}
                        </div>
                    </section>
                @endif
            </div>

            {{-- Sidebar --}}
            <aside class="hidden lg:block w-64 xl:w-72 shrink-0 sticky top-24 self-start">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-sm font-bold text-gray-900 pb-3 border-b-2 border-orange-600 mb-4">Danh mục dịch vụ</h2>
                    <ul class="space-y-1 mt-2">
                        <li>
                            <a href="{{ route('services.index') }}"
                               class="flex items-center px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-700 transition-colors">
                                <span class="font-medium">Tất cả dịch vụ</span>
                            </a>
                        </li>
                        @foreach($allCategories as $cat)
                        <li>
                            <a href="{{ url($cat->slug . '.html') }}"
                               class="flex items-center px-3 py-2.5 rounded-xl text-sm transition-colors
                                      {{ $cat->id === $category->id ? 'bg-orange-50 text-orange-700 shadow-sm relative overflow-hidden' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-700' }}">
                                @if($cat->id === $category->id)
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-orange-600"></div>
                                @endif
                                <span class="{{ $cat->id === $category->id ? 'font-bold' : 'font-medium' }}">{{ $cat->name }}</span>
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
