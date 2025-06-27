@extends('layouts.admin')
@section('title', 'Thêm dịch dự án')
@section('content_header', 'Thêm dịch dự án')

@section('content')
<div class="card">
    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <x-form.input type="text" name="name" label="Tên dự án" :value="old('name')" required />
            <x-form.category-select name="service_category_id" label="Danh mục" :options="$categories" :selected="old('parent_id', 0)" placeholder="-- Chọn danh mục --" required />
            <x-form.image-input name="image" label="Ảnh dự án" />
            <x-form.image-multi-input
                name="gallery"
                label="Thư viện ảnh chi tiết"
            />

            <x-form.image-input name="banner" label="Banner (tuỳ chọn)" />
            <x-form.textarea name="description" label="Mô tả ngắn" :value="old('description')" />
            <x-form.ckeditor name="content" label="Nội dung chi tiết" :value="old('content')" />
            <x-form.switch name="status" label="Trạng thái" :checked="old('status', true)" />
        </div>
        <div class="card-footer">
            <button type="submit" name="action" value="save" class="btn btn-primary">Lưu</button>
            <button type="submit" name="action" value="save_new" class="btn btn-secondary">Lưu và thêm mới</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-outline-dark">Quay lại</a>
        </div>
    </form>
</div>
@endsection
