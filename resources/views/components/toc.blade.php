@if(count($headings))

@if($placement === 'mobile')
{{-- Mobile: collapsible details/summary, hiện trong bài trước content --}}
<details class="group rounded-xl border border-gray-200 bg-white mb-6 overflow-hidden">
    <summary class="flex items-center justify-between px-4 py-3 cursor-pointer select-none list-none
                    font-semibold text-sm text-gray-800 hover:bg-gray-50 transition-colors">
        <span class="flex items-center gap-2">
            <i class="fa-solid fa-list-ul text-red-700 text-xs"></i>
            {{ $title }}
        </span>
        <i class="fa-solid fa-chevron-down text-gray-400 text-xs transition-transform duration-200
                  group-open:rotate-180"></i>
    </summary>
    <div class="border-t border-gray-100 px-4 py-3">
        <ol class="space-y-0.5">
            @foreach($headings as $h)
            <li class="{{ $h['level'] === 1 ? '' : ($h['level'] === 2 ? 'pl-3' : 'pl-6') }}">
                <a href="#{{ $h['id'] }}"
                   class="block px-2 py-1.5 rounded text-sm text-gray-600 hover:text-red-700 hover:bg-red-50
                          transition-colors no-underline"
                   onclick="this.closest('details').removeAttribute('open')">
                    {{ $h['text'] }}
                </a>
            </li>
            @endforeach
        </ol>
    </div>
</details>

@else
{{-- Desktop: sticky sidebar widget với active highlight --}}
<div class="bg-white rounded-2xl shadow-sm p-6">
    <h2 class="text-sm font-bold text-gray-900 pb-3 border-b-2 border-red-700 mb-4 flex items-center gap-2">
        <i class="fa-solid fa-list-ul text-red-700 text-xs"></i>
        {{ $title }}
    </h2>
    <nav id="toc-nav">
        <ol class="space-y-0.5">
            @foreach($headings as $h)
            <li class="{{ $h['level'] === 1 ? '' : ($h['level'] === 2 ? 'pl-3' : 'pl-6') }}">
                <a href="#{{ $h['id'] }}"
                   data-toc-id="{{ $h['id'] }}"
                   class="toc-nav-link block px-2 py-1.5 rounded text-sm text-gray-500
                          border-l-2 border-transparent
                          hover:text-red-700 hover:bg-red-50 hover:border-red-700
                          transition-all no-underline">
                    {{ $h['text'] }}
                </a>
            </li>
            @endforeach
        </ol>
    </nav>
</div>

@push('scripts')
<script>
(function () {
    const links = document.querySelectorAll('#toc-nav .toc-nav-link');
    if (!links.length) return;
    const ids = [...links].map(l => l.dataset.tocId);

    function activate(id) {
        links.forEach(l => {
            const active = l.dataset.tocId === id;
            l.classList.toggle('text-red-700',   active);
            l.classList.toggle('bg-red-50',       active);
            l.classList.toggle('border-red-700',  active);
            l.classList.toggle('font-semibold',   active);
            l.classList.toggle('text-gray-500',  !active);
            l.classList.toggle('border-transparent', !active);
        });
    }

    function onScroll() {
        let current = ids[0];
        for (const id of ids) {
            const el = document.getElementById(id);
            if (el && el.getBoundingClientRect().top <= 120) current = id;
        }
        activate(current);
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
})();
</script>
@endpush
@endif

@endif