@props(['name', 'label', 'value' => '', 'required' => false, 'height' => 300])

@php
    $inputValue = old($name, $value);
    $editorId = Str::slug($name, '_') . '_' . uniqid(); // ID duy nhất
@endphp

<div class="form-group row">
    <label for="{{ $editorId }}" class="col-sm-2 col-form-label">
        {{ $label }} @if($required)<span class="text-danger">*</span>@endif
    </label>
    <div class="col-sm-10">
        <textarea
            name="{{ $name }}"
            id="{{ $editorId }}"
            class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}"
        >{!! $inputValue !!}</textarea>
        @error($name)
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>

@push('js')
<script>
    $(function () {
        $('#{{ $editorId }}').summernote({
            height: {{ $height }},
        });
    });
</script>
@endpush
