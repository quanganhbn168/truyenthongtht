@extends('layouts.admin')

@section('title', 'Chỉnh sửa Danh mục')
@section('content_header', 'Chỉnh sửa Danh mục')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Chỉnh sửa Danh mục</h3>
    </div>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="form-horizontal">
        @csrf
        @method('PUT')
        <div class="card-body">
            <x-form.input
                type="text"
                name="name"
                label="Tên Danh mục"
                :value="old('name', $category->name)"
                required
            />

            <x-form.select
                name="parent_id"
                label="Danh mục cha"
                :options="$categories->where('id', '!=', $category->id)->pluck('name', 'id')"
                :selected="old('parent_id', $category->parent_id)"
                placeholder="-- Danh mục cha --"
            />

            <x-form.filepond
                name="image"
                label="Ảnh chính"
                :value="old('image', $category->image)"
                upload-folder="uploads/categories"
            />

            <x-form.filepond
                name="banner"
                label="Banner (tuỳ chọn)"
                :value="old('banner', $category->banner)"
                upload-folder="uploads/categories"
                optional
            />

            <x-form.switch
                name="status"
                label="{{ $category->status == 1 ? 'Hiện' : 'Ẩn'}}"
                :value="old('status', $category->status)"
            />
        </div>

        <div class="card-footer">
            <button type="submit" name="action" value="save" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark">Quay lại</a>
        </div>
    </form>
</div>
@endsection
