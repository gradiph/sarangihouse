@extends('layouts.base.admin')

@section('title')
@endsection

@section('style')
@endsection

@section('home-menu')
active
@endsection

@section('main')
<!-- Top Dashboard -->
<section id="top-dashboard" class="container">
	<div class="row">
		<!-- Orders -->
		<article id="orders" class="col-12 col-md-6 mt-3">
			<div class="card">
				<div class="card-header">
					Orders
				</div>
				<div class="card-body">
					Lorem ipsum.
				</div>
			</div>
		</article>

		<!-- Products -->
		<article id="products" class="col-12 col-md-6 mt-3">
			<div class="card">
				<div class="card-header">
					Products
				</div>
				<div class="card-body">
					Lorem ipsum.
				</div>
			</div>
		</article>
	</div>
</section>

@endsection

@section('script')
@endsection
