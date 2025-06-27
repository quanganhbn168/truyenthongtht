<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khóa Học Tiếng Trung doanh nghiệp</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <meta name="description" content="@yield('meta_description', 'Trung tâm đào tạo tiếng Trung doanh nghiệp')">
    <meta name="keywords" content="@yield('meta_keywords', 'Tiếng Trung, Tiếng Trung doanh nghiệp, Tiếng Trung Ở Bắc Ninh, Tiếng Trung Quế Võ')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}" />

    {{-- Open Graph --}}
    <meta property="og:type"        content="@yield('og_type','website')" />
    <meta property="og:title"       content="@yield('title') | {{ config('app.name') }}" />
    <meta property="og:description" content="@yield('meta_description')" />
    <meta property="og:url"         content="{{ url()->current() }}" />
    <meta property="og:site_name"   content="{{ config('app.name') }}" />
    <meta property="og:image"       content="@yield('meta_image', asset('images/default-og.jpg'))" />

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image" />
    <meta name="twitter:title"       content="@yield('title') | {{ config('app.name') }}" />
    <meta name="twitter:description" content="@yield('meta_description')" />
    <meta name="twitter:image"       content="@yield('meta_image', asset('images/default-og.jpg'))" />
    {{-- Fonts, Favicons --}}
    <link rel="icon" href="{{ asset($setting->favicon) }}" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset($setting->favicon) }}" />
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>tailwind.config={theme:{extend:{colors:{primary:'#1e40af',secondary:'#F0F4F8'},borderRadius:{'none':'0px','sm':'4px',DEFAULT:'8px','md':'12px','lg':'16px','xl':'20px','2xl':'24px','3xl':'32px','full':'9999px','button':'8px'}}}}</script>
    <style>
        :where([class^="ri-"])::before { content: "\f3c2"; }
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
        }
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .custom-checkbox {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
        }
        .custom-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #fff;
            border: 2px solid #ddd;
            border-radius: 4px;
        }
        .custom-checkbox:hover input ~ .checkmark {
            border-color: #ccc;
        }
        .custom-checkbox input:checked ~ .checkmark {
            background-color: #FF9E9E;
            border-color: #FF9E9E;
        }
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }
        .custom-checkbox input:checked ~ .checkmark:after {
            display: block;
        }
        .custom-checkbox .checkmark:after {
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #FF9E9E;
        }
        input:checked + .slider:before {
            transform: translateX(26px);
        }
    </style>
