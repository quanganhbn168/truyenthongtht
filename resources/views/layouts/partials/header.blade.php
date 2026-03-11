<header id="site-header" role="banner"
    x-data="{
        megaOpen: null,
        closeTimer: null,
        scrolled: false,
        init() {
            this.scrolled = window.scrollY > 50;
        },
        openMega(id) {
            clearTimeout(this.closeTimer);
            this.megaOpen = id;
        },
        schedulClose() {
            this.closeTimer = setTimeout(() => { this.megaOpen = null; }, 120);
        }
    }"
    @scroll.window="scrolled = (window.scrollY > 50)"
    @keydown.escape="megaOpen = null"
    :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-sm py-1 lg:py-0 !top-0 nav-scrolled' : '{{ request()->routeIs('home') ? 'bg-transparent is-transparent-hero' : 'bg-white shadow-none' }} py-2 lg:py-3'"
    class="fixed w-full top-0 md:top-[36px] z-[999] transition-all duration-300"
>
    <div class="header-inner">

        {{-- Logo --}}
        <div class="header-logo">
            <a href="{{ url('/') }}" title="{{ $siteName }}" aria-label="Trang chủ {{ $siteName }}">
                <img src="{{ $logoUrl }}"
                     alt="{{ $siteName }}"
                     class="logo-dark"
                     width="160" height="60"
                     loading="eager"
                     onerror="this.style.display='none'">
                @if(isset($logoWhiteUrl))
                <img src="{{ $logoWhiteUrl }}"
                     alt="{{ $siteName }}"
                     class="logo-white"
                     width="160" height="60"
                     loading="eager"
                     onerror="this.style.display='none'">
                @endif
            </a>
        </div>

        {{-- Desktop Navigation --}}
        @if($headerMenu && $headerMenu->menuItems->isNotEmpty())
        <nav id="main-nav" role="navigation" aria-label="Menu chính">
            <ul class="nav-list" role="list">
                @foreach($headerMenu->menuItems as $item)
                @php
                    $hasMega    = str_contains($item->classes ?? '', 'mega') && $item->children->isNotEmpty();
                    $hasDropdown= !$hasMega && $item->children->isNotEmpty();
                    $itemId     = 'nav-item-' . $item->id;
                @endphp
                <li class="nav-item {{ $hasMega ? 'has-mega' : ($hasDropdown ? 'has-dropdown' : '') }}"
                    @if($hasMega || $hasDropdown)
                        @mouseenter="openMega('{{ $itemId }}')"
                        @mouseleave="schedulClose()"
                    @endif>

                    <a href="{{ (isset($item->url) && $item->url !== '#') ? (str_ends_with($item->url, '.html') || $item->url === '/' ? url($item->url) : url($item->url . '.html')) : '#' }}"
                       class="nav-link"
                       @if($item->target === '_blank') target="_blank" rel="noopener noreferrer" @endif
                       @if($hasMega || $hasDropdown) aria-haspopup="true" :aria-expanded="megaOpen === '{{ $itemId }}'" @endif>
                        {{ $item->title }}
                        @if($hasMega || $hasDropdown)
                            <i class="fa-solid fa-chevron-down nav-chevron"
                               :class="{ 'nav-chevron--up': megaOpen === '{{ $itemId }}' }"
                               aria-hidden="true"></i>
                        @endif
                    </a>

                    {{-- ── Mega Menu 2-panel ── --}}
                    @if($hasMega)
                    <div class="mega-panel"
                         x-show="megaOpen === '{{ $itemId }}'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-1"
                         @mouseenter="openMega('{{ $itemId }}')"
                         @mouseleave="schedulClose()"
                         x-data="{ activeCol: '{{ $item->children->first()?->id }}' }"
                         role="region"
                         aria-label="Menu dịch vụ">
                        <div class="mega-inner">
                            <div class="mega-2panel">
                                {{-- Left sidebar: Category list --}}
                                <nav class="mega-sidebar" aria-label="Danh mục dịch vụ">
                                    @foreach($item->children as $col)
                                    <button type="button"
                                            class="mega-sidebar__item"
                                            :class="{ 'mega-sidebar__item--active': activeCol === '{{ $col->id }}' }"
                                            @mouseenter="activeCol = '{{ $col->id }}'">
                                        <span>{{ $col->title }}</span>
                                        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                                    </button>
                                    @endforeach
                                </nav>

                                {{-- Right panel: Services of active category --}}
                                <div class="mega-services">
                                    @foreach($item->children as $col)
                                    <div x-show="activeCol === '{{ $col->id }}'">
                                        <div class="mega-services__header">
                                            <a href="{{ (isset($col->url) && $col->url !== '#') ? (str_ends_with($col->url, '.html') || $col->url === '/' ? url($col->url) : url($col->url . '.html')) : '#' }}" class="mega-services__cat-link"
                                               @if($col->target === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                                {{ $col->title }}
                                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        @if($col->children->isNotEmpty())
                                        <div class="mega-services__grid">
                                            @foreach($col->children as $leaf)
                                            <a href="{{ (isset($leaf->url) && $leaf->url !== '#') ? (str_ends_with($leaf->url, '.html') || $leaf->url === '/' ? url($leaf->url) : url($leaf->url . '.html')) : '#' }}" class="mega-service-card"
                                               @if($leaf->target === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                                <i class="fa-solid fa-angle-right mega-service-card__icon" aria-hidden="true"></i>
                                                <span>{{ $leaf->title }}</span>
                                            </a>
                                            @endforeach
                                        </div>
                                        @else
                                        <p class="mega-services__empty">Xem tất cả dịch vụ trong danh mục này.</p>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- ── Regular Dropdown ── --}}
                    @if($hasDropdown)
                    <ul class="dropdown-menu" role="list"
                        x-show="megaOpen === '{{ $itemId }}'"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        @mouseenter="openMega('{{ $itemId }}')"
                        @mouseleave="schedulClose()"
                        aria-label="Menu con {{ $item->title }}">
                        @foreach($item->children as $child)
                        <li class="dropdown-item">
                            <a href="{{ (isset($child->url) && $child->url !== '#') ? (str_ends_with($child->url, '.html') || $child->url === '/' ? url($child->url) : url($child->url . '.html')) : '#' }}" class="dropdown-link"
                               @if($child->target === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                {{ $child->title }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif

                </li>
                @endforeach
            </ul>
        </nav>
        @endif

        {{-- CTA & Hamburger --}}
        <div class="header-actions">
            <a href="tel:{{ $mainPhone }}"
               class="header-phone"
               aria-label="Gọi tư vấn ngay">
                <i class="fa-solid fa-phone-volume" aria-hidden="true"></i>
                Nhận tư vấn ngay
            </a>

            {{-- Hamburger → mở Drawer từ phải --}}
            <button type="button"
                    class="hamburger"
                    aria-label="Mở menu"
                    @click="$dispatch('open-drawer', { id: 'mobile-nav' })">
                <i class="fa-solid fa-bars" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</header>

@if(!request()->routeIs('home'))
<div id="header-spacer" aria-hidden="true"></div>
@endif

{{-- Mobile Drawer (từ phải) --}}
<x-drawer id="mobile-nav" title="THT Media" side="right" width="300px">
    @if($headerMenu && $headerMenu->menuItems->isNotEmpty())
        <nav aria-label="Menu di động">
            <ul class="drawer-nav" role="list">
                @foreach($headerMenu->menuItems as $item)
                    <li x-data="{ open: false }">
                        @if($item->children->isNotEmpty())
                            <button type="button"
                                    class="drawer-nav__item drawer-nav__item--parent"
                                    @click="open = !open"
                                    :aria-expanded="open">
                                <span>{{ $item->title }}</span>
                                <i class="fa-solid fa-chevron-down drawer-chevron"
                                   :class="{ 'rotate-180': open }"></i>
                            </button>
                            <div class="drawer-subnav" x-show="open"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0">
                                @foreach($item->children as $child)
                                    <div x-data="{ openSub: false }">
                                        @if($child->children->isNotEmpty())
                                            <button type="button"
                                                    class="drawer-nav__item drawer-nav__item--sub-parent"
                                                    @click="openSub = !openSub"
                                                    :aria-expanded="openSub">
                                                <span>{{ $child->title }}</span>
                                                <i class="fa-solid fa-chevron-right drawer-chevron-sm"
                                                   :class="{ 'rotate-90': openSub }"></i>
                                            </button>
                                            <ul class="drawer-subnav__list" x-show="openSub"
                                                x-transition:enter="transition ease-out duration-150"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                role="list">
                                                @foreach($child->children as $grandchild)
                                                    <li>
                                                        <a href="{{ $grandchild->url ?: '#' }}"
                                                           class="drawer-nav__item drawer-nav__item--child"
                                                           @if($grandchild->target === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                                            {{ $grandchild->title }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <a href="{{ (isset($child->url) && $child->url !== '#') ? (str_ends_with($child->url, '.html') || $child->url === '/' ? url($child->url) : url($child->url . '.html')) : '#' }}"
                                               class="drawer-nav__item drawer-nav__item--sub"
                                               @if($child->target === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                                {{ $child->title }}
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <a href="{{ (isset($item->url) && $item->url !== '#') ? (str_ends_with($item->url, '.html') || $item->url === '/' ? url($item->url) : url($item->url . '.html')) : '#' }}"
                               class="drawer-nav__item"
                               @if($item->target === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                {{ $item->title }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
    @endif
</x-drawer>
