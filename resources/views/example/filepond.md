@push('css')
<link href="{{ asset('vendor/filepond/filepond.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/filepond/plugins/filepond-plugin-image-preview.min.css') }}" rel="stylesheet">
@endpush

@push('js')
<script src="{{ asset('vendor/filepond/filepond.min.js') }}"></script>
<script src="{{ asset('vendor/filepond/plugins/filepond-plugin-image-preview.min.js') }}"></script>
<script src="{{ asset('vendor/filepond/plugins/filepond-plugin-file-validate-size.min.js') }}"></script>
<script src="{{ asset('vendor/filepond/plugins/filepond-plugin-file-validate-type.min.js') }}"></script>

<script>
    // Đăng ký plugin
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType
    );

    // Khởi tạo FilePond trên input
    FilePond.create(document.querySelector('.filepond'), {
        allowMultiple: false,
        maxFileSize: '5MB',
        acceptedFileTypes: ['image/*'],
        instantUpload: false, // Không upload lên server
        labelIdle: `Kéo thả hoặc <span class="filepond--label-action">Chọn ảnh</span>`
    });
</script>
@endpush
preview ảnh cũ
@push('js')
<script>
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType
    );

    const oldImage = @json(asset($product->image));

    const pond = FilePond.create(document.querySelector('.filepond'), {
        allowMultiple: false,
        maxFileSize: '5MB',
        acceptedFileTypes: ['image/*'],
        instantUpload: false,
        files: [
            {
                source: oldImage,
                options: {
                    type: 'local',
                }
            }
        ]
    });
</script>
@endpush


@php
$imageUrl = $product->image ? asset($product->image) : null;
@endphp

<script>
const imageUrl = @json($imageUrl);

if (imageUrl) {
    FilePond.create(document.querySelector('.filepond'), {
        files: [
            {
                source: imageUrl,
                options: {
                    type: 'local',
                }
            }
        ],
        // các config khác...
    });
} else {
    FilePond.create(document.querySelector('.filepond'), {
        // fallback nếu không có ảnh
    });
}
</script>
