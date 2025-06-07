@extends('layouts.admin')

@section('title', 'Thêm slide mới')
@section('content_header', 'Thêm slide mới')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm slide mới</h3>
    </div>

    <form action="{{ route('admin.slides.store') }}" method="POST" class="form-horizontal">
        @csrf
        <div class="card-body">
            <x-form.input type="text" name="title" label="Tiêu đề slide" :value="old('title')" />

            <x-form.input type="text" name="link" label="Link" :value="old('link')" />

            <x-form.input type="number" name="sort_order" label="Thứ tự hiển thị" :value="old('sort_order', 0)" />

            <x-form.switch name="status" label="Trạng thái" :checked="old('status', true)" />

            <x-form.filepond
                name="image"
                label="Ảnh slide"
                :value="old('image')"
                upload-folder="uploads/slides"
            />
        </div>

        <div class="card-footer">
            <button type="submit" name="action" value="save" class="btn btn-primary">Lưu</button>
            <button type="submit" name="action" value="save_new" class="btn btn-secondary">Lưu và thêm mới</button>
            <a href="{{ route('admin.slides.index') }}" class="btn btn-outline-dark">Quay lại</a>
        </div>
    </form>
</div>
@endsection
