@extends('layouts.master')

@section('title', 'Nhận Báo Giá - ' . config('app.name'))
@section('description', 'Yêu cầu báo giá và tư vấn giải pháp truyền thông, quay dựng phim doanh nghiệp, chụp ảnh sự kiện chuyên nghiệp từ THT Media.')

@section('content')

{{-- ── Banner Báo Giá ─────────────────────────────────────────────────── --}}
<section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden bg-gray-900" aria-label="Banner Báo Giá">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/og-default.jpg') }}" alt="Báo giá THT Media" class="w-full h-full object-cover opacity-20 object-center grayscale mix-blend-overlay">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/90 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-green-900/30 to-transparent mix-blend-multiply"></div>
    </div>
    
    <div class="container mx-auto px-4 max-w-5xl relative z-10 text-center" data-aos="fade-up">
        <span class="inline-block px-4 py-1.5 mb-6 text-xs sm:text-sm font-black tracking-widest text-green-400 border border-green-500/30 bg-green-900/30 rounded-full uppercase backdrop-blur-sm">Khởi đầu dự án của bạn</span>
        <h1 class="text-4xl md:text-5xl lg:text-7xl font-extrabold text-white mb-6 leading-tight tracking-tight shadow-sm">Yêu Cầu Báo Giá</h1>
        <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed shadow-sm font-light">
            Vui lòng cung cấp một số thông tin cơ bản để chúng tôi có thể chuẩn bị giải pháp và bảng báo giá phù hợp nhất với nhu cầu của doanh nghiệp bạn.
        </p>
    </div>
</section>

