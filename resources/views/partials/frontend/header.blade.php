<header id="header" class="{{ request()->is('/') ? 'header-home' : 'header-default' }}">
  <div class="header-wrapper">
    <div class="header-main d-flex justify-content-between align-items-center py-2 px-3">
      <!-- Logo -->
      <div class="header-logo flex-shrink-0">
        <a href="/">
          <img src="{{ asset('images/setting/THT-media-logo.png') }}" alt="Logo">
        </a>
      </div>

      <!-- Navigation -->
      <nav class="main-nav d-none d-lg-block flex-grow-1 ms-4 me-4">
        <ul class="navbar-nav d-flex flex-row justify-content-center list-unstyled mb-0">
          <li class="nav-item mx-2"><a href="{{ url('/gioi-thieu') }}" class="nav-link">Giới thiệu</a></li>
          <li class="nav-item mx-2"><a href="{{ url('/danh-muc') }}" class="nav-link">Danh mục</a></li>
          <li class="nav-item mx-2"><a href="{{ url('/tin-tuc') }}" class="nav-link">Blog</a></li>
          <li class="nav-item mx-2"><a href="{{ url('/lien-he') }}" class="nav-link">Liên hệ</a></li>
        </ul>
      </nav>

      <!-- Search Icon -->
      <div class="header-search-trigger">
        <button class="btn btn-search-toggle" type="button">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>

    <!-- Search Form (hidden by default) -->
    <div class="header-search d-none">
      <form action="/search" class="form-search d-flex justify-content-center py-3 px-3" method="GET">
        <input type="text" name="q" class="form-control" placeholder="Tìm kiếm...">
        <button type="submit" class="btn btn-outline-secondary ms-2">
          <i class="fas fa-search"></i>
        </button>
      </form>
    </div>
  </div>
</header>

@push('js')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.querySelector('.btn-search-toggle');
    const searchBox = document.querySelector('.header-search');
    toggleBtn.addEventListener('click', () => {
      searchBox.classList.toggle('d-none');
    });
  });
</script>
@endpush
