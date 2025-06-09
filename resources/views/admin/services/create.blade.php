@extends('layouts.admin')
@section('title','Thêm mới dịch vụ')
@section('content_header','Thêm mới dịch vụ')
@section('content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Thêm mới dịch vụ</h3>
	</div>
	<form method="POST" action="{{route('admin.services.store')}}">
		@csrf
		<div class="card-body">
			<x-form.input name="name" label="Tên dịch vụ"/>
			<x-form.summernote
				name="description"
				label="Mô tả bài viết"
				:required="true"
			/>
		</div>
	</form>
</div>
@endsection