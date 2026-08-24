@if(count($items) > 0)
<nav aria-label="breadcrumb" class="breadcrumb-nav theme-{{ $theme }}">
    <ol class="breadcrumb-list" role="list" itemscope itemtype="https://schema.org/BreadcrumbList">
        @foreach($items as $index => $item)
        @php $isLast = $loop->last @endphp
        <li class="breadcrumb-item {{ $isLast ? 'active' : '' }}"
            itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            @if(!$isLast && !empty($item['url']))
                <a href="{{ $item['url'] }}" itemprop="item" class="breadcrumb-link">
                    <span itemprop="name">{{ $item['label'] }}</span>
                </a>
                <span class="breadcrumb-sep" aria-hidden="true">›</span>
            @else
                <span itemprop="name" aria-current="page">{{ $item['label'] }}</span>
            @endif
            <meta itemprop="position" content="{{ $index + 1 }}">
        </li>
        @endforeach
    </ol>
</nav>
@endif
