@props(['categories' => [], 'routeName' => 'admin.categories.edit'])

@php
    $grouped = collect($categories)->groupBy('parent_id');

    function renderTree($items, $grouped, $routeName, $depth = 0) {
        $html = '';
        foreach ($items as $item) {
            $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $depth);
            $icon = $depth === 0 ? '📁' : '📂';
            $url = route($routeName, $item['id']);
            $html .= "<div>{$indent}{$icon} <a href=\"{$url}\">{$item['name']}</a></div>";

            if ($grouped->has($item['id'])) {
                $html .= renderTree($grouped[$item['id']], $grouped, $routeName, $depth + 1);
            }
        }
        return $html;
    }

    $rootItems = $grouped[0] ?? [];
@endphp

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Cấu trúc danh mục</h3>
    </div>
    <div class="card-body">
        {!! renderTree($rootItems, $grouped, $routeName) !!}
    </div>
</div>
