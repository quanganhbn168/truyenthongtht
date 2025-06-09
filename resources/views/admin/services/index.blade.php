@extends('layouts.admin')
@section('title','Danh sách dịch vụ')
@section('content_header','Danh sách dịch vụ')
@section('content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Danh sách dịch vụ</h3>
		<div class="card-tools">
			<a href="{{route('admin.services.create')}}" class="btn btn-primary">
				<i class="far fa-plus"></i>
				Thêm dịch vụ mới
			</a>
		</div>
	</div>
</div>
@endsection