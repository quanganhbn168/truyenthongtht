<header id="header" class="has-sticky">
  <div class="header-wrapper">
    <div class="header-main d-flex justify-content-between align-items-center py-2 px-3">
      <!-- Logo -->
      <div class="header-logo flex-shrink-0">
        <a href="/">
          <img src="{{ asset('images/setting/THT-media-logo.png') }}" alt="Logo">
        </a>
      </div>

      <!-- Search -->
      <div class="header-search d-md-block flex-grow-1 ms-3">
        <form action="/search" class="form-search d-flex" method="GET">
          <input type="text" class="form-control" placeholder="Tìm kiếm...">
          <button type="submit" class="btn btn-outline-secondary ms-2">
            <i class="fas fa-search"></i>
          </button>
        </form>
      </div>

      <!-- Right section -->
      <div class="header-right d-flex align-items-center">
        <!-- Icon menu PC -->
        <ul class="nav-icons d-none d-lg-flex list-unstyled mb-0">
          <li class="nav-icon me-3">
            <a href="#">
              <img src="{{ asset('images/setting/chung-cu.png') }}" alt="Chung cư">
              <span>Nội thất nhà phố</span>
            </a>
          </li>
          <li class="nav-icon me-3">
            <a href="#">
              <img src="{{ asset('images/setting/phong-ngu.png') }}" alt="Phòng ngủ">
              <span>Phòng ngủ</span>
            </a>
          </li>
          <li class="nav-icon me-3">
            <a href="#">
              <img src="{{ asset('images/setting/tu-bep.png') }}" alt="Tủ bếp">
              <span>Tủ bếp</span>
            </a>
          </li>
          <li class="nav-icon me-3">
            <a href="#">
              <img src="{{ asset('images/setting/giuong-tang.png') }}" alt="Giường tầng">
              <span>Giường tầng</span>
            </a>
          </li>
        </ul>

        <!-- Toggle Sidebar (mobile) -->
        <button class="btn d-lg-none toggle-sidebar" type="button">
          <i class="fas fa-bars fs-4"></i>
        </button>
      </div>
    </div>

    <!-- Main Nav PC -->
    <nav class="main-nav d-none d-lg-block">
      <div class="nav-container">
        <ul class="navbar-nav d-flex flex-row justify-content-center list-unstyled mb-0">
          <li class="nav-item mx-3"><a href="/" class="nav-link">Trang chủ</a></li>
          <li class="nav-item mx-3"><a href="#" class="nav-link">Giới thiệu</a></li>
          <li class="nav-item mx-3"><a href="#" class="nav-link">Thiết kế thi công</a></li>
          <li class="nav-item mx-3"><a href="#" class="nav-link">Kiến trúc</a></li>
          <li class="nav-item mx-3"><a href="#" class="nav-link">Tin tức</a></li>
          <li class="nav-item mx-3"><a href="#" class="nav-link">Liên hệ</a></li>
          <li class="nav-item mx-3"><a href="#" class="nav-link">Video</a></li>
        </ul>
      </div>
    </nav>
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
      <li><a href="/">Trang chủ</a></li>
      <li><a href="#">Giới thiệu</a></li>
      <li><a href="#">Thiết kế thi công</a></li>
      <li><a href="#">Kiến trúc</a></li>
      <li><a href="#">Tin tức</a></li>
      <li><a href="#">Liên hệ</a></li>
      <li><a href="#">Video</a></li>
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
    box-shadow: 2px 0 6px rgba(0,0,0,0.2);
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
    background: rgba(0,0,0,0.4);
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
