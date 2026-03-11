{{-- Floating Contact Widget (Zalo, Hotline) --}}
@php
    $zalo = $web->zalo_number;
    // Extract numbers only for calling
    $hotlineClean = preg_replace('/[^0-9]/', '', $business->main_phone);
@endphp

<div x-data="{ showScrollTop: false }" 
     @scroll.window="showScrollTop = (window.pageYOffset > 400)"
     class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3" 
     style="pointer-events: none;">

    {{-- Nút Trở Về Đầu Trang (Back to Top) - Hiển thị thông minh --}}
    <button type="button" 
            x-show="showScrollTop"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 translate-y-8"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-8"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="flex items-center justify-center w-10 h-10 bg-gray-800 text-white rounded-full shadow-lg hover:bg-green-600 hover:-translate-y-1 transition-all duration-300 pointer-events-auto"
            aria-label="Về đầu trang">
        <i class="fa-solid fa-arrow-up text-sm"></i>
    </button>
    
    {{-- Zalo Button --}}
    @if($zalo)
    <a href="{{ $zalo }}" target="_blank" rel="noopener noreferrer" 
       class="relative flex items-center justify-center w-[52px] h-[52px] bg-white rounded-full shadow-lg shadow-blue-500/20 hover:scale-110 transition-transform duration-300 group" style="pointer-events: auto;">
        <div class="absolute inset-0 bg-blue-500 rounded-full animate-ping opacity-20"></div>
        <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Icon_of_Zalo.svg" alt="Zalo Chat" class="w-8 h-8 object-contain">
        
        {{-- Tooltip Hover --}}
        <div class="absolute right-full mr-4 top-1/2 -translate-y-1/2 bg-gray-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none shadow-xl">
            Chat qua Zalo
            <div class="absolute right-[-4px] top-1/2 -translate-y-1/2 w-2 h-2 bg-gray-900 transform rotate-45"></div>
        </div>
    </a>
    @endif

    {{-- Hotline Button --}}
    @if($business->main_phone)
    <a href="tel:{{ $hotlineClean }}" 
       class="relative flex items-center justify-center w-14 h-14 bg-gradient-to-tr from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white rounded-full shadow-lg shadow-red-600/30 hover:scale-110 transition-transform duration-300 group" style="pointer-events: auto;">
        
        {{-- Vòng Ring rung --}}
        <div class="absolute w-full h-full rounded-full border-2 border-red-500 animate-[ping_1.5s_ease-in-out_infinite] opacity-70"></div>
        
        {{-- Icon rung --}}
        <i class="fa-solid fa-phone-volume text-xl animate-[wiggle_1s_ease-in-out_infinite]"></i>
        
        {{-- Tooltip Hover --}}
        <div class="absolute right-full mr-4 top-1/2 -translate-y-1/2 bg-red-600 text-white text-sm font-bold px-4 py-2 rounded-xl whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none shadow-xl flex flex-col items-end">
            Gọi ngay cho chúng tôi
            <span class="text-lg font-black tracking-wider text-red-50">{{ $business->main_phone }}</span>
            <div class="absolute right-[-4px] top-1/2 -translate-y-1/2 w-2 h-2 bg-red-600 transform rotate-45"></div>
        </div>
    </a>
    @endif
</div>
