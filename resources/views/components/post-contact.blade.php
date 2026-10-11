@php
    $companyName = $business->company_name ?: config('app.name');

    $phones = collect($business->phones ?? [])
        ->map(fn ($phone) => is_array($phone) ? ($phone['number'] ?? null) : null)
        ->filter()
        ->values();

    if ($phones->isEmpty()) {
        $phones = collect([$business->main_phone, $business->main_phone_2])->filter()->values();
    }

    $secondary = collect($branches ?? [])->filter(fn ($branch) => filled($branch->address ?? null) && ! ($branch->is_main ?? false));
@endphp

<aside class="post-contact mt-10 rounded-xl border border-orange-200 bg-orange-50/60 p-5 md:p-6 not-prose" aria-label="Thông tin liên hệ">
    <p class="text-base font-bold text-gray-900 mb-3">
        <i class="fa-solid fa-circle-info text-orange-700 mr-2" aria-hidden="true"></i>Liên hệ {{ $companyName }}
    </p>

    <ul class="space-y-2 text-sm text-gray-700">
        @if($business->main_address)
            <li class="flex gap-3">
                <i class="fa-solid fa-location-dot text-orange-700 mt-1 w-4 shrink-0" aria-hidden="true"></i>
                <span>{{ $business->main_address }}</span>
            </li>
        @endif

        @foreach($secondary as $branch)
            <li class="flex gap-3">
                <i class="fa-solid fa-building text-orange-700 mt-1 w-4 shrink-0" aria-hidden="true"></i>
                <span>{{ $branch->name }}: {{ $branch->address }}</span>
            </li>
        @endforeach

        @foreach($phones as $phone)
            <li class="flex gap-3">
                <i class="fa-solid fa-phone text-orange-700 mt-1 w-4 shrink-0" aria-hidden="true"></i>
                <a href="tel:{{ preg_replace('/\D+/', '', $phone) }}" class="font-semibold hover:text-orange-700">{{ $phone }}</a>
            </li>
        @endforeach

        @if($business->main_email)
            <li class="flex gap-3">
                <i class="fa-solid fa-envelope text-orange-700 mt-1 w-4 shrink-0" aria-hidden="true"></i>
                <a href="mailto:{{ $business->main_email }}" class="hover:text-orange-700">{{ $business->main_email }}</a>
            </li>
        @endif

        <li class="flex gap-3">
            <i class="fa-solid fa-globe text-orange-700 mt-1 w-4 shrink-0" aria-hidden="true"></i>
            <a href="{{ url('/') }}" class="hover:text-orange-700">{{ parse_url(url('/'), PHP_URL_HOST) }}</a>
        </li>

        @if(!empty($web->facebook_url))
            <li class="flex gap-3">
                <i class="fa-brands fa-facebook text-orange-700 mt-1 w-4 shrink-0" aria-hidden="true"></i>
                <a href="{{ $web->facebook_url }}" target="_blank" rel="noopener" class="hover:text-orange-700">Fanpage {{ $business->company_short_name ?: $companyName }}</a>
            </li>
        @endif
    </ul>
</aside>
