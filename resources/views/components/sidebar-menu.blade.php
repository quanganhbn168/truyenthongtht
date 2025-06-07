@php
    $menu = config('menu');
@endphp

<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    @foreach ($menu as $item)
        @if (!empty($item['submenu']))
            @php
                $open = is_open_menu($item['submenu']) ? 'menu-open' : '';
                $active = is_open_menu($item['submenu']) ? 'active' : '';
            @endphp
            <li class="nav-item has-treeview {{ $open }}">
                <a href="#" class="nav-link {{ $active }}">
                    <i class="nav-icon {{ $item['icon'] }}"></i>
                    <p>
                        {{ $item['title'] }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach ($item['submenu'] as $sub)
                        <li class="nav-item">
                            <a href="{{ route($sub['route']) }}" class="nav-link {{ is_active_menu($sub['route']) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ $sub['title'] }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
            <li class="nav-item">
                <a
                    href="{{ $item['route'] ?? false ? route($item['route']) : ($item['url'] ?? '#') }}"
                    class="nav-link {{ isset($item['route']) ? is_active_menu($item['route']) : '' }}"
                >
                    <i class="nav-icon {{ $item['icon'] }}"></i>
                    <p>{{ $item['title'] }}</p>
                </a>
            </li>
        @endif
    @endforeach
</ul>
