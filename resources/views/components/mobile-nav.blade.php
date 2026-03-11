<x-drawer id="mobile-nav" title="Menu">
    @if(isset($headerMenu) && $headerMenu?->menuItems->isNotEmpty())
        <nav aria-label="Menu di động">
            <ul class="drawer-nav" role="list">
                @foreach($headerMenu->menuItems as $item)
                    <li x-data="{ open: false }">
                        {{-- Item có children → accordion --}}
                        @if($item->children->isNotEmpty())
                            <button type="button"
                                    class="drawer-nav__item drawer-nav__item--parent"
                                    @click="open = !open"
                                    :aria-expanded="open">
                                <span>{{ $item->title }}</span>
                                <i class="fa-solid fa-chevron-down drawer-chevron"
                                   :class="{ 'rotate-180': open }"></i>
                            </button>
                            {{-- Level 2: service_categories --}}
                            <div class="drawer-subnav" x-show="open" x-collapse>
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
                                            {{-- Level 3: services --}}
                                            <ul class="drawer-subnav__list" x-show="openSub" x-collapse role="list">
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
                                            <a href="{{ $child->url ?: '#' }}"
                                               class="drawer-nav__item drawer-nav__item--sub"
                                               @if($child->target === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                                {{ $child->title }}
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <a href="{{ $item->url ?: '#' }}"
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
