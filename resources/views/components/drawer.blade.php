@props([
    'id'    => 'drawer',
    'title' => 'Menu',
    'side'  => 'right',   // 'right' | 'left'
    'width' => '300px',
])
{{--
    x-drawer — Reusable Drawer/Offcanvas Component
    ──────────────────────────────────────────────
    Dùng:
        <x-drawer id="my-drawer" title="Menu" side="right">
            ... nội dung ...
        </x-drawer>

    Mở:  window.dispatchEvent(new CustomEvent('open-drawer', { detail: { id: 'my-drawer' } }))
    Đóng: window.dispatchEvent(new CustomEvent('close-drawer', { detail: { id: 'my-drawer' } }))

    Hoặc dùng button với @click:
        <button @click="$dispatch('open-drawer', { id: 'my-drawer' })">Mở</button>
--}}
<div
    x-data="{
        open: false,
        id: '{{ $id }}',
        init() {
            window.addEventListener('open-drawer',  e => { if (e.detail.id === this.id) this.openDrawer() });
            window.addEventListener('close-drawer', e => { if (e.detail.id === this.id) this.closeDrawer() });
        },
        openDrawer()  {
            this.open = true;
            document.body.style.overflow = 'hidden';
        },
        closeDrawer() {
            this.open = false;
            document.body.style.overflow = '';
        }
    }"
    @keydown.escape.window="closeDrawer()"
    id="{{ $id }}-wrapper"
>
    {{-- Backdrop --}}
    <div
        class="drawer-backdrop"
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="closeDrawer()"
        aria-hidden="true"
    ></div>

    {{-- Drawer panel --}}
    <div
        class="drawer-panel drawer-{{ $side }}"
        style="--drawer-width: {{ $width }}"
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="{{ $side === 'right' ? 'translate-x-full' : '-translate-x-full' }}"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="{{ $side === 'right' ? 'translate-x-full' : '-translate-x-full' }}"
        role="dialog"
        aria-modal="true"
        aria-label="{{ $title }}"
    >
        {{-- Header --}}
        <div class="drawer-header">
            <span class="drawer-title">{{ $title }}</span>
            <button
                type="button"
                class="drawer-close"
                @click="closeDrawer()"
                aria-label="Đóng menu"
            >
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- Body (slot) --}}
        <div class="drawer-body">
            {{ $slot }}
        </div>
    </div>
</div>
