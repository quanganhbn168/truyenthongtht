@extends('layouts.master')
@section('title','Trang chủ')
@push('css')
<link rel="stylesheet" href="{{asset('css/slide.css')}}?{{time()}}">
<link rel="stylesheet" href="{{asset('vendor/glightbox/css/glightbox.min.css')}}?{{time()}}">
@endpush
@section('content')
@include('partials.frontend.slide')
<section id="tab-home" class="tab-home section">
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
</section>
				
<div id="banggia">
	<a href="">
		<img src="{{asset('images/setting/banner-nhan-bao-gia.jpg')}}" alt="">
	</a>
</div>
<section class="section category">
	<div class="container">
		<h3 class="section-title text-center">Thiết kế kiến trúc</h3>
		<h3 class="section-title-second text-center">Thiết kế kiến trúc</h3>
		<div class="section-content">
			<div class="swiper categorySlide">
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<div class="categorySlide-item">
							<img src="{{asset('images/slides/slide-doc-001.jpg')}}" alt="">
							<a href="">Tên slide</a>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="categorySlide-item">
							<img src="{{asset('images/slides/slide-doc-001.jpg')}}" alt="">
							<a href="">Tên slide</a>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="categorySlide-item">
							<img src="{{asset('images/slides/slide-doc-001.jpg')}}" alt="">
							<a href="">Tên slide</a>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="categorySlide-item">
							<img src="{{asset('images/slides/slide-doc-001.jpg')}}" alt="">
							<a href="">Tên slide</a>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="categorySlide-item">
							<img src="{{asset('images/slides/slide-doc-001.jpg')}}" alt="">
							<a href="">Tên slide</a>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="categorySlide-item">
							<img src="{{asset('images/slides/slide-doc-001.jpg')}}" alt="">
							<a href="">Tên slide</a>
						</div>
					</div>
				</div>
				<div class="swiper-pagination"></div>
  			<div class="swiper-button-prev"></div>
  			<div class="swiper-button-next"></div>
			</div>
		</div>
	</div>
</section>
<section class="section category">
	<div class="container">
		<h3 class="section-title text-center">Thiết kế, thi công nội thất</h3>
		<h3 class="section-title-second text-center">Dịch vụ thiết kế, thi công nội thất của chúng tôi</h3>
		<div class="section-content">
			<div class="swiper categorySlide">
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<div class="categorySlide-item">
							<img src="{{asset('images/slides/slide-doc-001.jpg')}}" alt="">
							<a href="">Tên slide</a>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="categorySlide-item">
							<img src="{{asset('images/slides/slide-doc-001.jpg')}}" alt="">
							<a href="">Tên slide</a>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="categorySlide-item">
							<img src="{{asset('images/slides/slide-doc-001.jpg')}}" alt="">
							<a href="">Tên slide</a>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="categorySlide-item">
							<img src="{{asset('images/slides/slide-doc-001.jpg')}}" alt="">
							<a href="">Tên slide</a>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="categorySlide-item">
							<img src="{{asset('images/slides/slide-doc-001.jpg')}}" alt="">
							<a href="">Tên slide</a>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="categorySlide-item">
							<img src="{{asset('images/slides/slide-doc-001.jpg')}}" alt="">
							<a href="">Tên slide</a>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="categorySlide-item">
							<img src="{{asset('images/slides/slide-doc-001.jpg')}}" alt="">
							<a href="">Tên slide</a>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="categorySlide-item">
							<img src="{{asset('images/slides/slide-doc-001.jpg')}}" alt="">
							<a href="">Tên slide</a>
						</div>
					</div>
				</div>
					<div class="swiper-pagination"></div>
					<div class="swiper-button-prev"></div>
					<div class="swiper-button-next"></div>
			</div>
		</div>
	</div>
</section>
<section id="difference">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-5 order-2 order-md-1">
				<h3>Khác biệt <br> của chúng tôi</h3>
				<p>Lý do làm nội thất trọn gói nên chọn VOYHOME</p>
				<ul>
					<li>Đội KTS chuyên nghiệp – bản vẽ đạt chuẩn</li>
					<li>Giám đốc đi lên từ thợ chính – đội ngũ thợ giàu kinh nghiệm</li>
					<li>Có nhà xưởng sản xuất trực tiếp – giảm 30% chi phí</li>
					<li>Miễn phí thiết kế thi công nội thất trọn gói</li>
					<li>Cam kết thực hiện đúng 100% hợp đồng</li>
					<li>Bảo hành 2 năm – có mặt sau 48h tiếp nhận thông tin</li>
				</ul>
			</div>
			<div class="col-12 col-sm-12 col-md-7 order-1 order-md-2">
				<img src="{{asset('images/setting/banner-001.jpg')}}" alt="">
			</div>
		</div>
	</div>
