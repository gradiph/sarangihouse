<!doctype html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- CSRF Token -->
    	<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/bootstrap-grid.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/bootstrap-reboot.min.css') }}">

		<!-- FontAwesome CSS -->
		<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

		<!-- Font CSS -->
		<link rel="stylesheet" href="{{ asset('css/korean-fonts.css') }}">
		<link href="http://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet" type="text/css">
    	<link href="http://fonts.googleapis.com/css?family=Palatino+Linotype" rel="stylesheet" type="text/css">

		<!-- Custom CSS -->
		<link href="{{ asset('css/dashboard-template.css') }}" rel="stylesheet" type="text/css">
		@yield('style')

		<title>@yield('title'){{ config('app.name', 'Laravel') }}</title>
	</head>
	<body>
		<!-- Top Navigation -->
		<nav class="navbar sticky-top navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="{{ route('home') }}">사랑이 하우스</a>

				<div class="dropdown ml-auto">
					<button class="btn btn-main dropdown-toggle" type="button" id="userDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="fa fa-fw fa-user"></span> {{ Auth::user()->name }}
					</button>
					<div class="dropdown-menu" aria-labelledby="User Dropdown Button">
						<a class="dropdown-item" href="#">Your Profile</a>
						<a class="dropdown-item" href="#">Another action</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="{{ route('logout') }}">Log Out</a>
					</div>
				</div>
			</div>
		</nav>

		<!-- Menu Navigation -->
		<nav>
			<ul class="nav nav-pills nav-fill bg-soft-main">
				<li class="nav-item">
					<a href="{{ route('admin.home') }}" class="nav-link btn btn-soft-main @yield('home-menu')">Home</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link btn btn-soft-main @yield('order-menu')">Orders</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin.products.index') }}" class="nav-link btn btn-soft-main @yield('product-menu')">Products</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link btn btn-soft-main @yield('highlight-menu')">Highlight Products</a>
				</li>
			</ul>
		</nav>

		<!-- Main Content -->
		<main>
			@yield('main')
		</main>

		<footer class="py-4 mt-3">
			<div class="container">
				<div class="row">
					<div class="col-12">
						Copyright &copy;2018 Sarangi House.
					</div>
				</div>
			</div>
		</footer>

		<!-- Loading -->
		<div id="loading">
			<span class="fa fa-spinner fa-pulse fa-5x fa-fw"></span>
			<div class="text-center">Loading...</div>
		</div>

		<!-- JavaScript -->
		<!-- Bootstrap 4 JS -->
		<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
		<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

		<!-- Zoom JS -->
		<script src="{{ asset('js/jquery.zoom.min.js') }}"></script>

		<!-- Custom JS -->
		<script src="{{ asset('js/main-functions.js') }}"></script>
		<script>
			$(document).ready(function() {
				$('.zoom').zoom();
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
			});
		</script>
		@yield('script')
	</body>
</html>
