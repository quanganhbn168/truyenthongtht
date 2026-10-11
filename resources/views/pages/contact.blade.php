@extends('layouts.master')

@php
    $contactPhones = collect($business->phones ?? [])
        ->filter(fn ($phone) => is_array($phone) && filled($phone['number'] ?? null))
        ->values();

    if ($contactPhones->isEmpty()) {
        $contactPhones = collect([
            ['number' => $business->main_phone],
            ['number' => $business->main_phone_2],
        ])->filter(fn ($phone) => filled($phone['number'] ?? null))->values();
    }

    if ($contactPhones->isEmpty()) {
        $contactPhones = collect($branches ?? [])
            ->filter(fn ($branch) => filled($branch->phone ?? null))
            ->map(fn ($branch) => ['number' => $branch->phone])
            ->values();
    }

    $contactBranches = collect($branches ?? []);
@endphp

@section('title', 'Liên hệ - ' . config('app.name'))
@section('description', 'Liên hệ với THT Media để được tư vấn các giải pháp truyền thông, quay dựng phim doanh nghiệp, chụp ảnh sự kiện và booking chuyên nghiệp.')

@section('content')

{{-- ── Banner Liên Hệ ─────────────────────────────────────────────────── --}}
<section class="page-hero relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden" aria-label="Banner Liên Hệ">
    <div class="absolute inset-0 z-0">
        <img src="{{ $commonBannerUrl }}" alt="Liên hệ THT Media" class="w-full h-full object-cover object-center">
    </div>
    
    <div class="container mx-auto px-4 max-w-5xl relative z-10 text-center" data-aos="fade-up">
        <h1 class="page-hero__title text-3xl md:text-4xl lg:text-5xl font-extrabold mb-6 leading-tight tracking-tight">Liên hệ THT</h1>
    </div>
</section>

<div class="page-breadcrumb-strip border-b">
    <div class="container mx-auto max-w-7xl px-4">
        <x-breadcrumb :items="[['label' => 'Liên hệ']]" />
    </div>
</div>

