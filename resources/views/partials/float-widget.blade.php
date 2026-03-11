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

    {{-- Nút Trở Về Đầu Trang (Back to Top) - Premium Glassmorphism --}}
    <button type="button" 
            x-show="showScrollTop"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 translate-y-12"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-12"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="flex items-center justify-center w-12 h-12 bg-white/80 backdrop-blur-md text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl hover:bg-green-600 hover:text-white hover:border-green-600 transition-all duration-300 pointer-events-auto"
            aria-label="Về đầu trang">
        <i class="fa-solid fa-arrow-up text-lg"></i>
    </button>
    
    {{-- Zalo Button --}}
    @if($zalo)
    <a href="{{ $zalo }}" target="_blank" rel="noopener noreferrer" 
       class="relative flex items-center justify-center w-14 h-14 bg-white rounded-full shadow-lg shadow-blue-500/20 hover:scale-110 transition-transform duration-300 group mt-2" style="pointer-events: auto;">
        <div class="absolute inset-0 bg-blue-500 rounded-full animate-ping opacity-20"></div>
        <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Icon_of_Zalo.svg" alt="Zalo Chat" class="w-9 h-9 object-contain">
        
        {{-- Tooltip Hover --}}
        <div class="absolute right-[calc(100%+12px)] top-1/2 -translate-y-1/2 bg-gray-900 text-white text-sm font-semibold px-4 py-2 rounded-xl whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none shadow-xl scale-95 group-hover:scale-100 origin-right">
            Chat qua Zalo
            <div class="absolute right-[-5px] top-1/2 -translate-y-1/2 w-3 h-3 bg-gray-900 transform rotate-45 rounded-sm"></div>
        </div>
    </a>
    @endif

    {{-- Hotline Button (Premium Green Ring) --}}
    @if($business->main_phone)
    <div class="relative mt-2" style="pointer-events: auto;">
        {{-- Ripple Effects --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-14 h-14 bg-green-500 rounded-full animate-[ping_2s_cubic-bezier(0,0,0.2,1)_infinite] opacity-40"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-14 h-14 bg-green-400 rounded-full animate-[ping_2s_cubic-bezier(0,0,0.2,1)_infinite_0.5s] opacity-30"></div>
        
        <a href="tel:{{ $hotlineClean }}" 
           class="relative flex items-center justify-center w-16 h-16 bg-gradient-to-tr from-green-700 via-green-600 to-lime-500 hover:from-green-800 hover:to-green-600 text-white rounded-full shadow-xl shadow-green-600/40 hover:scale-110 transition-all duration-300 group z-10">
            
            {{-- Icon Rung --}}
            <i class="fa-solid fa-phone-volume text-2xl animate-[wiggle_1.5s_ease-in-out_infinite]"></i>
            
            {{-- Tooltip Hover --}}
            <div class="absolute right-[calc(100%+16px)] top-1/2 -translate-y-1/2 bg-white border border-green-100 text-gray-800 text-sm font-bold px-5 py-3 rounded-2xl whitespace-nowrap opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none shadow-2xl flex flex-col items-end scale-95 group-hover:scale-100 origin-right">
                <span class="text-xs text-gray-500 uppercase tracking-widest mb-1 font-semibold">Hotline tư vấn</span>
                <span class="text-xl font-black tracking-wider text-green-700 drop-shadow-sm">{{ $business->main_phone }}</span>
                <div class="absolute right-[-6px] top-1/2 -translate-y-1/2 w-3 h-3 bg-white border-t border-r border-green-100 transform rotate-45 rounded-sm"></div>
            </div>
        </a>
    </div>
    @endif
</div>
