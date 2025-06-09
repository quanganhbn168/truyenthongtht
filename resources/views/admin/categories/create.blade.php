@extends('layouts.admin')

@section('title', 'Thêm Danh mục mới')
@section('content_header', 'Thêm Danh mục mới')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm Danh mục mới</h3>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="form-horizontal">
        @csrf
        <div class="card-body">
            <x-form.input
                type="text"
                name="name"
                label="Tên Danh mục"
                :value="old('name')"
                required
            />

            <x-form.select
                name="parent_id"
                label="Danh mục cha"
                :options="$categories->pluck('name', 'id')"
                :selected="old('parent_id', 0)"
                placeholder="-- Danh mục cha --"
            />

            <x-form.filepond
                name="image"
                label="Ảnh chính"
                :value="old('image')"
                upload-folder="uploads/categories"
            />

            <x-form.filepond
                name="banner"
                label="Banner (tuỳ chọn)"
                :value="old('banner')"
                upload-folder="uploads/categories"
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
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark">Quay lại</a>
        </div>
    </form>
</div>
@endsection
