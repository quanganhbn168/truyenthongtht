@extends('layouts.master')
@section('title','Liên hệ')
@section('content')
<div id="contact">
	<div class="container">
		<x-frontend.breadcrumb :items="[
			['label' => 'Liên hệ'],
		]"/>
		<h2 class="text-center mt-3">Liên hệ</h2>
		<div class="row">
			<div class="col-12 col-md-6 col-sm-12 order-2 order-md-1">
				<h3>
					<strong>CÔNG TY CỔ PHẦN NỘI THẤT VOYHOME</strong>
				</h3>
				<ul>
					<li></li>
				</ul>
			</div>
			<div class="col-12 col-md-6 col-sm-12 order-1 order-md-2">
				<div class="card text-bg-light">
					<div class="card-header">
						<div class="card-title">
							<h3 class="strong text-uppercase">Liên hệ ngay với chúng tôi</h3>
						</div>
					</div>
					<div class="card-body bg-light">
						<form action="#" method="POST">
							@csrf
							<div class="row">
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="name">Họ và tên *</label>
										<input type="text" class="form-control" id="name" name="name" autocomplete>
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="address">Địa chỉ</label>
										<input type="text" class="form-control" id="address" name="address" autocomplete>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="phone">Số điện thoại *</label>
										<input type="text" class="form-control" id="phone" name="phone" autocomplete>
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="email">Email</label>
										<input type="text" class="form-control" id="email" name="email" autocomplete>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="content">Ý kiến</label>
								<textarea name="content" id="content" class="form-control" autocomplete></textarea>
							</div>
							<button class="btn btn-dark d-block w-100">Gửi ý kiến</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
