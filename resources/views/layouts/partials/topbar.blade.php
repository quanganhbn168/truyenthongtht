{{-- Topbar: Tagline + social/contact quick links --}}
<div id="topbar" aria-label="Thông tin nhanh">
    <div class="topbar-inner">
        <span class="topbar-tagline">
            {{ $siteTagline ?: 'Công ty truyền thông hàng đầu tại Bắc Ninh' }}
        </span>
        <div class="topbar-right">
            @if($workingHours)
            <span class="topbar-info">
                <i class="fa-regular fa-clock" aria-hidden="true"></i>
                {{ $workingHours }}
            </span>
            @endif
            @if($mainEmail)
            <a href="mailto:{{ $mainEmail }}" class="topbar-info topbar-link">
                <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                {{ $mainEmail }}
            </a>
            @endif
            @if($mainPhone)
            <a href="tel:{{ $mainPhone }}" class="topbar-info topbar-link topbar-phone">
                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                {{ $mainPhone }}
            </a>
            @endif
        </div>
    </div>
</div>
