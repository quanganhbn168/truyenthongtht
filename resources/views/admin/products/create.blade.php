@extends('layouts.admin')

@section('title', 'Thêm Sản phẩm mới')
@section('content_header', 'Thêm Sản phẩm mới')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm Sản phẩm mới</h3>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" class="form-horizontal">
        @csrf
        <div class="card-body">
            <x-form.input
                type="text"
                name="name"
                label="Tên sản phẩm"
                :value="old('name')"
                required
            />

            <x-form.select
                name="category_id"
                label="Danh mục"
                :options="$categories->pluck('name', 'id')"
                :selected="old('category_id')"
                placeholder="-- Chọn danh mục --"
            />

            <x-form.input
                type="number"
                step="0.01"
                name="price"
                label="Giá bán"
                :value="old('price')"
                required
            />

            <x-form.input
                type="number"
                step="0.01"
                name="price_discount"
                label="Giá khuyến mãi"
                :value="old('price_discount')"
            />

            <x-form.textarea
                name="description"
                label="Mô tả ngắn"
                :value="old('description')"
            />

            <x-form.summernote
                name="content"
                label="Nội dung chi tiết"
                :value="old('content')"
            />

            <x-form.filepond
                name="image"
                label="Ảnh đại diện"
                :value="old('image')"
                upload-folder="uploads/products"
            />

            <x-form.filepond
                name="banner"
                label="Banner (tuỳ chọn)"
                :value="old('banner')"
                upload-folder="uploads/products"
                optional
            />

            <x-form.switch
                name="status"
                label="Kích hoạt"
                :checked="old('status', true)"
            />
        </div>

        <div class="card-footer">
            <button type="submit" name="action" value="save" class="btn btn-primary">Lưu</button>
            <button type="submit" name="action" value="save_new" class="btn btn-secondary">Lưu và thêm mới</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark">Quay lại</a>
        </div>
    </form>
</div>
@endsection
