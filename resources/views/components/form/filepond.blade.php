{{-- resources/views/components/form/filepond.blade.php --}}
@props([
    'name',
    'label',
    'value' => '',
    'required' => false,
    'uploadUrl' => '/admin/upload',
    'uploadFolder' => 'uploads/images',
    'multiple' => false,
])

@php
    $inputName = $multiple ? $name . '[]' : $name;
    $values = $multiple ? (is_array($value) ? $value : (empty($value) ? [] : [$value])) : [$value];
@endphp

<div class="form-group row">
    <label class="col-sm-2 col-form-label">
        {{ $label }} @if($required)<span class="text-danger">*</span>@endif
    </label>
    <div class="col-sm-10">
        <input
            type="file"
            name="{{ $inputName }}"
            id="{{ $name }}"
            class="filepond"
            data-max-file-size="5MB"
            {{ $multiple ? 'multiple' : '' }}
        >

        @if (!$multiple)
            <input type="hidden" name="{{ $name }}" id="{{ $name }}_hidden" value="{{ old($name, $value) }}">
        @endif

        @error($name)
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>

@push('js')
<script>
    FilePond.registerPlugin(
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview
    );

    FilePond.setOptions({
        server: {
            process: {
                url: '{{ $uploadUrl }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                withCredentials: false,
                ondata: (formData) => {
                    formData.append('folder', '{{ $uploadFolder }}');
                    formData.append('field', '{{ $name }}');
                    return formData;
                },
                onload: (res) => {
                    const result = JSON.parse(res);
                    @if (!$multiple)
                    document.getElementById('{{ $name }}_hidden').value = result.paths;
                    @endif
                    return result.paths;
                }
            }
        }
    });

    const pond = FilePond.create(document.getElementById('{{ $name }}'));

    @foreach ($values as $file)
        @if ($file)
        pond.addFile("{{ asset($file) }}")
            .then(() => console.log('Loaded file: {{ $file }}'));
        @endif
    @endforeach
</script>
@endpush