</section>
<section id="video" class="section">
	<div class="container">
		<div class="list-video">
			<h3 class="section-title"><a href="">HOÀN THIỆN NỘI THẤT</a></h3>
			<div class="row">
				<div class="col-12 col-sm-12 col-md-4">
					<div class="video-item">
						<img src="{{asset('images/setting/banner-001.jpg')}}" alt="">
						<h5 class="video-title"><a href="">Hoàn thiện nội thất nhà phố - C Nết - tp. Ninh Bình - Nội thất Voyhome</a></h5>
						<span>VoyHome Channel <i class="fas fa-check-circle"></i></span>
					</div>
				</div>
				<div class="col-12 col-sm-12 col-md-4">
					<div class="video-item">
						<img src="{{asset('images/setting/banner-001.jpg')}}" alt="">
						<h5 class="video-title"><a href="">Hoàn thiện nội thất nhà phố - C Nết - tp. Ninh Bình - Nội thất Voyhome</a></h5>
						<span>VoyHome Channel <i class="fas fa-check-circle"></i></span>
					</div>
				</div>
				<div class="col-12 col-sm-12 col-md-4">
					<div class="video-item">
						<img src="{{asset('images/setting/banner-001.jpg')}}" alt="">
						<h5 class="video-title"><a href="">Hoàn thiện nội thất nhà phố - C Nết - tp. Ninh Bình - Nội thất Voyhome</a></h5>
						<span>VoyHome Channel <i class="fas fa-check-circle"></i></span>
					</div>
				</div>
			</div>
		</div>

		<div class="list-video">
			<h3 class="section-title"><a href="">SẢN XUẤT VÀ THI CÔNG NỘI THẤT</a></h3>
			<div class="row">
				<div class="col-12 col-sm-12 col-md-4">
					<div class="video-item">
						<div class="video-cover">
							<a href="https://youtu.be/0cf5SbaPUHs?si=zd3bzHJI2EYgwRlp" class="glightbox">
								<img src="https://img.youtube.com/vi/0cf5SbaPUHs/hqdefault.jpg" alt="Video">
							<i class="btn-youtube"></i>
							</a>
						</div>
						<h5 class="video-title">
							<a href="https://youtu.be/0cf5SbaPUHs?si=zd3bzHJI2EYgwRlp" class="glightbox">
								Hoàn thiện nội thất nhà phố - C Nết - tp. Ninh Bình - Nội thất Voyhome
							</a>
						</h5>
						<span>VoyHome Channel <i class="fas fa-check-circle"></i></span>
					</div>
				</div>
				<div class="col-12 col-sm-12 col-md-4">
					<div class="video-item">
						<div class="video-cover">
							<a href="https://youtu.be/0cf5SbaPUHs?si=zd3bzHJI2EYgwRlp" class="glightbox">
								<img src="https://img.youtube.com/vi/0cf5SbaPUHs/hqdefault.jpg" alt="Video">
							<i class="btn-youtube"></i>
							</a>
						</div>
						<h5 class="video-title">
							<a href="https://youtu.be/0cf5SbaPUHs?si=zd3bzHJI2EYgwRlp" class="glightbox">
								Hoàn thiện nội thất nhà phố - C Nết - tp. Ninh Bình - Nội thất Voyhome
							</a>
						</h5>
						<span>VoyHome Channel <i class="fas fa-check-circle"></i></span>
					</div>
				</div>
				<div class="col-12 col-sm-12 col-md-4">
					<div class="video-item">
						<div class="video-cover">
							<a href="https://youtu.be/0cf5SbaPUHs?si=zd3bzHJI2EYgwRlp" class="glightbox">
								<img src="https://img.youtube.com/vi/0cf5SbaPUHs/hqdefault.jpg" alt="Video">
							<i class="btn-youtube"></i>
							</a>
						</div>
						<h5 class="video-title">
							<a href="https://youtu.be/0cf5SbaPUHs?si=zd3bzHJI2EYgwRlp" class="glightbox">
								Hoàn thiện nội thất nhà phố - C Nết - tp. Ninh Bình - Nội thất Voyhome
							</a>
						</h5>
						<span>VoyHome Channel <i class="fas fa-check-circle"></i></span>
					</div>
				</div>
			</div>
		</div>
