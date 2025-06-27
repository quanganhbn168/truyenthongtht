@props([
    'name',
    'label' => '',
    'options' => [],
    'selected' => '',
    'required' => false,
    'placeholder' => '-- Chọn danh mục --',
])

@php
    $selected = old($name, $selected);

    // Build cây phân cấp từ danh sách phẳng
    $grouped = collect($options)->groupBy('parent_id');

    function buildTreeOptions($items, $grouped, $selected, $depth = 0) {
        $result = [];
        foreach ($items as $item) {
            $prefix = str_repeat('— ', $depth);
            $result[$item['id']] = $prefix . $item['name'];

            if ($grouped->has($item['id'])) {
                $children = buildTreeOptions($grouped[$item['id']], $grouped, $selected, $depth + 1);
                $result += $children;
            }
        }
        return $result;
    }

    $treeOptions = buildTreeOptions($grouped[0] ?? [], $grouped, $selected);
@endphp

<x-form.select
    :name="$name"
    :label="$label"
    :options="$treeOptions"
    :selected="$selected"
    :required="$required"
    :placeholder="$placeholder"
/>
