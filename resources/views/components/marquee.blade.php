@props([
    'speed'  => 40,      // px/s — tốc độ scroll
    'gap'    => '2rem',  // khoảng cách giữa các items
    'repeat' => 3,       // số lần duplicate content để tạo loop liên tục
    'pauseOnHover' => true,
])
{{--
    x-marquee — Reusable infinite scroll ticker
    ─────────────────────────────────────────────
    Cách dùng:

    <x-marquee :speed="35" gap="1.5rem">
        <div class="marquee-item">
            <img src="..." alt="...">
            <span>Khuyến mại tháng 3: Giảm 20%</span>
        </div>
        ...
    </x-marquee>

    Hoặc dùng slot default với bất kỳ HTML nào.
    Component tự duplicate content để tạo infinite loop.
--}}
<div
    class="marquee-wrap{{ $pauseOnHover ? ' marquee-wrap--hoverable' : '' }}"
    style="--marquee-speed: {{ $speed }}; --marquee-gap: {{ $gap }}"
    aria-label="Thông tin khuyến mại"
    role="marquee"
    aria-live="off"
>
    <div class="marquee-track">
        {{-- Content lặp nhiều lần để tạo seamless loop --}}
        @for($i = 0; $i < $repeat; $i++)
        <div class="marquee-group" aria-hidden="{{ $i > 0 ? 'true' : 'false' }}">
            {{ $slot }}
        </div>
        @endfor
    </div>
</div>
