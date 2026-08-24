@extends('layouts.master')

@section('title', $page->about_title ?: 'Giới thiệu - ' . config('app.name'))
@section('description', $page->about_description ?: $web->site_description)

@section('content')

{{-- ── Hero Banner ──────────────────────────────────────────────────────── --}}
@php
    $bannerImg = $page->about_banner ? asset('storage/'.$page->about_banner) : asset('images/og-default.jpg');
    $title     = $page->about_title ?: 'Về THT Media';
@endphp
<section class="page-hero relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden" aria-label="Banner Giới thiệu">
    <div class="absolute inset-0 z-0">
        <img src="{{ $bannerImg }}" alt="{{ $title }}" class="w-full h-full object-cover object-center">
    </div>
    
    <div class="container mx-auto px-4 max-w-5xl relative z-10 text-center" data-aos="fade-up">
        <h1 class="page-hero__title text-3xl md:text-4xl lg:text-5xl font-extrabold mb-6 leading-tight tracking-tight">{{ $title }}</h1>
    </div>
    
</section>

<div class="page-breadcrumb-strip border-b">
    <div class="container mx-auto max-w-7xl px-4">
        <x-breadcrumb :items="[['label' => 'Giới thiệu']]" />
    </div>
</div>

{{-- ── Thư ngỏ từ CEO (CEO Letter) ─────────────────────────────────────── --}}
<section class="py-16 md:py-24 bg-white relative overflow-hidden" aria-label="Thư ngỏ từ CEO">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="flex flex-col md:flex-row items-center gap-12 lg:gap-20">
            
            {{-- Ảnh Giám đốc / Founder --}}
            <div class="w-full md:w-5/12 lg:w-4/12 relative" data-aos="fade-right">
                <div class="relative z-10 rounded-2xl md:rounded-tl-[4rem] md:rounded-br-[4rem] overflow-hidden border-4 border-[var(--color-surface)]">
                    {{-- Dummy image for CEO - Em có thể thay bằng ảnh thật sau --}}
                    <img src="{{ asset('images/og-default.jpg') }}" alt="CEO THT Media" class="w-full aspect-[3/4] object-cover filter contrast-125 saturate-50">
                </div>
                {{-- Decorative box behind --}}
                <div class="about-image-frame absolute top-6 -left-6 w-full h-full border-2 rounded-2xl md:rounded-tl-[4rem] md:rounded-br-[4rem] z-0 opacity-50"></div>
                
                {{-- Name Tag --}}
                <div class="page-card absolute -bottom-6 right-4 sm:-right-8 px-6 py-4 rounded-xl z-20 border">
                    <p class="font-extrabold text-gray-900 text-lg">Nguyễn Văn A</p>
                    <p class="about-role text-xs font-bold uppercase tracking-widest mt-1">Founder & CEO</p>
                </div>
            </div>
            
            {{-- Nội dung Thư ngỏ --}}
            <div class="w-full md:w-7/12 lg:w-8/12 mt-8 md:mt-0" data-aos="fade-left">
                <div class="about-quote-mark text-6xl md:text-8xl leading-none font-serif mb-[-1rem] md:mb-[-2rem] opacity-50 select-none">"</div>
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-gray-900 mb-6 leading-tight">Thư ngỏ từ người sáng lập</h2>
                
                <div class="text-gray-600 leading-relaxed text-base md:text-lg space-y-5 relative z-10">
                    <p class="font-medium text-gray-800 text-lg md:text-xl">Kính gửi Quý Khách hàng và Đối tác,</p>
                    <p>Hành trình của THT Media bắt đầu từ một niềm tin mãnh liệt: Rằng mỗi doanh nghiệp đều mang trong mình một câu chuyện phi thường cần được kể lại. Trong kỷ nguyên số, không thiếu những công cụ truyền thông, nhưng lại quá thiếu những thước phim, những khung hình thật sự chạm đến trái tim khán giả.</p>
                    <p>Chúng tôi không chỉ cung cấp dịch vụ quay phim hay chụp ảnh; chúng tôi nhận trách nhiệm "đánh thức" linh hồn của thương hiệu bạn. Đối với THT, mỗi dự án dù lớn hay nhỏ đều là một tác phẩm nghệ thuật đòi hỏi sự tận tâm tuyệt đối từ khâu kịch bản cho đến cú máy cuối cùng.</p>
                    <p>Sự thành công và phát triển vượt bậc của chục trăm đối tác gắn bó cùng THT thời gian qua chính là minh chứng rõ ràng nhất cho lời giải của bài toán "Hiệu quả truyền thông đi đôi với Sáng tạo nghệ thuật".</p>
                    <p class="font-bold text-gray-900 mt-6 pt-6 border-t border-gray-100">Cảm ơn bạn đã tin tưởng chọn THT Media làm người bạn đồng hành kiến tạo những giá trị đích thực!</p>
                </div>
                
                {{-- Chữ ký (Giả lập) --}}
                <div class="mt-8 opacity-70">
                    <p class="about-brand-text text-xl font-semibold tracking-wide">A. Nguyen</p>
                </div>
            </div>
            
        </div>
    </div>