{{-- ── Nội dung form + Thông tin liên hệ ─────────────────────────────────── --}}
<section class="page-form-section py-16 md:py-24 relative">
    <div class="page-form-section__cap absolute top-0 left-0 w-full h-64"></div>
    
    <div class="container mx-auto px-4 max-w-7xl relative z-10">
        <div class="page-form-card rounded-3xl border overflow-hidden flex flex-col lg:flex-row">
            
            {{-- Form Đăng ký (Bên trái) --}}
            <div class="w-full lg:w-7/12 p-8 md:p-12 lg:p-16">
                <div class="mb-10">
                    <h2 class="page-form-heading text-3xl font-extrabold mb-4">Gửi tin nhắn cho chúng tôi</h2>
                    <p class="page-form-intro">Chúng tôi cam kết bảo mật thông tin của bạn và sẽ phản hồi trong vòng 24 giờ làm việc.</p>
                </div>

                @if(session('success'))
                    <div class="alert-success mb-8 p-4 rounded-xl border flex items-start gap-3">
                        <i class="fa-solid fa-circle-check mt-1"></i>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="form-label block text-xs font-bold mb-1">Họ và tên <span class="form-required">*</span></label>
                            <input type="text" id="name" name="name" required class="form-control w-full border rounded-xl px-4 py-3.5 text-sm transition-all" placeholder="Nguyễn Văn A" value="{{ old('name') }}">
                            @error('name') <p class="form-error text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="phone" class="form-label block text-xs font-bold mb-1">Số điện thoại <span class="form-required">*</span></label>
                            <input type="tel" id="phone" name="phone" required class="form-control w-full border rounded-xl px-4 py-3.5 text-sm transition-all" placeholder="0987 654 321" value="{{ old('phone') }}">
                            @error('phone') <p class="form-error text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="form-label block text-xs font-bold mb-1">Email <span class="form-note font-normal">(Không bắt buộc)</span></label>
                            <input type="email" id="email" name="email" class="form-control w-full border rounded-xl px-4 py-3.5 text-sm transition-all" placeholder="email@example.com" value="{{ old('email') }}">
                            @error('email') <p class="form-error text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="subject" class="form-label block text-xs font-bold mb-1">Dịch vụ quan tâm</label>
                            <select id="subject" name="subject" class="form-control w-full border rounded-xl px-4 py-3.5 text-sm transition-all appearance-none">
                                <option value="Quay Phim / Chụp Ảnh">Quay phim doanh nghiệp / Chụp ảnh</option>
                                <option value="Sản xuất TVC">Sản xuất Phim quảng cáo (TVC)</option>
                                <option value="Booking PR">Booking Truyền thông báo chí</option>
                                <option value="Tổ chức sự kiện">Dịch vụ Tổ chức sự kiện</option>
                                <option value="Dịch vụ khác">Khác</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="message" class="form-label block text-xs font-bold mb-1">Nội dung yêu cầu</label>
                        <textarea id="message" name="message" rows="4" class="form-control w-full border rounded-xl px-4 py-3.5 text-sm transition-all resize-none" placeholder="Vui lòng để lại thêm thông tin hoặc yêu cầu chi tiết để nhóm tư vấn có thể hỗ trợ bạn tốt nhất (Ngân sách, thời gian triển khai...).">{{ old('message') }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn-brand w-full justify-center py-4 px-6 rounded-xl text-base hover:-translate-y-0.5">
                        GỬI YÊU CẦU TƯ VẤN <i class="fa-solid fa-paper-plane ml-2"></i>
                    </button>
                </form>
            </div>

            {{-- Thông tin liên hệ tĩnh (Bên phải) --}}
            <div class="panel-brand w-full lg:w-5/12 p-8 md:p-12 lg:p-16 relative overflow-hidden flex flex-col justify-between">
                {{-- Decorative BG --}}
                <div class="panel-brand__decor--primary absolute top-0 right-0 w-64 h-64 rounded-full blur-[80px] pointer-events-none"></div>
                
                <div class="relative z-10">
                    <h3 class="text-2xl font-bold mb-8">Thông tin liên hệ</h3>
                    
                    <div class="space-y-8">
                        @if($contactBranches->isNotEmpty())
                            @foreach($contactBranches as $branch)
                        <div class="flex items-start gap-4">
                            <div class="panel-brand__icon contact-icon--brand w-12 h-12 rounded-full border flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">{{ $branch->name ?: 'Địa chỉ' }}</h4>
                                <p class="panel-brand__copy text-sm leading-relaxed">{{ $branch->address }}</p>
                                @if($branch->phone)
                                    <p class="mt-1"><a href="tel:{{ preg_replace('/[^0-9+]/', '', $branch->phone) }}" class="panel-brand__link transition-colors text-sm font-medium">{{ $branch->phone }}</a></p>
                                @endif
                            </div>
                        </div>
                            @endforeach
                        @elseif($business->main_address)
                        <div class="flex items-start gap-4">
                            <div class="panel-brand__icon contact-icon--brand w-12 h-12 rounded-full border flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Trụ sở chính</h4>
                                <p class="panel-brand__copy text-sm leading-relaxed">{{ $business->main_address }}</p>
                            </div>
                        </div>
                        @endif

                        @if($contactPhones->isNotEmpty())
                        <div class="flex items-start gap-4">
                            <div class="panel-brand__icon contact-icon--info w-12 h-12 rounded-full border flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Đường dây nóng</h4>
                                @foreach($contactPhones as $phone)
                                    <p class="{{ $loop->first ? '' : 'mt-1' }}"><a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone['number']) }}" class="panel-brand__link transition-colors text-sm font-medium">{{ $phone['number'] }}</a></p>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($business->main_email)
                        <div class="flex items-start gap-4">
                            <div class="panel-brand__icon contact-icon--warning w-12 h-12 rounded-full border flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Email hỗ trợ</h4>
                                <p><a href="mailto:{{ $business->main_email }}" class="panel-brand__link transition-colors text-sm font-medium">{{ $business->main_email }}</a></p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="panel-brand__divider relative z-10 mt-12 pt-8 border-t">
                    <h4 class="text-sm font-bold uppercase tracking-wider mb-4">Kết nối với chúng tôi</h4>
                    <div class="flex gap-3">
                        @if($web->facebook_url)
                        <a href="{{ $web->facebook_url }}" target="_blank" class="social-link social-link--facebook w-10 h-10 rounded-full flex items-center justify-center transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                        @endif
                        @if($web->youtube_url)
                        <a href="{{ $web->youtube_url }}" target="_blank" class="social-link social-link--youtube w-10 h-10 rounded-full flex items-center justify-center transition-colors"><i class="fa-brands fa-youtube"></i></a>
                        @endif
                        @if($web->zalo_number)
                        <a href="https://zalo.me/{{ preg_replace('/[^0-9]/', '', $web->zalo_number) }}" target="_blank" class="social-link social-link--zalo w-10 h-10 rounded-full flex items-center justify-center transition-colors"><i class="fa-solid fa-comment-dots"></i></a>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ── Bản đồ Google Maps ─────────────────────────────────── --}}
@if($web->google_map_embed)
<section class="page-map-placeholder w-full h-[400px]">
    {!! $web->google_map_embed !!}
</section>
@endif

@endsection