</head>
<body class="bg-white">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{route('home')}}" class="text-2xl font-['Pacifico'] text-primary">
                <img src="{{asset($setting->logo)}}" alt="{{$setting->name}}" class="w-32">
            </a>
            <nav class="hidden md:flex space-x-8">
                <a href="#benefits" class="text-gray-700 hover:text-primary font-medium">Lợi ích</a>
                <a href="#program" class="text-gray-700 hover:text-primary font-medium">Chương trình</a>
                <a href="#methodology" class="text-gray-700 hover:text-primary font-medium">Phương pháp</a>
                <a href="#pricing" class="text-gray-700 hover:text-primary font-medium">Học phí</a>
            </nav>
            <div class="flex items-center space-x-4">
                <a href="#contact" class="hidden md:block px-6 py-2 bg-primary text-white font-medium !rounded-button whitespace-nowrap hover:bg-opacity-90 transition">Liên hệ ngay</a>
                <button class="md:hidden w-10 h-10 flex items-center justify-center text-gray-700">
                    <i class="ri-menu-line ri-lg"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div style="background-image: url('https://readdy.ai/api/search-image?query=A%20professional%20office%20setting%20in%20Vietnam%20with%20Asian%20business%20professionals%20in%20formal%20attire%20discussing%20business%20in%20a%20modern%20conference%20room.%20The%20left%20side%20of%20the%20image%20has%20a%20clean%20white%20gradient%20background%20that%20smoothly%20transitions%20to%20the%20office%20scene%20on%20the%20right.%20The%20image%20shows%20a%20diverse%20group%20of%20Vietnamese%20professionals%20looking%20confident%20and%20engaged%20in%20business%20communication.%20The%20scene%20conveys%20professionalism%2C%20business%20Chinese%20language%20learning%2C%20and%20corporate%20training%20environment.&width=1920&height=1080&seq=hero1&orientation=landscape');" class="w-full h-full bg-cover bg-center object-top"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/90 to-white/30"></div>
        </div>
        
        <div class="container mx-auto px-4 py-20 md:py-32 relative z-10">
            <div class="w-full max-w-2xl">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 text-gray-800">Tiếng Trung doanh nghiệp Chuyên Nghiệp</h1>
                <p class="text-lg md:text-xl text-gray-700 mb-8">Khóa học thiết kế riêng cho doanh nghiệp Việt Nam, giúp nhân viên của bạn giao tiếp hiệu quả với đối tác Trung Quốc.</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#contact" class="px-8 py-3 bg-primary text-white font-medium !rounded-button whitespace-nowrap hover:bg-opacity-90 transition text-center">Đăng ký học thử miễn phí</a>
                    <a href="#program" class="px-8 py-3 border border-gray-300 text-gray-700 font-medium !rounded-button whitespace-nowrap hover:bg-gray-50 transition text-center">Xem chương trình học</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="py-16 bg-secondary bg-opacity-30">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Lợi Ích Của Khóa Học</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Trang bị kỹ năng tiếng Trung doanh nghiệp thiết thực giúp doanh nghiệp của bạn mở rộng cơ hội kinh doanh</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 flex items-center justify-center bg-primary bg-opacity-10 rounded-full mb-4">
                        <i class="ri-discuss-line ri-xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Giao Tiếp Chuyên Nghiệp</h3>
                    <p class="text-gray-600">Tự tin đàm phán, thuyết trình và trao đổi email với đối tác Trung Quốc bằng ngôn ngữ chuyên ngành.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 flex items-center justify-center bg-primary bg-opacity-10 rounded-full mb-4">
                        <i class="ri-hand-coin-line ri-xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Tăng Cơ Hội Kinh Doanh</h3>
                    <p class="text-gray-600">Mở rộng thị trường, tìm kiếm đối tác và nhà cung cấp mới tại thị trường Trung Quốc rộng lớn.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 flex items-center justify-center bg-primary bg-opacity-10 rounded-full mb-4">
                        <i class="ri-customer-service-2-line ri-xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Hỗ Trợ Cá Nhân Hóa</h3>
                    <p class="text-gray-600">Chương trình học được thiết kế riêng theo nhu cầu và lĩnh vực kinh doanh cụ thể của doanh nghiệp.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 flex items-center justify-center bg-primary bg-opacity-10 rounded-full mb-4">
                        <i class="ri-global-line ri-xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Hiểu Văn Hóa Kinh Doanh</h3>
                    <p class="text-gray-600">Nắm vững phong tục, nghi thức và cách ứng xử trong môi trường kinh doanh Trung Quốc.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Overview -->
    <section id="program" class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Tổng Quan Chương Trình</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Khóa học được thiết kế theo module, giúp học viên tiến bộ từng bước và áp dụng ngay vào công việc</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 flex items-center justify-center bg-primary text-white rounded-full mr-3">
                            <span class="font-semibold">01</span>
                        </div>
                        <h3 class="text-xl font-semibold">Giao Tiếp Cơ Bản</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Làm quen với ngữ pháp và từ vựng cơ bản trong giao tiếp doanh nghiệp. Học cách chào hỏi, giới thiệu bản thân và công ty.</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="ri-time-line mr-2"></i>
                        <span>4 tuần</span>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 flex items-center justify-center bg-primary text-white rounded-full mr-3">
                            <span class="font-semibold">02</span>
                        </div>
                        <h3 class="text-xl font-semibold">Đàm Phán Kinh Doanh</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Học cách thảo luận về giá cả, điều khoản hợp đồng, thời gian giao hàng và các vấn đề doanh nghiệp quan trọng khác.</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="ri-time-line mr-2"></i>
                        <span>4 tuần</span>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 flex items-center justify-center bg-primary text-white rounded-full mr-3">
                            <span class="font-semibold">03</span>
                        </div>
                        <h3 class="text-xl font-semibold">Thuyết Trình & Báo Cáo</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Phát triển kỹ năng thuyết trình sản phẩm, dịch vụ và báo cáo kết quả kinh doanh bằng tiếng Trung chuyên nghiệp.</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="ri-time-line mr-2"></i>
                        <span>4 tuần</span>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 flex items-center justify-center bg-primary text-white rounded-full mr-3">
                            <span class="font-semibold">04</span>
                        </div>
                        <h3 class="text-xl font-semibold">Giao Tiếp Văn Bản</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Viết email, hợp đồng và tài liệu kinh doanh bằng tiếng Trung. Hiểu và phản hồi đúng cách các văn bản doanh nghiệp.</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="ri-time-line mr-2"></i>
                        <span>4 tuần</span>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 flex items-center justify-center bg-primary text-white rounded-full mr-3">
                            <span class="font-semibold">05</span>
                        </div>
                        <h3 class="text-xl font-semibold">Văn Hóa Kinh Doanh</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Hiểu sâu về phong tục, nghi thức và cách ứng xử trong môi trường kinh doanh Trung Quốc để tạo ấn tượng tốt.</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="ri-time-line mr-2"></i>
                        <span>4 tuần</span>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 flex items-center justify-center bg-primary text-white rounded-full mr-3">
                            <span class="font-semibold">06</span>
                        </div>
                        <h3 class="text-xl font-semibold">Từ Vựng Chuyên Ngành</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Học từ vựng chuyên ngành theo lĩnh vực kinh doanh cụ thể: sản xuất, xuất nhập khẩu, tài chính, công nghệ, v.v.</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="ri-time-line mr-2"></i>
                        <span>4 tuần</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Methodology & Team Section -->
    <section id="methodology" class="py-16 bg-secondary bg-opacity-30">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Methodology Column -->
                <div>
                    <h2 class="text-3xl font-bold mb-8">Phương Pháp Đào Tạo</h2>
                    <ul class="space-y-5">
                        <li class="flex">
                            <div class="w-8 h-8 flex items-center justify-center bg-primary bg-opacity-10 rounded-full mr-4 flex-shrink-0 mt-1">
                                <i class="ri-check-line text-primary"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-medium mb-2">Học Trực Tuyến Kết Hợp Trực Tiếp</h3>
                                <p class="text-gray-600">Kết hợp linh hoạt giữa các buổi học trực tuyến và trực tiếp, giúp học viên có thể học mọi lúc, mọi nơi mà vẫn đảm bảo chất lượng.</p>
                            </div>
                        </li>
                        <li class="flex">
                            <div class="w-8 h-8 flex items-center justify-center bg-primary bg-opacity-10 rounded-full mr-4 flex-shrink-0 mt-1">
                                <i class="ri-check-line text-primary"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-medium mb-2">Phương Pháp Tình Huống</h3>
                                <p class="text-gray-600">Học thông qua các tình huống thực tế trong kinh doanh, mô phỏng các cuộc đàm phán, hội nghị và giao dịch doanh nghiệp.</p>
                            </div>
                        </li>
                        <li class="flex">
                            <div class="w-8 h-8 flex items-center justify-center bg-primary bg-opacity-10 rounded-full mr-4 flex-shrink-0 mt-1">
                                <i class="ri-check-line text-primary"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-medium mb-2">Thực Hành Liên Tục</h3>
                                <p class="text-gray-600">70% thời gian học dành cho thực hành, đảm bảo học viên có thể áp dụng ngay những gì đã học vào công việc thực tế.</p>
                            </div>
                        </li>
                        <li class="flex">
                            <div class="w-8 h-8 flex items-center justify-center bg-primary bg-opacity-10 rounded-full mr-4 flex-shrink-0 mt-1">
                                <i class="ri-check-line text-primary"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-medium mb-2">Đánh Giá Định Kỳ</h3>
                                <p class="text-gray-600">Kiểm tra và đánh giá thường xuyên để theo dõi tiến độ học tập, điều chỉnh phương pháp giảng dạy phù hợp với từng học viên.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <!-- Team Column -->
                <div>
                    <h2 class="text-3xl font-bold mb-8">Đội Ngũ Giảng Viên</h2>
                    <div class="space-y-8">
                        <div class="flex items-start">
                            <div class="w-20 h-20 rounded-full overflow-hidden flex-shrink-0 mr-5">
                                <img src="https://readdy.ai/api/search-image?query=Professional%20Asian%20female%20teacher%20in%20her%2040s%20with%20glasses%20and%20a%20warm%20smile%2C%20wearing%20business%20attire%2C%20looking%20confident%20and%20approachable.%20She%20has%20short%20black%20hair%20and%20appears%20to%20be%20an%20experienced%20Chinese%20language%20instructor%20with%20a%20professional%20demeanor.%20The%20image%20has%20a%20clean%2C%20simple%20background%20suitable%20for%20a%20professional%20profile%20photo.&width=200&height=200&seq=teacher1&orientation=squarish" alt="Giảng viên Nguyễn Thị Minh Hương" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold mb-1">TS. Nguyễn Thị Minh Hương</h3>
                                <p class="text-primary font-medium mb-2">Giảng viên chính - Tiếng Trung doanh nghiệp</p>
                                <p class="text-gray-600 mb-3">Hơn 15 năm kinh nghiệm giảng dạy tiếng Trung cho doanh nghiệp. Tốt nghiệp Tiến sĩ Ngôn ngữ học tại Đại học Bắc Kinh. Từng làm việc tại các tập đoàn lớn của Trung Quốc.</p>
                                <div class="flex space-x-3">
                                    <a href="#" class="text-gray-500 hover:text-primary">
                                        <i class="ri-linkedin-fill"></i>
                                    </a>
                                    <a href="#" class="text-gray-500 hover:text-primary">
                                        <i class="ri-facebook-fill"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-20 h-20 rounded-full overflow-hidden flex-shrink-0 mr-5">
                                <img src="https://readdy.ai/api/search-image?query=Professional%20Asian%20male%20teacher%20in%20his%2030s%20with%20a%20confident%20expression%2C%20wearing%20business%20casual%20attire%20with%20a%20light%20blue%20shirt.%20He%20has%20short%20black%20hair%20and%20appears%20to%20be%20a%20knowledgeable%20Chinese%20language%20instructor%20with%20a%20modern%2C%20approachable%20style.%20The%20image%20has%20a%20clean%2C%20simple%20background%20suitable%20for%20a%20professional%20profile%20photo.&width=200&height=200&seq=teacher2&orientation=squarish" alt="Giảng viên Trần Đức Minh" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold mb-1">ThS. Trần Đức Minh</h3>
                                <p class="text-primary font-medium mb-2">Giảng viên - Văn hóa Kinh doanh Trung Quốc</p>
                                <p class="text-gray-600 mb-3">Chuyên gia về văn hóa kinh doanh Trung Quốc với 10 năm kinh nghiệm làm việc tại Thượng Hải. Thạc sĩ Quản trị Kinh doanh từ Đại học Phúc Đán, Thượng Hải.</p>
                                <div class="flex space-x-3">
                                    <a href="#" class="text-gray-500 hover:text-primary">
                                        <i class="ri-linkedin-fill"></i>
                                    </a>
                                    <a href="#" class="text-gray-500 hover:text-primary">
                                        <i class="ri-facebook-fill"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Học Viên Nói Gì Về Chúng Tôi</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Những phản hồi từ các học viên đã hoàn thành khóa học và áp dụng thành công vào công việc</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                            <img src="https://readdy.ai/api/search-image?query=Professional%20Vietnamese%20female%20business%20executive%20in%20her%2030s%20with%20long%20black%20hair%2C%20wearing%20a%20business%20suit%2C%20looking%20confident%20and%20successful.%20The%20image%20has%20a%20clean%2C%20simple%20background%20suitable%20for%20a%20professional%20testimonial%20photo.&width=100&height=100&seq=test1&orientation=squarish" alt="Nguyễn Thị Hồng Nhung" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-semibold">Nguyễn Thị Hồng Nhung</h4>
                            <p class="text-sm text-gray-500">Giám đốc Kinh doanh, Công ty TNHH Việt Thái</p>
                        </div>
                    </div>
                    <div class="mb-3 text-yellow-400 flex">
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                    </div>
                    <p class="text-gray-600 italic">"Sau 3 tháng học, tôi đã tự tin đàm phán với đối tác Trung Quốc mà không cần phiên dịch. Điều này giúp công ty tiết kiệm chi phí và đẩy nhanh quá trình đàm phán. Phương pháp giảng dạy thực tế và hiệu quả."</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                            <img src="https://readdy.ai/api/search-image?query=Professional%20Vietnamese%20male%20business%20executive%20in%20his%2040s%20with%20short%20black%20hair%20and%20glasses%2C%20wearing%20a%20business%20suit%2C%20looking%20confident%20and%20experienced.%20The%20image%20has%20a%20clean%2C%20simple%20background%20suitable%20for%20a%20professional%20testimonial%20photo.&width=100&height=100&seq=test2&orientation=squarish" alt="Phạm Văn Tuấn" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-semibold">Phạm Văn Tuấn</h4>
                            <p class="text-sm text-gray-500">Trưởng phòng XNK, Công ty CP doanh nghiệp Đông Á</p>
                        </div>
                    </div>
                    <div class="mb-3 text-yellow-400 flex">
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                    </div>
                    <p class="text-gray-600 italic">"Khóa học đã giúp tôi hiểu rõ văn hóa kinh doanh Trung Quốc, từ đó xây dựng mối quan hệ tốt hơn với đối tác. Đặc biệt, phần học về đàm phán giá cả đã giúp công ty tiết kiệm được khoảng 15% chi phí nhập khẩu."</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                            <img src="https://readdy.ai/api/search-image?query=Professional%20Vietnamese%20female%20marketing%20executive%20in%20her%20late%2020s%20with%20medium-length%20black%20hair%2C%20wearing%20business%20casual%20attire%2C%20looking%20modern%20and%20creative.%20The%20image%20has%20a%20clean%2C%20simple%20background%20suitable%20for%20a%20professional%20testimonial%20photo.&width=100&height=100&seq=test3&orientation=squarish" alt="Lê Thị Thanh Hà" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-semibold">Lê Thị Thanh Hà</h4>
                            <p class="text-sm text-gray-500">Chuyên viên Marketing, FPT Software</p>
                        </div>
                    </div>
                    <div class="mb-3 text-yellow-400 flex">
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-half-fill"></i>
                    </div>
                    <p class="text-gray-600 italic">"Giáo viên rất tận tâm và chuyên nghiệp. Tôi đặc biệt ấn tượng với phần học về cách viết email và tài liệu marketing bằng tiếng Trung. Giờ đây, tôi có thể tự tin giao tiếp với khách hàng Trung Quốc mà không cần trợ giúp."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Output Commitment Section -->
    <section class="py-16 bg-secondary bg-opacity-30">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Cam Kết Đầu Ra</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Chúng tôi cam kết về kết quả học tập cụ thể sau mỗi giai đoạn của khóa học</p>
            </div>
            
            <div class="relative">
                <div class="hidden md:block absolute left-1/2 top-0 bottom-0 w-1 bg-primary bg-opacity-30 -translate-x-1/2"></div>
                
                <div class="space-y-12 md:space-y-0">
                    <!-- 4 Weeks -->
                    <div class="md:grid md:grid-cols-2 md:gap-8 relative">
                        <div class="md:text-right md:pr-12">
                            <div class="hidden md:block absolute right-0 top-6 w-6 h-6 rounded-full bg-primary -translate-x-1/2 z-10"></div>
                            <h3 class="text-2xl font-bold mb-3 text-primary">Sau 4 tuần</h3>
                            <div class="bg-white p-6 rounded-lg shadow-sm inline-block">
                                <ul class="space-y-3 md:text-right">
                                    <li class="flex md:flex-row-reverse">
                                        <span class="md:ml-3 md:mr-0 mr-3">Giao tiếp cơ bản trong môi trường kinh doanh</span>
                                        <i class="ri-check-line text-primary"></i>
                                    </li>
                                    <li class="flex md:flex-row-reverse">
                                        <span class="md:ml-3 md:mr-0 mr-3">Hiểu và sử dụng được 200+ từ vựng doanh nghiệp</span>
                                        <i class="ri-check-line text-primary"></i>
                                    </li>
                                    <li class="flex md:flex-row-reverse">
                                        <span class="md:ml-3 md:mr-0 mr-3">Viết email đơn giản bằng tiếng Trung</span>
                                        <i class="ri-check-line text-primary"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="hidden md:block"></div>
                    </div>
                    
                    <!-- 8 Weeks -->
                    <div class="md:grid md:grid-cols-2 md:gap-8 relative">
                        <div class="hidden md:block"></div>
                        <div class="md:pl-12">
                            <div class="hidden md:block absolute left-0 top-6 w-6 h-6 rounded-full bg-primary translate-x-1/2 z-10"></div>
                            <h3 class="text-2xl font-bold mb-3 text-primary">Sau 8 tuần</h3>
                            <div class="bg-white p-6 rounded-lg shadow-sm inline-block">
                                <ul class="space-y-3">
                                    <li class="flex">
                                        <i class="ri-check-line text-primary mr-3"></i>
                                        <span>Đàm phán cơ bản về giá cả và điều khoản</span>
                                    </li>
                                    <li class="flex">
                                        <i class="ri-check-line text-primary mr-3"></i>
                                        <span>Thuyết trình ngắn về sản phẩm/dịch vụ</span>
                                    </li>
                                    <li class="flex">
                                        <i class="ri-check-line text-primary mr-3"></i>
                                        <span>Hiểu các tài liệu kinh doanh cơ bản</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 12 Weeks -->
                    <div class="md:grid md:grid-cols-2 md:gap-8 relative">
                        <div class="md:text-right md:pr-12">
                            <div class="hidden md:block absolute right-0 top-6 w-6 h-6 rounded-full bg-primary -translate-x-1/2 z-10"></div>
                            <h3 class="text-2xl font-bold mb-3 text-primary">Sau 12 tuần</h3>
                            <div class="bg-white p-6 rounded-lg shadow-sm inline-block">
                                <ul class="space-y-3 md:text-right">
                                    <li class="flex md:flex-row-reverse">
                                        <span class="md:ml-3 md:mr-0 mr-3">Đàm phán doanh nghiệp phức tạp</span>
                                        <i class="ri-check-line text-primary"></i>
                                    </li>
                                    <li class="flex md:flex-row-reverse">
                                        <span class="md:ml-3 md:mr-0 mr-3">Thuyết trình chuyên nghiệp về kế hoạch kinh doanh</span>
                                        <i class="ri-check-line text-primary"></i>
                                    </li>
                                    <li class="flex md:flex-row-reverse">
                                        <span class="md:ml-3 md:mr-0 mr-3">Soạn thảo hợp đồng và tài liệu doanh nghiệp</span>
                                        <i class="ri-check-line text-primary"></i>
                                    </li>
                                    <li class="flex md:flex-row-reverse">
                                        <span class="md:ml-3 md:mr-0 mr-3">Hiểu sâu về văn hóa kinh doanh Trung Quốc</span>
                                        <i class="ri-check-line text-primary"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="hidden md:block"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Học Phí & Ưu Đãi</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Lựa chọn gói học phù hợp với nhu cầu và ngân sách của doanh nghiệp</p>
            </div>
            
            <div class="flex flex-col md:flex-row justify-center gap-8 max-w-4xl mx-auto">
                <!-- Standard Plan -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition flex-1">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-2xl font-bold mb-2">Gói Tiêu Chuẩn</h3>
                        <p class="text-gray-600 mb-4">Dành cho cá nhân hoặc nhóm nhỏ</p>
                        <div class="flex items-end mb-4">
                            <span class="text-4xl font-bold">12.000.000</span>
                            <span class="text-gray-600 ml-2 mb-1">VNĐ/người</span>
                        </div>
                        <p class="text-sm text-gray-500">Thanh toán một lần cho khóa học 3 tháng</p>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-start">
                                <i class="ri-check-line text-primary mr-3 mt-1"></i>
                                <span>Truy cập đầy đủ 6 module học</span>
                            </li>
                            <li class="flex items-start">
                                <i class="ri-check-line text-primary mr-3 mt-1"></i>
                                <span>2 buổi học trực tuyến mỗi tuần (90 phút/buổi)</span>
                            </li>
                            <li class="flex items-start">
                                <i class="ri-check-line text-primary mr-3 mt-1"></i>
                                <span>Tài liệu học tập điện tử</span>
                            </li>
                            <li class="flex items-start">
                                <i class="ri-check-line text-primary mr-3 mt-1"></i>
                                <span>Hỗ trợ qua email</span>
                            </li>
                            <li class="flex items-start">
                                <i class="ri-check-line text-primary mr-3 mt-1"></i>
                                <span>Chứng chỉ hoàn thành khóa học</span>
                            </li>
                        </ul>
                        <a href="#register" class="block text-center py-3 px-6 border border-primary text-primary font-medium !rounded-button whitespace-nowrap hover:bg-primary hover:text-white transition">Đăng ký ngay</a>
                    </div>
                </div>
                
                <!-- Premium Plan -->
                <div class="bg-white rounded-lg border-2 border-primary shadow-md hover:shadow-lg transition flex-1 relative">
                    <div class="absolute -top-4 right-6 bg-primary text-white px-4 py-1 rounded-full text-sm font-medium">
                        Phổ biến nhất
                    </div>
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-2xl font-bold mb-2">Gói Doanh Nghiệp</h3>
                        <p class="text-gray-600 mb-4">Dành cho nhóm từ 5 người trở lên</p>
                        <div class="flex items-end mb-4">
                            <span class="text-4xl font-bold">10.200.000</span>
                            <span class="text-gray-600 ml-2 mb-1">VNĐ/người</span>
                        </div>
                        <div class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                            Tiết kiệm 15%
                        </div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-start">
                                <i class="ri-check-line text-primary mr-3 mt-1"></i>
                                <span>Tất cả tính năng của gói Tiêu chuẩn</span>
                            </li>
                            <li class="flex items-start">
                                <i class="ri-check-line text-primary mr-3 mt-1"></i>
                                <span>Điều chỉnh nội dung theo ngành nghề</span>
                            </li>
                            <li class="flex items-start">
                                <i class="ri-check-line text-primary mr-3 mt-1"></i>
                                <span>1 buổi học trực tiếp mỗi tháng</span>
                            </li>
                            <li class="flex items-start">
                                <i class="ri-check-line text-primary mr-3 mt-1"></i>
                                <span>Hỗ trợ 1-1 qua Zalo/Wechat</span>
                            </li>
                            <li class="flex items-start">
                                <i class="ri-check-line text-primary mr-3 mt-1"></i>
                                <span>Báo cáo tiến độ học tập hàng tháng</span>
                            </li>
                            <li class="flex items-start">
                                <i class="ri-check-line text-primary mr-3 mt-1"></i>
                                <span>Tài liệu học tập bản in</span>
                            </li>
                        </ul>
                        <a href="#register" class="block text-center py-3 px-6 bg-primary text-white font-medium !rounded-button whitespace-nowrap hover:bg-opacity-90 transition">Đăng ký ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section id="contact" class="py-16 bg-primary bg-opacity-10">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Sẵn Sàng Nâng Cao Kỹ Năng Tiếng Trung doanh nghiệp?</h2>
                <p class="text-gray-600 text-lg">Đăng ký ngay hôm nay để nhận tư vấn miễn phí và bắt đầu hành trình phát triển sự nghiệp cùng chúng tôi</p>
            </div>
            
            <div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-8">
                <form id="contactForm" action="{{route("contact.store")}}" class="space-y-6" method="POST">
                    @csrf
                    <div>
                        <label for="name" class="block text-gray-700 font-medium mb-2">Họ và tên</label>
                        <input type="text" name="name" id="name" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Nhập họ và tên của bạn">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" name="email" id="email" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Nhập địa chỉ email của bạn">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-gray-700 font-medium mb-2">Số điện thoại</label>
                        <input type="tel" name="phone" id="phone" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Nhập số điện thoại của bạn">
                    </div>
                    
                    <div>
                        <label for="company" class="block text-gray-700 font-medium mb-2">Công ty (không bắt buộc)</label>
                        <input type="text" id="company" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Nhập tên công ty của bạn">
                    </div>
                    
                    <div>
                        <label class="custom-checkbox">
                            <input type="checkbox" checked>
                            <span class="checkmark"></span>
                            <span class="ml-2">Tôi đồng ý nhận thông tin về khóa học qua email</span>
                        </label>
                    </div>
                    
                    <button type="submit" class="w-full py-3 px-6 bg-primary text-white font-medium !rounded-button whitespace-nowrap hover:bg-opacity-90 transition">Nhận tư vấn miễn phí</button>
                </form>
                
                <p class="text-sm text-gray-500 mt-6 text-center">Thông tin của bạn sẽ được bảo mật theo <a href="#" class="text-primary hover:underline">Chính sách bảo mật</a> của chúng tôi</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <a href="{{route("home")}}" class="text-2xl font-['Pacifico'] text-white mb-4 block">
                        <img src="{{asset($setting->logo)}}" alt="{{$setting->name}}" class="w-32">
                    </a>
                    <p class="text-gray-400 mb-6">Chuyên cung cấp các khóa học tiếng Trung doanh nghiệp chất lượng cao cho doanh nghiệp Việt Nam.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-8 h-8 flex items-center justify-center bg-gray-700 rounded-full hover:bg-primary transition">
                            <i class="ri-facebook-fill"></i>
                        </a>
                        <a href="#" class="w-8 h-8 flex items-center justify-center bg-gray-700 rounded-full hover:bg-primary transition">
                            <i class="ri-linkedin-fill"></i>
                        </a>
                        <a href="#" class="w-8 h-8 flex items-center justify-center bg-gray-700 rounded-full hover:bg-primary transition">
                            <i class="ri-youtube-fill"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Khóa học</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Tiếng Trung doanh nghiệp cơ bản</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Tiếng Trung đàm phán</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Tiếng Trung thuyết trình</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Văn hóa kinh doanh Trung Quốc</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liên kết</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Về chúng tôi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Đội ngũ giảng viên</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Đối tác</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Blog</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liên hệ</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="ri-map-pin-line mr-3 mt-1"></i>
                            <span class="text-gray-400">{{$setting->address}}</span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-phone-line mr-3 mt-1"></i>
                            <span class="text-gray-400">{{$setting->phone}}</span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-mail-line mr-3 mt-1"></i>
                            <span class="text-gray-400">{{$setting->email}}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-10 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm mb-4 md:mb-0">© 2025 Tiếng Trung doanh nghiệp. Tất cả quyền được bảo lưu.</p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition">Điều khoản sử dụng</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition">Chính sách bảo mật</a>
                </div>
            </div>
        </div>
    </footer>

    <script id="formHandler">
        document.addEventListener('DOMContentLoaded', function() {
            const contactForm = document.getElementById('contactForm');
            
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const name = document.getElementById('name').value;
                    const email = document.getElementById('email').value;
                    const phone = document.getElementById('phone').value;
                    
                    if (!name || !email || !phone) {
                        alert('Vui lòng điền đầy đủ thông tin bắt buộc');
                        return;
                    }
                    
                    // Here you would normally send the form data to a server
                    // For demo purposes, we'll just show a success message
                    alert('Cảm ơn bạn đã đăng ký! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.');
                    contactForm.reset();
                });
            }
        });
    </script>

    <script id="mobileMenu">
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('.md\\:hidden');
            const mobileMenu = document.createElement('div');
            mobileMenu.className = 'fixed inset-0 bg-gray-800 bg-opacity-95 z-50 flex flex-col items-center justify-center transform transition-transform duration-300 translate-x-full';
            mobileMenu.innerHTML = `
                <button class="absolute top-4 right-4 text-white w-10 h-10 flex items-center justify-center">
                    <i class="ri-close-line ri-2x"></i>
                </button>
                <nav class="flex flex-col space-y-6 text-center">
                    <a href="#benefits" class="text-white text-xl font-medium">Lợi ích</a>
                    <a href="#program" class="text-white text-xl font-medium">Chương trình</a>
                    <a href="#methodology" class="text-white text-xl font-medium">Phương pháp</a>
                    <a href="#pricing" class="text-white text-xl font-medium">Học phí</a>
                    <a href="#contact" class="mt-4 px-8 py-3 bg-primary text-white font-medium !rounded-button whitespace-nowrap">Liên hệ ngay</a>
                </nav>
            `;
            document.body.appendChild(mobileMenu);
            
            menuButton.addEventListener('click', function() {
                mobileMenu.classList.remove('translate-x-full');
            });
            
            const closeButton = mobileMenu.querySelector('button');
            closeButton.addEventListener('click', function() {
                mobileMenu.classList.add('translate-x-full');
            });
            
            const mobileLinks = mobileMenu.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('translate-x-full');
                });
            });
        });
    </script>
</body>
</html>