</section>

{{-- ── Tầm nhìn & Sứ mệnh ─────────────────────────────────────────────── --}}
<section class="py-16 md:py-24 bg-white" aria-label="Tầm nhìn và Sứ mệnh">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20">
            {{-- Sứ mệnh --}}
            <div data-aos="fade-up" class="group">
                <div class="about-feature-icon--brand w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-[var(--color-brand-primary)] group-hover:text-[var(--color-white)] transition-colors duration-300">
                    <i class="fa-solid fa-rocket"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Sứ mệnh</h2>
                <div class="text-gray-600 leading-relaxed text-base md:text-lg space-y-4">
                    @if($mission)
                        {!! $mission->content !!}
                    @else
                        <p>Trở thành đơn vị tiên phong trong việc cung cấp các giải pháp truyền thông số sáng tạo, giúp các doanh nghiệp Việt Nam nâng tầm thương hiệu và tối ưu hóa hiệu quả kinh doanh một cách bền vững trên môi trường số.</p>
                    @endif
                </div>
            </div>

            {{-- Tầm nhìn --}}
            <div data-aos="fade-up" data-aos-delay="100" class="group">
                <div class="about-feature-icon--info w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-[var(--color-info-600)] group-hover:text-[var(--color-white)] transition-colors duration-300">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Tầm nhìn</h2>
                <div class="text-gray-600 leading-relaxed text-base md:text-lg space-y-4">
                    @if($vision)
                        {!! $vision->content !!}
                    @else
                        <p>Kiến tạo một hệ sinh thái dịch vụ media toàn diện, nơi mọi ý tưởng đột phá đều được hiện thực hóa bằng công nghệ hiện đại và tư duy khác biệt. Không ngừng mở rộng biên giới sáng tạo để vươn tầm quốc tế.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Giá trị cốt lõi (Core Values) ─────────────────────────────────── --}}
