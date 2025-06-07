{{-- resources/views/components/form/summernote.blade.php --}}
@props(['name', 'label', 'value' => '', 'required' => false])

@php $inputValue = old($name, $value); @endphp

<div class="form-group row">
    <label for="{{ $name }}" class="col-sm-2 col-form-label">
        {{ $label }} @if($required)<span class="text-danger">*</span>@endif
    </label>
    <div class="col-sm-10">
        <textarea
            name="{{ $name }}"
            id="{{ $name }}"
            class="form-control summernote{{ $errors->has($name) ? ' is-invalid' : '' }}"
        >{!! $inputValue !!}</textarea>
        @error($name)
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>