{{-- ── Nội dung form + Trust Signals ─────────────────────────────────── --}}
<section class="py-16 md:py-24 bg-gray-50 relative">
    <div class="absolute top-0 left-0 w-full h-64 bg-gray-900"></div>
    
    <div class="container mx-auto px-4 max-w-7xl relative z-10">
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden flex flex-col lg:flex-row">
            
            {{-- Form Yêu Cầu (Bên trái) --}}
            <div class="w-full lg:w-7/12 p-8 md:p-12 lg:p-16">
                <div class="mb-10 lg:mb-12">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Thông tin dự án</h2>
                    <p class="text-gray-500 text-sm md:text-base">Mọi thông tin bạn cung cấp sẽ được THT Media bảo mật tuyệt đối. Chúng tôi sẽ gửi tài liệu trong vòng 24 giờ.</p>
                </div>

                @if(session('success'))
                    <div class="mb-8 p-5 rounded-2xl bg-green-50 text-green-700 border border-green-200 flex items-start gap-3 shadow-sm">
                        <i class="fa-solid fa-circle-check mt-1 text-xl"></i>
                        <div>
                            <p class="font-bold mb-1">Thành công!</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('quote.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Họ và tên <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all placeholder-gray-400" placeholder="Nguyễn Văn A" value="{{ old('name') }}">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Số điện thoại <span class="text-red-500">*</span></label>
                            <input type="tel" id="phone" name="phone" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all placeholder-gray-400" placeholder="0987 654 321" value="{{ old('phone') }}">
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Email <span class="text-gray-400 font-normal normal-case">(Tùy chọn)</span></label>
                            <input type="email" id="email" name="email" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all placeholder-gray-400" placeholder="email@congty.com" value="{{ old('email') }}">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="company_name" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Tên công ty / Tổ chức</label>
                            <input type="text" id="company_name" name="company_name" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all placeholder-gray-400" placeholder="Công ty CP..." value="{{ old('company_name') }}">
                            @error('company_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="service_id" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Dịch vụ quan tâm</label>
                            <select id="service_id" name="service_id" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all text-gray-700 appearance-none">
                                <option value="">-- Lựa chọn dịch vụ --</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ (old('service_id') == $service->id || $selectedServiceId == $service->id) ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="budget_range" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Ngân sách dự kiến</label>
                            <select id="budget_range" name="budget_range" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all text-gray-700 appearance-none">
                                <option value="">-- Chọn ngân sách --</option>
                                <option value="Dưới 10 triệu">Dưới 10 triệu</option>
                                <option value="10 - 50 triệu">10 - 50 triệu</option>
                                <option value="50 - 100 triệu">50 - 100 triệu</option>
                                <option value="Trên 100 triệu">Trên 100 triệu</option>
                                <option value="Chưa xác định">Chưa xác định</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="note" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Yêu cầu chi tiết</label>
                        <textarea id="note" name="note" rows="4" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all placeholder-gray-400 resize-none" placeholder="Mô tả qua về dự án của bạn (thời gian cần hoàn thành, yêu cầu cụ thể, v.v.)">{{ old('note') }}</textarea>
                    </div>
                    
                    <button type="submit" class="w-full py-4.5 px-6 rounded-xl bg-gradient-to-r from-green-700 to-green-600 hover:from-green-800 hover:to-green-700 text-white font-bold text-base shadow-xl shadow-green-600/30 transform transition-all hover:-translate-y-1">
                        NHẬN BÁO GIÁ NGAY <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                    </button>
                    <p class="text-center text-xs text-gray-400 mt-4"><i class="fa-solid fa-lock text-[10px] mr-1"></i> Thông tin của bạn được bảo mật tuyệt đối bằng mã hóa SSL.</p>
                </form>
            </div>

            {{-- Trust Signals (Bên phải) --}}
            <div class="w-full lg:w-5/12 bg-green-900 text-gray-300 p-8 md:p-12 lg:p-16 relative overflow-hidden flex flex-col justify-between">
                {{-- Decorative BG --}}
                <div class="absolute inset-0 z-0">
                    <div class="absolute -top-32 -right-32 w-96 h-96 bg-green-500/20 rounded-full blur-[100px] pointer-events-none"></div>
                    <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-yellow-500/10 rounded-full blur-[100px] pointer-events-none"></div>
                </div>
                
                <div class="relative z-10 flex flex-col h-full">
                    <div class="mb-12">
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">Tại sao chọn THT?</h3>
                        <p class="text-green-100 text-sm md:text-base mb-8 opacity-90">Hàng trăm thương hiệu đã tin tưởng lựa chọn chúng tôi làm đối tác truyền thông chiến lược.</p>
                        
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-green-800 text-green-400 flex items-center justify-center text-sm shrink-0 shadow-lg border border-green-700">
                                    <i class="fa-solid fa-bolt"></i>
                                </div>
                                <div>
                                    <h4 class="text-white font-bold mb-1">Phản hồi siêu tốc</h4>
                                    <p class="text-green-100/70 text-sm leading-relaxed">Chúng tôi phân tích ngành hàng và báo giá sơ bộ trong vòng 24H sau khi nhận yêu cầu.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-green-800 text-green-400 flex items-center justify-center text-sm shrink-0 shadow-lg border border-green-700">
                                    <i class="fa-solid fa-file-invoice-dollar"></i>
                                </div>
                                <div>
                                    <h4 class="text-white font-bold mb-1">Minh bạch chi phí</h4>
                                    <p class="text-green-100/70 text-sm leading-relaxed">Cam kết báo giá chính xác, hợp đồng rõ ràng, không phát sinh phụ phí ẩn.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-green-800 text-green-400 flex items-center justify-center text-sm shrink-0 shadow-lg border border-green-700">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <div>
                                    <h4 class="text-white font-bold mb-1">Đảm bảo KPI MKT</h4>
                                    <p class="text-green-100/70 text-sm leading-relaxed">Thực thi bài bản, quy chuẩn chất lượng đầu ra theo sát định hướng Performance.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto pt-8 border-t border-green-800/50">
                        <div class="flex flex-col items-start gap-2">
                            <span class="text-xs font-bold text-green-300 uppercase tracking-widest pl-1 border-l-2 border-green-500 mb-1">Hotline hỗ trợ 24/7</span>
                            <a href="tel:{{ config('site.phone', '') }}" class="text-3xl font-black text-white hover:text-green-300 transition-colors tracking-tight">
                                {{ $business->main_phone ?? config('site.phone', '') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
