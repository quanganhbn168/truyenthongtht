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
                <p class="text-gray-500 mt-2 text-base md:text-lg max-w-3xl">{{ $category->description }}</p>
            @endif
        </div>

        <div class="flex flex-col lg:flex-row gap-10 items-start">

            <div class="flex-1 min-w-0">
                @if($services->isEmpty())
                    <div class="text-center py-24 text-gray-400 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <i class="fa-regular fa-folder-open text-5xl mb-4 block opacity-40"></i>
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
                            <div class="p-6 flex flex-col flex-1 relative bg-white z-10">
                                <div class="absolute -top-5 right-5 w-10 h-10 bg-white rounded-xl shadow-md flex items-center justify-center text-lg text-green-600 border border-green-50 z-20">
                                    <i class="{{ $service->icon ?: 'fa-solid fa-star' }}"></i>
                                </div>

                                <h2 class="text-lg font-bold text-gray-900 leading-snug line-clamp-2 mb-2 pr-6 group-hover:text-green-700 transition-colors">
                                    <a href="{{ url($service->slug . '.html') }}">{{ $service->name }}</a>
                                </h2>
                                
                                @if($service->summary)
                                    <p class="text-sm text-gray-500 line-clamp-3 mb-4 flex-1">{{ $service->summary }}</p>
                                @endif
                                
                                <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-100">
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

                    @if($services->hasPages())
                        <div class="flex justify-center mt-10">{{ $services->links() }}</div>
                    @endif
                @endif
            </div>

            {{-- Sidebar --}}
            <aside class="hidden lg:block w-64 xl:w-72 shrink-0 sticky top-24 self-start">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-sm font-bold text-gray-900 pb-3 border-b-2 border-green-600 mb-4">Danh mục dịch vụ</h2>
                    <ul class="space-y-1 mt-2">
                        <li>
                            <a href="{{ route('services.index') }}"
                               class="flex items-center px-3 py-2.5 rounded-xl text-sm gap-3 text-gray-600 hover:bg-green-50 hover:text-green-700 transition-colors">
                                <i class="fa-solid fa-border-all text-xs opacity-50 w-4 text-center"></i>
                                <span class="font-medium">Tất cả dịch vụ</span>
                            </a>
                        </li>
                        @foreach($allCategories as $cat)
                        <li>
                            <a href="{{ url($cat->slug . '.html') }}"
                               class="flex items-center px-3 py-2.5 rounded-xl text-sm gap-3 transition-colors
                                      {{ $cat->id === $category->id ? 'bg-green-50 text-green-700 shadow-sm relative overflow-hidden' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                                @if($cat->id === $category->id)
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-green-600"></div>
                                @endif
                                <i class="fa-regular fa-folder text-xs opacity-40 w-4 text-center"></i>
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
