@extends('layouts.base.admin')

@section('title')
@endsection

@section('style')
@endsection

@section('main')
<!-- Promo -->
<section id="promo" class="pb-5">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-6 mt-5">
				<h1 id="title">Promo</h1>
				<h2 id="subtitle">Penjelasan</h2>
				<button class="btn btn-lg btn-danger" type="button">Read More</button>
			</div>
			<div class="col-12 col-md-6 mt-5">
				<div id="carouselSlide" class="carousel slide" data-ride="carousel" data-interval="3000" data-pause="hover">
				<div class="text-center">
					<ol class="carousel-indicators">
						<li data-target="#carouselSlide" data-slide-to="0" class="active"></li>
						<li data-target="#carouselSlide" data-slide-to="1"></li>
						<li data-target="#carouselSlide" data-slide-to="2"></li>
					</ol>
				</div>
					<div class="carousel-inner">
						<div class="carousel-item active">
							<img class="d-block w-100" src="{{ asset('images/example.jpg') }}" alt="First slide">
							<div class="carousel-caption">
								<h5>First</h5>
								<p>Boom</p>
							</div>
						</div>
						<div class="carousel-item">
							<img class="d-block w-100" src="{{ asset('images/example.jpg') }}" alt="Second slide">
							<div class="carousel-caption">
								<h5>Second</h5>
								<p>Boom</p>
							</div>
						</div>
						<div class="carousel-item">
							<img class="d-block w-100" src="{{ asset('images/example.jpg') }}" alt="Third slide">
							<div class="carousel-caption">
								<h5>Third</h5>
								<p>Boom</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Popular Ring -->
<section id="popular-ring" class="py-5">
	<div class="container">
		<div class="title text-center mb-3">
			<span class="title-text">&nbsp; 인기있는 커플 반지 &nbsp;</span>
			<div class="title-line"></div>
		</div>

		<div class="row">
			<div class="col-12 col-sm-4 mt-3">
				<figure class="figure">
					<div class="zoom">
						<img src="{{ asset('images/example.jpg') }}" alt="Ring 1" class="figure-img img-fluid rounded mb-0">
					</div>
					<figcaption class="figure-caption mt-2">Ring 1</figcaption>
				</figure>
				<button class="btn btn-main" type="button">Learn More</button>
			</div>

			<div class="col-12 col-sm-4 mt-3">
				<figure class="figure">
					<div class="zoom">
						<img src="{{ asset('images/example.jpg') }}" alt="Ring 2" class="figure-img img-fluid rounded mb-0">
					</div>
					<figcaption class="figure-caption mt-2">Ring 2</figcaption>
				</figure>
				<button class="btn btn-main" type="button">Learn More</button>
			</div>

			<div class="col-12 col-sm-4 mt-3">
				<figure class="figure">
					<div class="zoom">
						<img src="{{ asset('images/example.jpg') }}" alt="Ring 2" class="figure-img img-fluid rounded mb-0">
					</div>
					<figcaption class="figure-caption mt-2">Ring 2</figcaption>
				</figure>
				<button class="btn btn-main" type="button">Learn More</button>
			</div>
		</div>
	</div>
</section>

<div class="container mb-5">
	<div class="row">
		<!-- New Item -->
		<section id="new-item" class="col-12 col-sm-4 mt-5">
			<div class="title">새로나옴</div>
			<figure class="figure">
				<div class="zoom">
					<img src="{{ asset('images/example.jpg') }}" alt="Ring 1" class="figure-img img-fluid rounded mb-0">
				</div>
				<figcaption class="figure-caption mt-2">Ring 4</figcaption>
			</figure>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent a auctor neque. Donec eu augue tellus. Nulla facilisi. Fusce aliquet venenatis libero vitae sodales. Duis tristique consectetur ornare. Sed euismod sollicitudin maximus. Nam in est nec erat dictum scelerisque ut sit amet diam. Morbi dignissim elit vitae dolor facilisis, at viverra urna fringilla. Nunc nec sem enim. Suspendisse potenti. Sed pellentesque congue sagittis. Pellentesque sagittis ligula ut ipsum pretium, ac lobortis sapien pretium. Curabitur quis mi vel ipsum malesuada mattis. Donec ac convallis leo. Praesent ante dui, consequat nec libero sed, congue ornare massa.</p>
			<button class="btn btn-main" type="button">Learn More</button>
		</section>

		<!-- Best Seller -->
		<section id="best-seller" class="col-12 col-sm-4 mt-5">
			<div class="title">베스트 셀러</div>
			<figure class="figure">
				<div class="zoom">
					<img src="{{ asset('images/example.jpg') }}" alt="Ring 1" class="figure-img img-fluid rounded mb-0">
				</div>
				<figcaption class="figure-caption mt-2">Ring 5</figcaption>
			</figure>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent a auctor neque. Donec eu augue tellus. Nulla facilisi. Fusce aliquet venenatis libero vitae sodales. Duis tristique consectetur ornare. Sed euismod sollicitudin maximus. Nam in est nec erat dictum scelerisque ut sit amet diam. Morbi dignissim elit vitae dolor facilisis, at viverra urna fringilla. Nunc nec sem enim. Suspendisse potenti. Sed pellentesque congue sagittis. Pellentesque sagittis ligula ut ipsum pretium, ac lobortis sapien pretium. Curabitur quis mi vel ipsum malesuada mattis. Donec ac convallis leo. Praesent ante dui, consequat nec libero sed, congue ornare massa.</p>
			<button class="btn btn-main" type="button">Learn More</button>
		</section>

		<!-- Event -->
		<section id="event" class="col-12 col-sm-4 mt-5">
			<div class="title">이벤트</div>
			<figure class="figure">
				<div class="zoom">
					<img src="{{ asset('images/example.jpg') }}" alt="Ring 1" class="figure-img img-fluid rounded mb-0">
				</div>
				<figcaption class="figure-caption mt-2">Ring 6</figcaption>
			</figure>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent a auctor neque. Donec eu augue tellus. Nulla facilisi. Fusce aliquet venenatis libero vitae sodales. Duis tristique consectetur ornare. Sed euismod sollicitudin maximus. Nam in est nec erat dictum scelerisque ut sit amet diam. Morbi dignissim elit vitae dolor facilisis, at viverra urna fringilla. Nunc nec sem enim. Suspendisse potenti. Sed pellentesque congue sagittis. Pellentesque sagittis ligula ut ipsum pretium, ac lobortis sapien pretium. Curabitur quis mi vel ipsum malesuada mattis. Donec ac convallis leo. Praesent ante dui, consequat nec libero sed, congue ornare massa.</p>
			<button class="btn btn-main" type="button">Learn More</button>
		</section>
	</div>
</div>
@endsection

@section('script')
@endsection
