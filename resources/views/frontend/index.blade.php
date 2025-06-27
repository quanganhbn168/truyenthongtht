@extends('layouts.master')
@section('title','Trang chủ')
@push('css')
<link rel="stylesheet" href="{{asset('vendor/glightbox/css/glightbox.min.css')}}?{{time()}}">
@endpush
@section('content')
@include('partials.frontend.slide')
<section class="section about">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-6 col-sm-12 order-1 order-md-2">
				<div class="about-img">
					<img src="{{asset($intro->image)}}" alt="{{$setting->name}}">
				</div>
			</div> 
			<div class="col-12 col-md-6 col-sm-12 order-1 order-md-2">
				<h2 class="section-title">
					<a href="">Về chúng tôi</a>
				</h2>
				<div class="about-description">
					{{$intro->description}}
				</div>
				<div class="text-center">
					<button class="btn btn-primary">Đăng ký ngay</button> 
				</div>
			</div>
		</div>
	</div>
</section>
<section class="section reason">
	<h2 class="section-title has-line"><a href="">Lý do chọn {{$setting->name}}</a></h2>
	<div class="container">
		<div class="row">
			<div class="col-6 col-md-4 col-sm-6 mb-4">
				<div class="reason-item">
					<div class="item-image">
						<i class="fas fa-award text-primary display-2"></i>
					</div>
					<div class="item-description">
						<p class="reason-name">Thương hiệu uy tín</p>
						<p class="reason-des">Trung tâm tiếng Trung Minh Khang với kinh nghiệm 14 năm trong lĩnh vực đào tạo tiếng Trung cho nhiều đối tác là doanh nghiệp Trung Quốc cùng với 9 cơ sở trải dài từ Bắc vào Nam</p>
					</div>
				</div>
			</div>
			<div class="col-6 col-md-4 col-sm-6 mb-4">
				<div class="reason-item">
					<div class="item-image">
						<i class="fas fa-chalkboard-teacher text-primary display-2"></i>
					</div>
					<div class="item-description">
						<p class="reason-name">GIẢNG VIÊN CHUYÊN NGHIỆP</p>
						<p class="reason-des">Giảng viên trình độ Thạc sĩ chuyên ngành tiếng Trung, tâm huyết nhiệt tình, nhiều năm kinh nghiệm giảng dạy cho hàng ngàn học viên.</p>
					</div>
				</div>
			</div>
			<div class="col-6 col-md-4 col-sm-6 mb-4">
				<div class="reason-item">
					<div class="item-image">
						<i class="fas fa-handshake text-primary display-2"></i>

					</div>
					<div class="item-description">
						<p class="reason-name">CAM KẾT CHẤT LƯỢNG</p>
						<p class="reason-des">Trung tâm tiếng Trung Minh Khang với kinh nghiệm 14 năm trong lĩnh vực đào tạo tiếng Trung cho nhiều đối tác là doanh nghiệp Trung Quốc cùng với 9 cơ sở trải dài từ Bắc vào Nam</p>
					</div>
				</div>
			</div>
			<div class="col-6 col-md-4 col-sm-6 mb-4">
				<div class="reason-item">
					<div class="item-image">
						<i class="fas fa-brain text-primary display-2"></i>
					</div>
					<div class="item-description">
						<p class="reason-name">Phương pháp hiện đại</p>
						<p class="reason-des">Nghe  - 	Nói  - Dịch phản xạ liên tục, luyện tập cá nhân với giáo viên, học qua trò chơi, thảo luận nhóm, giao lưu với người Trung Quốc.</p>
					</div>
				</div>
			</div>
			<div class="col-6 col-md-4 col-sm-6 mb-4">
				<div class="reason-item">
					<div class="item-image">
						<i class="fas fa-laptop-house text-primary display-2"></i>
					</div>
					<div class="item-description">
						<p class="reason-name">Cơ sở vật chất hiện đại</p>
						<p class="reason-des">Phòng học rộng rãi, thoáng mát, đầy đủ phương tiện và thiết bị: Tivi 50 Inch, điều hòa, máy chiếu, máy tính,...</p>
					</div>
				</div>
			</div>
			<div class="col-6 col-md-4 col-sm-6 mb-4">
				<div class="reason-item">
					<div class="item-image">
						<i class="fas fa-flag-checkered text-primary display-2"></i>
					</div>
					<div class="item-description">
						<p class="reason-name">CAM KẾT ĐẦU RA</p>
						<p class="reason-des">Trung tâm tiếng Trung Minh Khang với kinh nghiệm 14 năm trong lĩnh vực đào tạo tiếng Trung cho nhiều đối tác là doanh nghiệp Trung Quốc cùng với 9 cơ sở trải dài từ Bắc vào Nam</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="section course">
	<h2 class="section-title has-line">
		<a href="">Các khoá học tại {{$setting->name}}</a>
	</h2>
	<div class="container">
		<div class="row">
			@foreach($services as $key => $service)
			<div class="col-6 col-md-4">
				<a href="{{route('slug.resolve', $service->slug)}}" class="course-link">
					<div class="course-item">
						<div class="course-img">
							<img src="{{$service->image}}" alt="{{$service->name}}">
						</div>
						<p class="course-name">{{$service->name}}</p>
						<div class="course-description">{!!$service->description!!}</div>
					</div>
				</a>
			</div>
			@endforeach
		</div>
	</div>
