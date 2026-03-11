@props([
    'item',
])

@php
    /** @var \Datlechin\FilamentMenuBuilder\Models\MenuItem $item */

    $hasChildren = $item->children->isNotEmpty();
@endphp

<li
    wire:key="{{ $item->getKey() }}"
    data-sortable-item="{{ $item->getKey() }}"
    x-data="{ open: $persist(true).as('menu-item-' + @js($item->getKey())) }"
    class="fi-fo-repeater-item"
>
    <div class="fi-fo-repeater-item-header flex items-center min-w-0 pr-2">
        <div class="fi-fo-repeater-item-header-start-actions flex-shrink-0">
            <x-filament::icon-button
                icon="heroicon-m-arrows-up-down"
                color="gray"
                size="sm"
                data-sortable-handle
                class="fi-menu-builder-item-handle"
            />

            @if ($hasChildren)
                <x-filament::icon-button
                    icon="heroicon-o-chevron-right"
                    x-on:click="open = !open"
                    x-bind:title="open ? '{{ trans('filament-menu-builder::menu-builder.items.collapse') }}' : '{{ trans('filament-menu-builder::menu-builder.items.expand') }}'"
                    color="gray"
                    x-bind:class="{ 'rotate-90': open }"
                    class="transition duration-200"
                    size="sm"
                />
            @endif

            @if (\Datlechin\FilamentMenuBuilder\FilamentMenuBuilderPlugin::get()->isIndentActionsEnabled())
                <x-filament::icon-button
                    icon="heroicon-m-arrow-left"
                    color="gray"
                    size="sm"
                    wire:click="unindent({{ Js::from($item->getKey()) }})"
                />
                <x-filament::icon-button
                    icon="heroicon-m-arrow-right"
                    color="gray"
                    size="sm"
                    wire:click="indent({{ Js::from($item->getKey()) }})"
                />
            @endif
        </div>

        <div class="fi-fo-repeater-item-header-label fi-truncated fi-menu-builder-item-label flex-1 flex flex-col items-start justify-center min-w-0 px-2 truncate">
            <span class="flex items-center justify-start gap-1.5 w-full truncate text-left">
                @if ($item->icon)
                    <x-filament::icon :icon="$item->icon" class="fi-menu-builder-item-label-icon w-4 h-4 text-gray-500 shrink-0" />
                @endif
                <span class="font-medium text-sm truncate">{{ $item->resolveLocale($item->title) }}</span>
            </span>
            <span class="fi-truncated fi-menu-builder-item-url text-gray-400 text-xs truncate mt-0.5 text-left w-full">
                {{ $item->url }}
            </span>
        </div>

        <div class="fi-fo-repeater-item-header-end-actions flex-shrink-0 flex items-center gap-2">
            <x-filament::badge :color="$item->panel ? 'primary' : 'gray'" size="sm">
                {{ $item->type }}
            </x-filament::badge>
            <x-filament::icon-button
                icon="heroicon-m-pencil-square"
                size="sm"
                wire:click="mountAction('edit', {{ Js::from(['id' => $item->getKey(), 'title' => $item->resolveLocale($item->title)]) }})"
            />
            <x-filament::icon-button
                icon="heroicon-s-trash"
                color="danger"
                size="sm"
                wire:click="mountAction('delete', {{ Js::from(['id' => $item->getKey(), 'title' => $item->resolveLocale($item->title)]) }})"
            />
        </div>
    </div>

    @if ($hasChildren)
        <ul
            x-collapse
            x-show="open"
            wire:key="{{ $item->getKey() }}.children"
            x-data="menuBuilder({ parentId: @js($item->getKey()) })"
            class="fi-fo-repeater-items grid fi-menu-builder-item-children"
        >
            @foreach ($item->children as $child)
                <x-filament-menu-builder::menu-item :item="$child" />
            @endforeach
        </ul>
    @endif
</li>
