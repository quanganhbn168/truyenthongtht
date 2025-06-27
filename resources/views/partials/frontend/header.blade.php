<header id="header">
    <div class="header-wrapper text-center">
        <div class="container">
            <div class="header-top"></div>
            <div class="header-main d-flex justify-content-between align-items-center py-2 px-3">
                <!-- Logo -->
                <div class="header-logo flex-shrink-0">
                    <a href="/">
                        <img src="{{ asset($setting->logo) }}" alt="Logo">
                    </a>
                </div>
                <!-- Right section -->
                <!-- Main Nav PC -->
                <nav class="main-nav d-none d-lg-block">
                    <div class="nav-container">
                        <ul class="navbar-nav d-flex flex-row justify-content-center list-unstyled mb-0">
                            <li class="nav-item mx-3">
                                <a href="{{route("intro.show")}}" class="nav-link">Giới thiệu</a>
                            </li> @php $categoriesServiceMenu = DB::table("service_categories")->where("parent_id",0)->get(); @endphp @foreach($categoriesServiceMenu as $key => $cate) <li class="nav-item mx-3">
                                <a href="{{route("slug.resolve", $cate->slug)}}" class="nav-link">
                                    {{$cate->name}}
                                </a>
                            </li> @endforeach
                            @php
                            $postCategoryMenu = DB::table("post_categories")->where("parent_id",0)->get();
                            @endphp
                            @foreach($postCategoryMenu as $key => $postCategory)
                            <li class="nav-item mx-3">
                                <a href="{{route("slug.resolve", $postCategory->slug)}}" class="nav-link">{{$postCategory->name}}</a>
                            </li>
                            @endforeach
                            <li class="nav-item mx-3">
                                <a href="{{route('contact.show')}}" class="nav-link">Liên hệ</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Sidebar Mobile -->
    <div id="mobileSidebar" class="mobile-sidebar">
        <div class="mobile-sidebar-header d-flex justify-content-between align-items-center p-3 border-bottom">
            <h5 class="mb-0">Menu</h5>
            <button class="btn btn-sm close-sidebar">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="list-unstyled p-3">
            <li>
                <a href="/">Trang chủ</a>
            </li>
            <li>
                <a href="#">Giới thiệu</a>
            </li>
            <li>
                <a href="#">Thiết kế thi công</a>
            </li>
            <li>
                <a href="#">Kiến trúc</a>
            </li>
            <li>
                <a href="#">Tin tức</a>
            </li>
            <li>
                <a href="{{route('contact.show')}}">Liên hệ</a>
            </li>
            <li>
                <a href="#">Video</a>
            </li>
        </ul>
    </div>
    <div id="mobileSidebarOverlay" class="sidebar-overlay"></div>
</header>
<style>
    .mobile-sidebar {
        position: fixed;
        top: 0;
        left: -260px;
        width: 260px;
        height: 100%;
        background: #fff;
        z-index: 1050;
        overflow-y: auto;
        box-shadow: 2px 0 6px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .mobile-sidebar.show {
        left: 0;
    }

    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1040;
        display: none;
    }

    .sidebar-overlay.active {
        display: block;
    }

    .mobile-sidebar ul li a {
        display: block;
        padding: 10px 0;
        color: #333;
        border-bottom: 1px solid #eee;
        text-decoration: none;
    }
</style>