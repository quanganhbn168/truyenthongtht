@extends('layouts.admin')

@section('title', 'Cấu hình website')
@section('content_header', 'Cấu hình website')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-body">

            {{-- Tên website --}}
            <x-form.input
                name="site_name"
                label="Tên website"
                :value="old('site_name', setting('site_name'))"
                required
            />

            {{-- Địa chỉ --}}
            <x-form.input
                name="site_address"
                label="Địa chỉ"
                :value="old('site_address', setting('site_address'))"
            />

            {{-- Số điện thoại --}}
            <x-form.input
                name="site_phone"
                label="Số điện thoại"
                :value="old('site_phone', setting('site_phone'))"
            />

            {{-- Fanpage Facebook --}}
            <x-form.input
                name="facebook_page"
                label="Fanpage Facebook"
                :value="old('facebook_page', setting('facebook_page'))"
                type="url"
            />

            {{-- Link YouTube --}}
            <x-form.input
                name="youtube_channel"
                label="Kênh YouTube"
                :value="old('youtube_channel', setting('youtube_channel'))"
                type="url"
            />

            {{-- Logo --}}
            <x-form.filepond
                name="site_logo"
                label="Logo"
                :value="setting('site_logo')"
                uploadFolder="uploads/settings"
                uploadUrl="/admin/upload"
            />

            {{-- Favicon --}}
            <x-form.filepond
                name="site_favicon"
                label="Favicon"
                :value="setting('site_favicon')"
                uploadFolder="uploads/settings"
                uploadUrl="/admin/upload"
            />

        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Lưu thay đổi
            </button>
        </div>
    </div>
</form>
@endsection
