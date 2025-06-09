@props([
    'name',
    'label' => '',
    'value' => '',
    'config' => [],
])

@php
    $editorId = Str::slug($name, '_') . '_' . uniqid();
@endphp

<div class="mb-3">
    @if ($label)
        <label for="{{ $editorId }}" class="form-label">{{ $label }}</label>
    @endif

    <textarea name="{{ $name }}" id="{{ $editorId }}" class="form-control">{{ old($name, $value) }}</textarea>

    @error($name)
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

@push('js')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
    <script>
        CKEDITOR.replace('{{ $editorId }}', {
            filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
            filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            height: 300,
            ...@json($config)
        });
    </script>
@endpush
