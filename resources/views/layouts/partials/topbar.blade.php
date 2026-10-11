{{-- Topbar: Tagline + social/contact quick links --}}
@php
    $contactPhones = collect($business->phones ?? [])
        ->filter(fn ($phone) => is_array($phone) && filled($phone['number'] ?? null))
        ->values();

    if ($contactPhones->isEmpty()) {
        $contactPhones = collect([
            ['number' => $business->main_phone],
            ['number' => $business->main_phone_2],
        ])->filter(fn ($phone) => filled($phone['number'] ?? null))->values();
    }

    if ($contactPhones->isEmpty()) {
        $contactPhones = collect($branches ?? [])
            ->filter(fn ($branch) => filled($branch->phone ?? null))
            ->map(fn ($branch) => ['number' => $branch->phone])
            ->values();
    }
@endphp
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
            @foreach($contactPhones as $phone)
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone['number']) }}" class="topbar-info topbar-link topbar-phone">
                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                {{ $phone['number'] }}
            </a>
            @endforeach
        </div>
    </div>
</div>
