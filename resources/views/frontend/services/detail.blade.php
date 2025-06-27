@extends('layouts.master')
@section('title',$category->name)
@push('css')
<link rel="stylesheet" href="{{asset('css/product.css')}}">
@endpush
@section('content')
	<div id="service-wrapper">
		<div class="container">
			<div class="col-12 col-md-9">
				<h1 class="text-primary">{{$category->name}}</h1>
				<div class="description">
					{!!$category->content!!}
				</div>
			</div>
			<div class="col-md-3">
				
			</div>
		</div>
	</div>			
@endsection
@push('js')

@endpush