<section class="py-20 md:py-28 bg-[var(--color-surface-muted)] border-y border-[var(--color-border-subtle)] relative overflow-hidden" aria-label="Giá trị cốt lõi">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[var(--color-brand-50)] rounded-full blur-[120px] pointer-events-none"></div>
    
    <div class="container mx-auto px-4 max-w-7xl relative z-10">
        <div class="text-center mb-16 md:mb-20" data-aos="fade-up">
            <span class="section-kicker inline-block px-3 py-1 mb-4 text-xs font-black tracking-widest rounded-lg uppercase">Nền tảng phát triển</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900">Giá trị cốt lõi</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            {{-- Mặc định lấy Data tĩnh nếu không có settings $values --}}
            @php
                // Tách list values nếu là nội dung dài có li gạch đầu dòng, ở đây tạm giả lập 3 khối cứng
                $coreValues = [
                    ['icon' => 'fa-solid fa-lightbulb', 'tone' => 'about-value-icon--creative', 'title' => 'Sáng tạo đột phá', 'desc' => 'Không ngừng cập nhật xu hướng, phá bỏ giới hạn tư duy cũ để tạo ra những sản phẩm độc bản mang đậm dấu ấn thương hiệu.'],
                    ['icon' => 'fa-solid fa-handshake', 'tone' => 'about-value-icon--care', 'title' => 'Tận tâm đồng hành', 'desc' => 'Coi dự án của khách hàng như chính đứa con tinh thần của mình. Sát cánh từ khâu lên ý tưởng đến khi đo lường hiệu quả thực tế.'],
                    ['icon' => 'fa-solid fa-gem', 'tone' => 'about-value-icon--quality', 'title' => 'Chất lượng hàng đầu', 'desc' => 'Tiêu chuẩn khắt khe trong mọi quy trình làm việc. Chỉ bàn giao những sản phẩm đạt chất lượng cao nhất theo đúng cam kết.'],
                ];
            @endphp

            @foreach($coreValues as $i => $val)
            <div data-aos="fade-up" data-aos-delay="{{ $i * 100 }}" class="page-card rounded-3xl p-8 border hover:-translate-y-2 transition-all duration-300">
                <div class="{{ $val['tone'] }} w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-6">
                    <i class="{{ $val['icon'] }}"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $val['title'] }}</h3>
                <p class="text-gray-500 text-sm md:text-base leading-relaxed">{{ $val['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Đội ngũ của chúng tôi (Team) ─────────────────────────────────── --}}
<section class="py-20 md:py-28 bg-white" aria-label="Đội ngũ">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex flex-col md:flex-row gap-10 lg:gap-20 items-center">
            
            <div class="w-full md:w-1/2" data-aos="fade-right">
                <span class="section-kicker section-kicker--info inline-block px-3 py-1 mb-4 text-xs font-black tracking-widest rounded-lg uppercase">Con người THT</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-6 leading-tight">Sức mạnh từ <br><span class="about-brand-text">tập thể vững mạnh</span></h2>
                <div class="text-gray-600 leading-relaxed text-base md:text-lg space-y-4 mb-8">
                    <p>Đằng sau sự thành công của mỗi chiến dịch là sức lao động bền bỉ, trí tuệ mài giũa và sự phối hợp nhịp nhàng của các phòng ban chuyên môn.</p>
                    <p>Chúng tôi tập hợp những chuyên gia trẻ tuổi, nhiệt huyết, dám nghĩ dám làm và không bao giờ hài lòng với những gì đang có.</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="text-center">
                        <span class="block text-4xl font-extrabold text-gray-900 mb-1">50+</span>
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Nhân sự</span>
                    </div>
                    <div class="w-px h-12 bg-gray-200"></div>
                    <div class="text-center">
                        <span class="block text-4xl font-extrabold text-gray-900 mb-1">98%</span>
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Hài lòng</span>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/2 relative" data-aos="fade-left">
                <div class="aspect-square rounded-[3rem] overflow-hidden relative z-10">
                    <img src="{{ $web->about_image ? asset('storage/'.$web->about_image) : asset('images/og-default.jpg') }}" alt="THT Media Team" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700">
                </div>
                {{-- Decor --}}
                <div class="about-decor--brand absolute -top-6 -right-6 w-32 h-32 rounded-full z-0 opacity-20 blur-xl"></div>
                <div class="about-decor--info absolute -bottom-6 -left-6 w-40 h-40 rounded-full z-0 opacity-20 blur-xl"></div>
            </div>
            
        </div>
    </div>
</section>

{{-- ── Kêu gọi hành động (CTA) ─────────────────────────────────── --}}
<section class="border-t border-[var(--color-border-subtle)] py-16 text-center bg-[var(--color-surface-muted)]" aria-label="Liên hệ">
    <div class="container mx-auto px-4" data-aos="zoom-in">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Bạn có dự án đột phá cần thực hiện?</h2>
        <p class="text-gray-500 mb-8 max-w-2xl mx-auto">Hãy để chúng tôi lắng nghe và biến những ý tưởng của bạn thành hiện thực với chi phí tối ưu nhất.</p>
        <a href="{{ route('contact.index') }}" class="btn-brand">Liên hệ ngay hôm nay <i class="fa-solid fa-paper-plane ml-2"></i></a>
    </div>
</section>

@endsection

@push('scripts')
<script>
// GLightbox init (nếu chưa global)
if (typeof GLightbox !== 'undefined') {
    GLightbox({ selector: '.glightbox' });
}
</script>
@endpush
