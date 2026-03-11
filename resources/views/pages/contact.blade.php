@extends('layouts.master')

@section('title', 'Liên hệ - ' . config('app.name'))
@section('description', 'Liên hệ với THT Media để được tư vấn các giải pháp truyền thông, quay dựng phim doanh nghiệp, chụp ảnh sự kiện và booking chuyên nghiệp.')

@section('content')

{{-- ── Banner Liên Hệ ─────────────────────────────────────────────────── --}}
<section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden bg-gray-900" aria-label="Banner Liên Hệ">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/og-default.jpg') }}" alt="Liên hệ THT Media" class="w-full h-full object-cover opacity-20 object-center">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/80 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/40 to-transparent mix-blend-multiply"></div>
    </div>
    
    <div class="container mx-auto px-4 max-w-5xl relative z-10 text-center" data-aos="fade-up">
        <span class="inline-block px-4 py-1.5 mb-6 text-xs sm:text-sm font-black tracking-widest text-blue-400 border border-blue-500/30 bg-blue-900/30 rounded-full uppercase backdrop-blur-sm">Cùng kiến tạo thành công</span>
        <h1 class="text-4xl md:text-5xl lg:text-7xl font-extrabold text-white mb-6 leading-tight tracking-tight shadow-sm">Liên hệ THT</h1>
        <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed shadow-sm font-light">
            Bạn đã sẵn sàng để nâng tầm thương hiệu? Hãy để lại thông tin, đội ngũ chuyên gia của chúng tôi sẽ liên hệ tư vấn giải pháp hiệu quả nhất cho riêng bạn.
        </p>
    </div>
</section>

{{-- ── Nội dung form + Thông tin liên hệ ─────────────────────────────────── --}}
<section class="py-16 md:py-24 bg-gray-50 relative">
    <div class="absolute top-0 left-0 w-full h-64 bg-gray-900"></div>
    
    <div class="container mx-auto px-4 max-w-7xl relative z-10">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden flex flex-col lg:flex-row">
            
            {{-- Form Đăng ký (Bên trái) --}}
            <div class="w-full lg:w-7/12 p-8 md:p-12 lg:p-16">
                <div class="mb-10">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Gửi tin nhắn cho chúng tôi</h2>
                    <p class="text-gray-500">Chúng tôi cam kết bảo mật thông tin của bạn và sẽ phản hồi trong vòng 24 giờ làm việc.</p>
                </div>

                @if(session('success'))
                    <div class="mb-8 p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 flex items-start gap-3">
                        <i class="fa-solid fa-circle-check mt-1"></i>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-xs font-bold text-gray-700 mb-1">Họ và tên <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all placeholder-gray-400" placeholder="Nguyễn Văn A" value="{{ old('name') }}">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-xs font-bold text-gray-700 mb-1">Số điện thoại <span class="text-red-500">*</span></label>
                            <input type="tel" id="phone" name="phone" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all placeholder-gray-400" placeholder="0987 654 321" value="{{ old('phone') }}">
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-xs font-bold text-gray-700 mb-1">Email <span class="text-gray-400 font-normal">(Không bắt buộc)</span></label>
                            <input type="email" id="email" name="email" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all placeholder-gray-400" placeholder="email@example.com" value="{{ old('email') }}">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-xs font-bold text-gray-700 mb-1">Dịch vụ quan tâm</label>
                            <select id="subject" name="subject" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all text-gray-700 appearance-none">
                                <option value="Quay Phim / Chụp Ảnh">Quay phim doanh nghiệp / Chụp ảnh</option>
                                <option value="Sản xuất TVC">Sản xuất Phim quảng cáo (TVC)</option>
                                <option value="Booking PR">Booking Truyền thông báo chí</option>
                                <option value="Tổ chức sự kiện">Dịch vụ Tổ chức sự kiện</option>
                                <option value="Dịch vụ khác">Khác</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block text-xs font-bold text-gray-700 mb-1">Nội dung yêu cầu</label>
                        <textarea id="message" name="message" rows="4" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all placeholder-gray-400 resize-none" placeholder="Vui lòng để lại thêm thông tin hoặc yêu cầu chi tiết để nhóm tư vấn có thể hỗ trợ bạn tốt nhất (Ngân sách, thời gian triển khai...).">{{ old('message') }}</textarea>
                    </div>
                    
                    <button type="submit" class="w-full py-4 px-6 rounded-xl bg-gradient-to-r from-green-700 to-green-600 hover:from-green-800 hover:to-green-700 text-white font-bold text-base shadow-lg shadow-green-600/30 transform transition-all hover:-translate-y-0.5">
                        GỬI YÊU CẦU TƯ VẤN <i class="fa-solid fa-paper-plane ml-2"></i>
                    </button>
                </form>
            </div>

            {{-- Thông tin liên hệ tĩnh (Bên phải) --}}
            <div class="w-full lg:w-5/12 bg-gray-900 text-gray-300 p-8 md:p-12 lg:p-16 relative overflow-hidden flex flex-col justify-between">
                {{-- Decorative BG --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-green-500/10 rounded-full blur-[80px] pointer-events-none"></div>
                
                <div class="relative z-10">
                    <h3 class="text-2xl font-bold text-white mb-8">Thông tin liên hệ</h3>
                    
                    <div class="space-y-8">
                        @if($business->main_address)
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-gray-800 text-green-500 flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1">Trụ sở chính</h4>
                                <p class="text-gray-400 text-sm leading-relaxed">{{ $business->main_address }}</p>
                            </div>
                        </div>
                        @endif

                        @if($business->main_phone)
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-gray-800 text-blue-500 flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1">Đường dây nóng</h4>
                                <p><a href="tel:{{ str_replace(' ', '', $business->main_phone) }}" class="text-gray-400 hover:text-white transition-colors text-sm font-medium">{{ $business->main_phone }}</a></p>
                            </div>
                        </div>
                        @endif

                        @if($business->main_email)
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-gray-800 text-amber-500 flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1">Email hỗ trợ</h4>
                                <p><a href="mailto:{{ $business->main_email }}" class="text-gray-400 hover:text-white transition-colors text-sm font-medium">{{ $business->main_email }}</a></p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="relative z-10 mt-12 pt-8 border-t border-gray-800">
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Kết nối với chúng tôi</h4>
                    <div class="flex gap-3">
                        @if($web->facebook_url)
                        <a href="{{ $web->facebook_url }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-[#1877F2] hover:text-white transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                        @endif
                        @if($web->youtube_url)
                        <a href="{{ $web->youtube_url }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-[#FF0000] hover:text-white transition-colors"><i class="fa-brands fa-youtube"></i></a>
                        @endif
                        @if($web->zalo_number)
                        <a href="https://zalo.me/{{ preg_replace('/[^0-9]/', '', $web->zalo_number) }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-[#0068FF] hover:text-white transition-colors"><i class="fa-solid fa-comment-dots"></i></a>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ── Bản đồ Google Maps ─────────────────────────────────── --}}
@if($web->google_map_embed)
<section class="w-full h-[400px] bg-gray-200">
    {!! $web->google_map_embed !!}
</section>
@endif

@endsection
