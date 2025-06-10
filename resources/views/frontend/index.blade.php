@extends('layouts.master')
@section('title','Trang chủ')
@push('css')
{{-- <link rel="stylesheet" href="{{asset('css/slide.css')}}?{{time()}}"> --}}
<link rel="stylesheet" href="{{asset('vendor/glightbox/css/glightbox.min.css')}}?{{time()}}">
@endpush
@section('content')
@include('partials.frontend.hero')

<section class="about section">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-6 col-sm-12">
				<div class="about-img">
					<img src="{{asset('images/setting/tht-img.png')}}" alt="">
				</div>
			</div>
			<div class="col-12 col-md-6 col-sm-12">
				<div class="about-text">
                    <h2 class="about-title"><a href="">THT Media</a></h2>
                    <div class="about-des">
                        
                    </div>
                    <a href="#">Tìm hiểu thêm</a>
                </div>            
			</div>
		</div>
	</div>
</section>
<section class="section product">
    <div class="container">
        <h2 class="section-title">
            <a href="">Sản phẩm</a>
        </h2>

        {{-- Nav Tabs --}}
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            @foreach($categories as $key => $category)
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $key == 0 ? 'active' : '' }}"
                       id="category-tab-{{ $category->id }}"
                       data-toggle="pill"
                       href="#category-pane-{{ $category->id }}"
                       role="tab"
                       aria-controls="category-pane-{{ $category->id }}"
                       aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
                        <span>{{ $category->name }}</span>
                    </a>
                </li>
            @endforeach
        </ul>

        {{-- Tab Content --}}
        <div class="tab-content" id="pills-tabContent">
            @foreach($categories as $key => $category)
                <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}"
                     id="category-pane-{{ $category->id }}"
                     role="tabpanel"
                     aria-labelledby="category-tab-{{ $category->id }}">
                    
                    <div class="tab-list">
                        <div class="row">
                            @foreach($category->products as $product)
                                <div class="col-6 col-sm-6 col-md-4 col-lg-4">
                                    <a href="{{ route('product.show', $product->slug) }}">
                                        <div class="tab-item">
                                            <div class="box-imge">
                                                <img src="{{ asset($product->image ?? 'images/default-product.jpg') }}" alt="{{ $product->name }}">
                                            </div>
                                            <div class="box-title">
                                                <img src="{{ asset('images/setting/THT-media-logo.png') }}" alt="Logo">
                                                <p>{{ $product->name }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</section>
<section id="customer-testimonials" class="section testimonials py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">
            <a href="#">KHÁCH HÀNG NHẬN XÉT</a>
        </h2>
        
        <div class="row">
            {{-- Testimonial 1 --}}
            <div class="col-md-6 mb-4 d-flex">
                <div class="media">
                    <img class="mr-3 rounded-circle" src="{{ asset('images/customers/kh-1.jpg') }}" alt="Ms Nguyễn Thị Bích Huyền" width="80" height="80">
                    <div class="media-body">
                        <p>Sản phẩm phim quảng cáo của Connect Media luôn sáng tạo, hình ảnh đẹp, nội dung sâu sắc và đặc biệt tiến độ sản xuất cực nhanh. Từ khi tôi đưa đề bài tới khi nhận sản phẩm hoàn thiện chưa đầy 30 ngày.</p>
                        <strong>Ms Nguyễn Thị Bích Huyền</strong><br>
                        <small>Trưởng phòng Truyền thông Thương hiệu, Công ty CP Hanel</small>
                    </div>
                </div>
            </div>

            {{-- Testimonial 2 --}}
            <div class="col-md-6 mb-4 d-flex">
                <div class="media">
                    <img class="mr-3 rounded-circle" src="{{ asset('images/customers/kh-2.jpg') }}" alt="Trần Vũ Hoàng" width="80" height="80">
                    <div class="media-body">
                        <p>Tôi rất hài lòng khi hợp tác với ConnectMedia. Thời gian chuẩn bị khá ngắn nhưng các bạn đã hoàn thành xuất sắc.</p>
                        <strong>Trần Vũ Hoàng</strong><br>
                        <small>TGĐ Công ty CP SAPPHIRE COAST</small>
                    </div>
                </div>
            </div>

            {{-- Testimonial 3 --}}
            <div class="col-md-6 mb-4 d-flex">
                <div class="media">
                    <img class="mr-3 rounded-circle" src="{{ asset('images/customers/kh-3.jpg') }}" alt="Ms Nga" width="80" height="80">
                    <div class="media-body">
                        <p>Connect Media đã đồng hành cùng Moaz Bé bé nhiều năm, chúng tôi đã tin tưởng giao cho Connect hơn 20 sản phẩm để làm phim giới thiệu. Connect Media mang lại những sản phẩm phim chất lượng cao với chi phí hợp lý.</p>
                        <strong>Ms Nga</strong><br>
                        <small>Marketing Manager – Công ty cổ phần HD – Moaz Bé Bé</small>
                    </div>
                </div>
            </div>

            {{-- Testimonial 4 --}}
            <div class="col-md-6 mb-4 d-flex">
                <div class="media">
                    <img class="mr-3 rounded-circle" src="{{ asset('images/customers/kh-4.jpg') }}" alt="Ms Ngọc Bích" width="80" height="80">
                    <div class="media-body">
                        <p>Tôi rất hài lòng với dịch vụ chăm sóc khách hàng của Connect, tư vấn tận tình hỗ trợ chỉnh sửa hậu kỳ và cập nhật thông tin mới tới hơn 12 tháng ngay sau khi phim được nghiệm thu.</p>
                        <strong>Ms Ngọc Bích</strong><br>
                        <small>Sales Director – OHSHO Media</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="customer-testimonials" class="section testimonials py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">
            <a href="#">KHÁCH HÀNG NHẬN XÉT</a>
        </h2>
        
        <div class="row">
            {{-- Testimonial 1 --}}
            <div class="col-md-6 mb-4 d-flex">
                <div class="media">
                    <img class="mr-3 rounded-circle" src="{{ asset('images/customers/kh-1.jpg') }}" alt="Ms Nguyễn Thị Bích Huyền" width="80" height="80">
                    <div class="media-body">
                        <p>Sản phẩm phim quảng cáo của Connect Media luôn sáng tạo, hình ảnh đẹp, nội dung sâu sắc và đặc biệt tiến độ sản xuất cực nhanh. Từ khi tôi đưa đề bài tới khi nhận sản phẩm hoàn thiện chưa đầy 30 ngày.</p>
                        <strong>Ms Nguyễn Thị Bích Huyền</strong><br>
                        <small>Trưởng phòng Truyền thông Thương hiệu, Công ty CP Hanel</small>
                    </div>
                </div>
            </div>

            {{-- Testimonial 2 --}}
            <div class="col-md-6 mb-4 d-flex">
                <div class="media">
                    <img class="mr-3 rounded-circle" src="{{ asset('images/customers/kh-2.jpg') }}" alt="Trần Vũ Hoàng" width="80" height="80">
                    <div class="media-body">
                        <p>Tôi rất hài lòng khi hợp tác với ConnectMedia. Thời gian chuẩn bị khá ngắn nhưng các bạn đã hoàn thành xuất sắc.</p>
                        <strong>Trần Vũ Hoàng</strong><br>
                        <small>TGĐ Công ty CP SAPPHIRE COAST</small>
                    </div>
                </div>
            </div>

            {{-- Testimonial 3 --}}
            <div class="col-md-6 mb-4 d-flex">
                <div class="media">
                    <img class="mr-3 rounded-circle" src="{{ asset('images/customers/kh-3.jpg') }}" alt="Ms Nga" width="80" height="80">
                    <div class="media-body">
                        <p>Connect Media đã đồng hành cùng Moaz Bé bé nhiều năm, chúng tôi đã tin tưởng giao cho Connect hơn 20 sản phẩm để làm phim giới thiệu. Connect Media mang lại những sản phẩm phim chất lượng cao với chi phí hợp lý.</p>
                        <strong>Ms Nga</strong><br>
                        <small>Marketing Manager – Công ty cổ phần HD – Moaz Bé Bé</small>
                    </div>
                </div>
            </div>

            {{-- Testimonial 4 --}}
            <div class="col-md-6 mb-4 d-flex">
                <div class="media">
                    <img class="mr-3 rounded-circle" src="{{ asset('images/customers/kh-4.jpg') }}" alt="Ms Ngọc Bích" width="80" height="80">
                    <div class="media-body">
                        <p>Tôi rất hài lòng với dịch vụ chăm sóc khách hàng của Connect, tư vấn tận tình hỗ trợ chỉnh sửa hậu kỳ và cập nhật thông tin mới tới hơn 12 tháng ngay sau khi phim được nghiệm thu.</p>
                        <strong>Ms Ngọc Bích</strong><br>
                        <small>Sales Director – OHSHO Media</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="achievements" class="section achievements">
    <div class="container">
        <h2 class="section-title">Thành tựu</h2>
    </div>
</section>
<section id="clients-partners" class="section partners">
    <div class="container">
        <h2 class="section-title">Khách hàng & Đối tác</h2>
        <!-- Nội dung: logo, carousel thương hiệu, lời chứng thực -->
    </div>
</section>
<section class="blog">
    <div class="container">
        <h2 class="section-title">
            <a href="{{route('frontend.posts.allPost')}}">Blog</a>
        </h2>
        
    </div>
</section>     					
@endsection
@push('js')
<script src="{{asset('vendor/glightbox/js/glightbox.min.js')}}?{{time()}}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const lightbox = GLightbox({
            selector: '.glightbox'
        });
    });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const swiper = new Swiper('.slider', {
      loop: true,

      lazy: {
        loadPrevNext: true, // preload slide trước và sau
        loadPrevNextAmount: 1,
      },

      autoplay: {
        delay: 4000,
        disableOnInteraction: false, // vẫn tiếp tục autoplay sau khi user điều khiển
      },

      pagination: {
        el: '.swiper-pagination',
        clickable: true,
        renderBullet: function (index, className) {
          return '<span class="' + className + '"></span>';
        }
      },

      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },

      speed: 600,
      effect: 'fade', // hoặc 'fade', 'cube', v.v.
    });
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.categorySlide').forEach(function (el) {
      new Swiper(el, {
        loop: true,
        lazy: {
          loadPrevNext: true,
          loadPrevNextAmount: 1,
        },
        autoplay: {
          delay: 4000,
          disableOnInteraction: false,
        },
        pagination: {
          el: el.querySelector('.swiper-pagination'),
          clickable: true,
        },
        navigation: {
          nextEl: el.querySelector('.swiper-button-next'),
          prevEl: el.querySelector('.swiper-button-prev'),
        },
        slidesPerView: 4,
        slidesPerGroup: 4,
        spaceBetween: 20,
        loopedSlides: 8,
        loopFillGroupWithBlank: true,
        speed: 600,
        breakpoints: {
          0: { slidesPerView: 1, slidesPerGroup: 1 },
          576: { slidesPerView: 2, slidesPerGroup: 2 },
          768: { slidesPerView: 3, slidesPerGroup: 3 },
          992: { slidesPerView: 4, slidesPerGroup: 4 }
        }
      });
    });
  });
</script>

@endpush