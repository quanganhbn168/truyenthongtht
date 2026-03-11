<footer id="site-footer" class="bg-gray-900 text-gray-300 pt-16 pb-8 border-t-4 border-green-600 relative overflow-hidden" role="contentinfo">
    {{-- Background elements --}}
    <div class="absolute top-0 right-0 w-64 h-64 bg-green-500/5 rounded-full blur-[80px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-lime-500/5 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="container mx-auto px-4 max-w-7xl relative z-10">
        {{-- Main 4-Column Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8 xl:gap-12 mb-12">
            
            {{-- Cột 1: Thông tin thương hiệu --}}
            <div class="col-span-1 sm:col-span-2 lg:col-span-1">
                <a href="{{ url('/') }}" title="{{ config('app.name') }}" class="inline-block mb-6">
                    @if(file_exists(public_path('images/logo-white.png')))
                        <img src="{{ asset('images/logo-white.png') }}" alt="{{ config('app.name') }}" class="h-12 w-auto object-contain" loading="lazy">
                    @else
                        <span class="text-2xl font-black text-white tracking-tight">{{ config('app.name') }}</span>
                    @endif
                </a>
                <p class="text-sm text-gray-400 mb-6 leading-relaxed">
                    {{ config('site.description', 'THT Media - Cung cấp giải pháp truyền thông toàn diện, sáng tạo và chuyên nghiệp cho doanh nghiệp.') }}
                </p>
                <div class="space-y-3 text-sm">
                    @if(config('site.address'))
                    <p class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot mt-1 text-green-500 w-4 text-center"></i> 
                        <span class="flex-1">{{ config('site.address') }}</span>
                    </p>
                    @endif
                    @if(config('site.phone'))
                    <p class="flex items-center gap-3">
                        <i class="fa-solid fa-phone text-green-500 w-4 text-center"></i> 
                        <a href="tel:{{ config('site.phone') }}" class="hover:text-white transition-colors">{{ config('site.phone') }}</a>
                    </p>
                    @endif
                    @if(config('site.email'))
                    <p class="flex items-center gap-3">
                        <i class="fa-solid fa-envelope text-green-500 w-4 text-center"></i> 
                        <a href="mailto:{{ config('site.email') }}" class="hover:text-white transition-colors">{{ config('site.email') }}</a>
                    </p>
                    @endif
                </div>
            </div>

            {{-- Phân phối menu tự động vào Cột 2 & Cột 3 --}}
            @if($footerMenu && $footerMenu->menuItems->isNotEmpty())
                @foreach($footerMenu->menuItems->take(2) as $col)
                <div class="col-span-1">
                    <h3 class="text-white font-bold text-base uppercase tracking-wider mb-5">{{ $col->title }}</h3>
                    @if($col->children->isNotEmpty())
                    <ul class="space-y-3">
                        @foreach($col->children as $child)
                        <li>
                            <a href="{{ $child->url ?: '#' }}" class="text-gray-400 hover:text-white hover:translate-x-1 inline-block transition-all text-sm" @if($child->target === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                {{ $child->title }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                @endforeach
            @else
                {{-- Fallback nếu không có Menu trong DB --}}
                <div class="col-span-1">
                    <h3 class="text-white font-bold text-base uppercase tracking-wider mb-5">Về chúng tôi</h3>
                    <ul class="space-y-3">
                        <li><a href="/gioi-thieu" class="text-gray-400 hover:text-white hover:translate-x-1 inline-block transition-all text-sm">Giới thiệu về THT</a></li>
                        <li><a href="/du-an" class="text-gray-400 hover:text-white hover:translate-x-1 inline-block transition-all text-sm">Dự án tiêu biểu</a></li>
                        <li><a href="/tin-tuc" class="text-gray-400 hover:text-white hover:translate-x-1 inline-block transition-all text-sm">Tin tức sự kiện</a></li>
                        <li><a href="/lien-he" class="text-gray-400 hover:text-white hover:translate-x-1 inline-block transition-all text-sm">Liên hệ hợp tác</a></li>
                    </ul>
                </div>
                <div class="col-span-1">
                    <h3 class="text-white font-bold text-base uppercase tracking-wider mb-5">Dịch vụ chính</h3>
                    <ul class="space-y-3">
                        <li><a href="/dich-vu" class="text-gray-400 hover:text-white hover:translate-x-1 inline-block transition-all text-sm">Sản xuất TVC Video</a></li>
                        <li><a href="/dich-vu" class="text-gray-400 hover:text-white hover:translate-x-1 inline-block transition-all text-sm">Chụp ảnh doanh nghiệp</a></li>
                        <li><a href="/dich-vu" class="text-gray-400 hover:text-white hover:translate-x-1 inline-block transition-all text-sm">Booking Media & PR</a></li>
                        <li><a href="/dich-vu" class="text-gray-400 hover:text-white hover:translate-x-1 inline-block transition-all text-sm">Cung cấp nhân sự sự kiện</a></li>
                    </ul>
                </div>
            @endif

            {{-- Cột 4: Kết nối mạng xã hội & Chứng nhận --}}
            <div class="col-span-1 sm:col-span-2 lg:col-span-1">
                <h3 class="text-white font-bold text-base uppercase tracking-wider mb-5">Kết nối với THT</h3>
                <div class="flex flex-wrap gap-3 mb-8">
                    @if(config('site.facebook'))
                    <a href="{{ config('site.facebook') }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-[#1877F2] hover:text-white transition-colors" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f text-lg" aria-hidden="true"></i>
                    </a>
                    @endif
                    @if(config('site.youtube'))
                    <a href="{{ config('site.youtube') }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-[#FF0000] hover:text-white transition-colors" aria-label="YouTube">
                        <i class="fa-brands fa-youtube text-lg" aria-hidden="true"></i>
                    </a>
                    @endif
                    @if(config('site.zalo'))
                    <a href="{{ config('site.zalo') }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-[#0068FF] hover:text-white transition-colors" aria-label="Zalo">
                        <i class="fa-solid fa-comment-dots text-lg" aria-hidden="true"></i>
                    </a>
                    @endif
                </div>
                
                {{-- Giả lập tem BCT --}}
                <h3 class="text-white font-bold text-base uppercase tracking-wider mb-4">Chứng nhận</h3>
                <img src="https://images.dmca.com/Badges/dmca_protected_sml_120m.png?ID=2848520d-886f-427f-94a2-14eb02fc92cc" alt="DMCA" class="h-6 object-contain opacity-70 hover:opacity-100 transition-opacity">
            </div>
        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="border-t border-gray-800/80">
        <div class="container mx-auto px-4 max-w-7xl py-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                <p>© {{ date('Y') }} <span class="text-gray-300 font-semibold">{{ config('app.name') }}</span>. Bảo lưu mọi quyền.</p>
                <div class="flex items-center gap-4">
                    <a href="/chinh-sach-bao-mat.html" class="hover:text-white transition-colors">Chính sách bảo mật</a>
                    <span class="w-1 h-1 rounded-full bg-gray-700"></span>
                    <a href="/dieu-khoan-su-dung.html" class="hover:text-white transition-colors">Điều khoản sử dụng</a>
                </div>
            </div>
        </div>
    </div>
</footer>
