@extends('layouts.master')
@section('title','Trang chủ')
@push('css')
{{-- <link rel="stylesheet" href="{{asset('css/slide.css')}}?{{time()}}"> --}}
<link rel="stylesheet" href="{{asset('vendor/glightbox/css/glightbox.min.css')}}?{{time()}}">
@endpush
@section('content')
@include('partials.frontend.hero')
{{-- <section id="tab-home" class="tab-home section">
	<div class="container">
		<h2 class="section-title">
			<a href="#">DỰ ÁN THIẾT KẾ - THI CÔNG NỘI THẤT</a>
		</h2>
		<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
			<li class="nav-item" role="presentation">
				<a class="nav-link active" id="tab-chung-cu" data-toggle="pill" href="#pane-chung-cu" role="tab" aria-controls="pane-chung-cu" aria-selected="true">
					<img src="{{asset('images/setting/chung-cu-1.png')}}" alt="Chung cư 1">
					<span>Chung cư</span>
				</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="tab-nha-pho" data-toggle="pill" href="#pane-nha-pho" role="tab" aria-controls="pane-nha-pho" aria-selected="false">
					<img src="{{asset('images/setting/nha-pho.png')}}" alt="Nhà phố">
					<span>Nhà phố</span>
				</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="tab-biet-thu" data-toggle="pill" href="#pane-biet-thu" role="tab" aria-controls="pane-biet-thu" aria-selected="false">
					<img src="{{asset('images/setting/biet-thu.png')}}" alt="Biệt thự">
					<span>Biệt thự</span>
				</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="tab-van-phong" data-toggle="pill" href="#pane-van-phong" role="tab" aria-controls="pane-van-phong" aria-selected="false">
					<img src="{{asset('images/setting/van-phong.png')}}" alt="Văn phòng">
					<span>Văn Phòng</span>
				</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="tab-phong-ngu" data-toggle="pill" href="#pane-phong-ngu" role="tab" aria-controls="pane-phong-ngu" aria-selected="false">
					<img src="{{asset('images/setting/phong-ngu.png')}}" alt="Phòng ngủ">
					<span>Phòng ngủ</span>
				</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="tab-phong-khach" data-toggle="pill" href="#pane-phong-khach" role="tab" aria-controls="pane-phong-khach" aria-selected="false">
					<img src="{{asset('images/setting/phong-khach.png')}}" alt="Phòng khách">
					<span>Phòng khách</span>
				</a>
			</li>
		</ul>

		<div class="tab-content" id="pills-tabContent">
			<div class="tab-pane fade show active" id="pane-chung-cu" role="tabpanel" aria-labelledby="tab-chung-cu">
				<div class="tab-list">
					<div class="row">
						@for ($i = 0; $i < 6; $i++)
						<div class="col-6 col-lg-4 col-md-6 col-sm-6">
							<a href="">
								<div class="tab-item">
									<div class="box-imge">
										<img src="{{asset('images/setting/banner-004.jpg')}}" alt="">
									</div>
									<div class="box-title">
										<img src="{{asset('images/setting/THT-media-logo.png')}}" alt="">
										<p>Dự án A</p>
									</div>
								</div>
							</a>
						</div>
						@endfor
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="pane-nha-pho" role="tabpanel" aria-labelledby="tab-nha-pho">...</div>
			<div class="tab-pane fade" id="pane-biet-thu" role="tabpanel" aria-labelledby="tab-biet-thu">...</div>
			<div class="tab-pane fade" id="pane-van-phong" role="tabpanel" aria-labelledby="tab-van-phong">...</div>
			<div class="tab-pane fade" id="pane-phong-ngu" role="tabpanel" aria-labelledby="tab-phong-ngu">...</div>
			<div class="tab-pane fade" id="pane-phong-khach" role="tabpanel" aria-labelledby="tab-phong-khach">...</div>
		</div>
	</div>
</section> --}}
<section class="about section">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-6 col-sm-12">
				<div class="about-img">
					<img src="" alt="">
				</div>
			</div>
			<div class="col-12 col-md-6 col-sm-12">
				
			</div>
		</div>
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