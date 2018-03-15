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
		<link href="{{ asset('css/main-template.css') }}" rel="stylesheet" type="text/css">
		@yield('style')

		<title>@yield('title'){{ config('app.name', 'Laravel') }}</title>
	</head>
	<body>
		<!-- Top Navigation -->
		<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="#">사랑이 하우스</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarToggler">
					<ul id="menu-nav" class="navbar-nav ml-auto mt-2 mt-lg-0">
						<li class="nav-item active">
							<a class="nav-link" href="#home">홈 <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#about">반지</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#gallery">팔찌</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#contact">콜센터</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">로그인</a>
						</li>
					</ul>
					<ul id="user-nav" class="navbar-nav mt-2 mt-lg-0">
						@guest
							<li class="nav-item">
								<a class="nav-link" href="#login" onclick="showLoginModal(event)">Login</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Register</a>
							</li>
						@endguest

						@auth
							<li class="nav-item">
								<a class="nav-link" href="{{ route('home') }}">{{ Auth::user()->name }}</a>
							</li>
						@endauth
					</ul>
				</div>
			</div>
		</nav>

		<main>
			@yield('main')
		</main>

		<footer class="pt-3 pb-3">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-4 mt-3">
						<div id="about">
							<h2>About Sarangi House</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent a auctor neque. Donec eu augue tellus. Nulla facilisi. Fusce aliquet venenatis libero vitae sodales. Duis tristique consectetur ornare. Sed euismod sollicitudin maximus.</p>
						</div>
					</div>
					<div class="col-12 col-sm-4 mt-3">
						<div id="links">
							<h2>Quick Links</h2>
							<a href="#">Terms of Use</a> <br>
							<a href="#">FAQ</a> <br>
							<a href="#">Sitemap</a>
						</div>
					</div>
					<div class="col-12 col-sm-4 mt-3">
						<div id="contact">
							<h2>Get in Touch</h2>
							<div id="phone">
								<span class="fa fa-phone fa-fw"></span> <strong>Phone</strong> : 081395015265
							</div>
							<div id="email">
								<span class="fa fa-mail fa-fw"></span> <strong>Email</strong> : admin@sarangihouse.com
							</div>
							<div id="address">
								<span class="fa fa-house fa-fw"></span> <strong>Address</strong> : blablabla
							</div>
							<div id="kakao">
								<span class="fa fa-user fa-fw"></span> <strong>Kakao</strong> : @sarangihouse
							</div>
						</div>
					</div>
					<div class="col-12 mt-5">
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

		<!-- Login Modal -->
		<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="imageModalTitle">Login</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="{{ route('login') }}" method="post" id="login-form">
							{{ csrf_field() }}
							<div class="form-group">
								<label for="inputemail">Email Address</label>
								<input type="email" placeholder="name@example.com" class="form-control" id="inputemail" required name="email" value="{{ old('email', '') }}">
							</div>
							<div class="form-group">
								<label for="inputpassword">Password</label>
								<input type="password" placeholder="password" class="form-control" id="inputpassword" required>
							</div>
							<div class="form-group">
								<div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
							</div>
							<div class="form-group">
								<a class="btn btn-link" href="{{ route('login.kakao') }}">
									Login With Kakao Talk
								</a>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" form="login-form" class="btn btn-primary">Login</button>
					</div>
				</div>
			</div>
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
			});

			function showLoginModal(event) {
				event.preventDefault();
				$("#loginModal").modal('show');
			}

			$("#loginModal").on('shown.bs.modal', function() {
				$("#inputemail").val('').focus();
				$("#inputpassword").val('');
			});
		</script>
		@yield('script')
	</body>
</html>