</section>
<section class="section team">
	<h2 class="section-title has-line">Đội ngũ giảng viên</h2>
	<div class="swiper teamSlide">
		<div class="swiper-wrapper">
			@foreach($teams as $team)
			<div class="swiper-slide">
				<div class="team-member">
					<img src="{{ asset($team->image) }}" alt="{{ $team->name }}" class="avatar" />
					<h5 class="name">{{ $team->name }}</h5>
					<p class="position">{{ $team->position }}</p>
					<p class="hsk-level">HSK: {{ $team->hsk_level }}</p>
				</div>
			</div>
			@endforeach
		</div>

		<div class="swiper-pagination"></div>
		<div class="swiper-button-next"></div>
		<div class="swiper-button-prev"></div>
	</div>
</section>


<section class="section testimonial">
	<h2 class="section-title has-line">Cảm nhận của học viên</h2>
	<div class="swiper mySwiper">
		<div class="swiper-wrapper">
			@foreach($testimonials as $key => $testimonial)
			<div class="swiper-slide">
				<div class="testimonial-item">
					<img src="{{ asset($testimonial->image) }}" alt="{{ $testimonial->name }}" class="avatar" />
					<p class="content">{{ $testimonial->content }}</p>
					<h5 class="name">{{ $testimonial->name }}</h5>
				</div>
			</div>
			@endforeach
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>

<section class="section form">
	<h2 class="section-title"><a href="">Đăng ký nhận tư vấn ngay hôm nay</a></h2>
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-6 col-sm-12 d-none d-md-block">
				<div class="form-img">
					<img src="{{asset("images/setting/dangky.png")}}" alt="{{$setting->name}}">
				</div>
			</div>
			<div class="col-12 col-md-6 col-sm-12">
				<form action="{{route('contact.store')}}" id="contact-form" method="Post">
					@csrf
					<div class="form-group">
						<label>Họ và tên <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="name" >
					</div>
					<div class="form-group">
						<label>Số điện thoại <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="phone" >
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control" name="email" >
					</div>
					<div class="form-group">
						<label>Nội dung</label>
						<textarea name="content" id="content" class="form-control"></textarea>
					</div>
					<div class="text-center">
						<button class="btn btn-primary" type="submit" name="submit">Đăng ký ngay</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
@foreach($homeCategories as $key => $category)
<section class="section post">
	<h2 class="section-title">
		<a href="{{route('frontend.post.postByCate',$category->slug)}}">
			{{$category->name}}
		</a>
	</h2>
	<div class="container">
		<div class="row">
			@foreach($category->posts as $key2 => $post)
			<div class="col-12 col-md-4 col-sm-6">
				<a href="{{route('frontend.post.detail', $post->slug)}}">
					<div class="post-item">
						<div class="item-image">
							<img src="{{asset($post->image)}}" alt="{{$post->name}}">
						</div>
						<p class="item-name">{{$post->title}}</p>
						<div class="item-des">
							{!!$post->description!!}
						</div>
					</div>
				</a>
			</div>
			@endforeach
		</div>
	</div>
</section>
@endforeach		
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
  const swiper = new Swiper('.mySwiper', {
    effect: 'coverflow',
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: 'auto',
    coverflowEffect: {
      rotate: 30,
      stretch: 0,
      depth: 100,
      modifier: 2,
      slideShadows: true,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
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
        slidesPerView: 3,
        slidesPerGroup: 3,
        spaceBetween: 20,
        loopedSlides: 6,
        loopFillGroupWithBlank: true,
        speed: 600,
        breakpoints: {
          0: { slidesPerView: 1, slidesPerGroup: 1 },
          576: { slidesPerView: 2, slidesPerGroup: 2 },
          768: { slidesPerView: 3, slidesPerGroup: 3 },
          992: { slidesPerView: 3, slidesPerGroup: 3 }
        }
      });
    });
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.teamSlide').forEach(function (el) {
      new Swiper(el, {
        loop: true,
        initialSlide: 1,
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
        slidesPerView: 3,
        slidesPerGroup: 3,
        spaceBetween: 20,
        loopedSlides: 3,
        loopFillGroupWithBlank: true,
        speed: 600,
        breakpoints: {
          0: { slidesPerView: 1, slidesPerGroup: 1 },
          576: { slidesPerView: 2, slidesPerGroup: 2 },
          768: { slidesPerView: 3, slidesPerGroup: 3 },
          992: { slidesPerView: 3, slidesPerGroup: 3 }
        }
      });
    });
  });
</script>


<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
    // Custom rule kiểm tra số điện thoại Việt Nam
    $.validator.addMethod("phoneVN", function (value, element) {
        return this.optional(element) || /^(0[3|5|7|8|9])[0-9]{8}$|^\+84[3|5|7|8|9][0-9]{8}$/.test(value);
    }, "Số điện thoại không hợp lệ");

    $(document).ready(function () {
        $('#contact-form').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                phone: {
                    required: true,
                    phoneVN: true
                },
                email: {
                    email: true
                },
                content: {
                    maxlength: 1000
                }
            },
            messages: {
                name: {
                    required: "Vui lòng nhập họ và tên",
                    minlength: "Tên quá ngắn"
                },
                phone: {
                    required: "Vui lòng nhập số điện thoại",
                    phoneVN: "Số điện thoại không hợp lệ (ví dụ: 098xxxxxxx)"
                },
                email: {
                    email: "Email không hợp lệ"
                },
                content: {
                    maxlength: "Ý kiến không vượt quá 1000 ký tự"
                }
            },
            errorElement: 'small',
            errorClass: 'text-danger',
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>

@endpush