</section>
<section class="section exp">
	<div class="container">
		<h3 class="section-title">Kinh nghiệm hay</h3>
		<div class="section-content">
			<div class="row">
				<div class="col-12 col-md-7 col-sm-12">
					<img src="{{asset('images/setting/banner-001.jpg')}}" alt="">
				</div>
				<div class="col-12 col-md-5 col-sm-12">
					<div class="post-list">
						<div class="post-item">
							<a href="#" class="post-link">
								<h6 class="post-title">[Tổng Hợp] Những Mẫu Thiết Kế Phòng Khách 30m2 Đẹp Hút Ánh Nhìn</h6>
								<p class="post-meta">
									<i class="fa-solid fa-calendar-days text-dark"></i>
									<span class="date text-dark">04/06/2025</span>
								</p>
							</a>
						</div>
						<div class="post-item">
							<a href="#" class="post-link">
								<h6 class="post-title">[Tổng Hợp] Những Mẫu Thiết Kế Phòng Khách 30m2 Đẹp Hút Ánh Nhìn</h6>
								<p class="post-meta">
									<i class="fa-solid fa-calendar-days text-dark"></i>
									<span class="date text-dark">04/06/2025</span>
								</p>
							</a>
						</div>
						<div class="post-item">
							<a href="#" class="post-link">
								<h6 class="post-title">[Tổng Hợp] Những Mẫu Thiết Kế Phòng Khách 30m2 Đẹp Hút Ánh Nhìn</h6>
								<p class="post-meta">
									<i class="fa-solid fa-calendar-days text-dark"></i>
									<span class="date text-dark">04/06/2025</span>
								</p>
							</a>
						</div>
						<div class="post-item">
							<a href="#" class="post-link">
								<h6 class="post-title">[Tổng Hợp] Những Mẫu Thiết Kế Phòng Khách 30m2 Đẹp Hút Ánh Nhìn</h6>
								<p class="post-meta">
									<i class="fa-solid fa-calendar-days text-dark"></i>
									<span class="date text-dark">04/06/2025</span>
								</p>
							</a>
						</div>
						<div class="post-item">
							<a href="#" class="post-link">
								<h6 class="post-title">[Tổng Hợp] Những Mẫu Thiết Kế Phòng Khách 30m2 Đẹp Hút Ánh Nhìn</h6>
								<p class="post-meta">
									<i class="fa-solid fa-calendar-days text-dark"></i>
									<span class="date text-dark">04/06/2025</span>
								</p>
							</a>
						</div>
						<div class="post-item">
							<a href="#" class="post-link">
								<h6 class="post-title">[Tổng Hợp] Những Mẫu Thiết Kế Phòng Khách 30m2 Đẹp Hút Ánh Nhìn</h6>
								<p class="post-meta">
									<i class="fa-solid fa-calendar-days text-dark"></i>
									<span class="date text-dark">04/06/2025</span>
								</p>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section id="contact" class="py-4 my-3">
	<div class="container">
		<div class="card text-bg-light">
			<div class="card-header">
				<div class="card-title">
					<h3 class="strong text-uppercase">Liên hệ ngay với chúng tôi</h3>
				</div>
			</div>
			<div class="card-body bg-light">
				<form action="#" method="POST">
					@csrf
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="name">Họ và tên *</label>
								<input type="text" class="form-control" id="name" name="name" autocomplete>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="address">Địa chỉ</label>
								<input type="text" class="form-control" id="address" name="address" autocomplete>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="phone">Số điện thoại *</label>
								<input type="text" class="form-control" id="phone" name="phone" autocomplete>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="email">Email</label>
								<input type="text" class="form-control" id="email" name="email" autocomplete>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="content">Ý kiến</label>
						<textarea name="content" id="content" class="form-control" autocomplete></textarea>
					</div>
					<button class="btn btn-dark d-block w-100">Gửi ý kiến</button>
				</form>
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