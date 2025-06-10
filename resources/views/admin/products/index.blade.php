@extends('layouts.admin')
@section('title','Quản lý sản phẩm')
@section('content_header','Danh sách sản phẩm')

@section('content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title"></h3>
		<div class="card-tools">
			<a href="{{ route('admin.products.create') }}" class="btn btn-primary">
				<i class="fas fa-plus"></i> Thêm sản phẩm
			</a>
		</div>
	</div>
	<div class="card-body table-responsive p-0">
		<table class="table table-hover text-nowrap">
			<thead>
				<tr>
					<th>#</th>
					<th>Ảnh</th>
					<th>Tên sản phẩm</th>
					<th>Trạng thái</th>
					<th>Thao tác</th>
				</tr>
			</thead>
			<tbody>
				@foreach($products as $key => $product)
				<tr>
					<td>{{ $key + 1 }}</td>
					<td>
						<img src="{{ asset($product->image) }}" alt="product" style="height: 80px;">
					</td>
					<td>{{ $product->name }}</td>
					<td>
						<div class="custom-control custom-switch">
							<input type="checkbox" class="custom-control-input" id="status_{{ $product->id }}" {{ $product->status ? 'checked' : '' }} disabled>
							<label for="status_{{ $product->id }}" class="custom-control-label">
								{{ $product->status ? 'Hiện' : 'Ẩn' }}
							</label>
						</div>
					</td>
					<td>
						<a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
							<i class="far fa-edit"></i>
						</a>

						<form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline-block;" class="form-delete">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-danger delete">
								<i class="far fa-trash-alt"></i>
							</button>
						</form>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
	const forms = document.querySelectorAll('.form-delete');

	forms.forEach(function(form) {
		form.addEventListener('submit', function (e) {
			e.preventDefault();

			Swal.fire({
				title: 'Bạn chắc chắn?',
				text: 'Hành động này không thể hoàn tác!',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#6c757d',
				confirmButtonText: 'Xoá',
				cancelButtonText: 'Huỷ'
			}).then((result) => {
				if (result.isConfirmed) {
					form.submit();
				}
			});
		});
	});
});
</script>
@endpush
