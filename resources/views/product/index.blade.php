@extends('layouts.base.admin')

@section('title')
Products |
@endsection

@section('style')
@endsection

@section('product-menu')
active
@endsection

@section('main')
<!-- Main Content -->
<div class="container">
	<!-- Title -->
	<section id="product-title" class="mt-3">
		<h2>
			Products Management
			<div class="pull-right">
				<button id="create-btn" class="btn btn-success" type="button" data-link="{{ route('admin.products.create') }}">Create Product</button>
				<a id="filter-collapse-btn" class="btn btn-outline-primary {{ session('product_filter', 'show') == 'show' ? 'active' : '' }}" href="#product-filter" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="product-filter">Show Filters</a>
			</div>
		</h2>
	</section>

	<!-- ALert -->
	<section id="product-alert" class="mt-3">
		@if(session('alert_type'))
			@component('alert')
				@slot('type')
					{{ session('alert_type') }}
				@endslot
				@slot('title')
					{{ session('alert_title') }}
				@endslot
				{{ session('alert_messages') }}
			@endcomponent
		@endisset
	</section>

	<!-- Filter -->
	<section id="product-filter" class="mt-3 collapse {{ session('product_filter', 'show') == 'show' ? 'show' : '' }}">
		<form id="form-filter">
			<div class="row">
				<div class="col">
					<input type="text" id="inputSearch" class="form-control" placeholder="Name" autofocus>
				</div>

				<div class="col-auto">
					<select id="inputType" class="form-control">
						<option value="All" {{ session('product_type', 'All') == 'All' ? 'selected' : '' }}>Bracelet & Ring</option>
						<option value="Bracelet" {{ session('product_type', 'All') == 'Bracelet' ? 'selected' : '' }}>Bracelet</option>
						<option value="Ring" {{ session('product_type', 'All') == 'Ring' ? 'selected' : '' }}>Ring</option>
					</select>
				</div>

				<div class="col-auto">
					<select id="inputLimit" class="form-control">
						<option value="6" {{ session('product_limit', '6') == '6' ? 'selected' : '' }}>Show 6 Per Page</option>
						<option value="10" {{ session('product_limit', '6') == '10' ? 'selected' : '' }}>Show 10 Per Page</option>
						<option value="25" {{ session('product_limit', '6') == '25' ? 'selected' : '' }}>Show 25 Per Page</option>
					</select>
				</div>

				<div class="col-auto">
					<select id="inputStatus" class="form-control">
						<option value="active" {{ session('product_status', 'active') == 'active' ? 'selected' : '' }}>Only Active</option>
						<option value="inactive" {{ session('product_status', 'active') == 'inactive' ? 'selected' : '' }}>Only Inactive</option>
						<option value="all" {{ session('product_status', 'active') == 'all' ? 'selected' : '' }}>Show All</option>
					</select>
				</div>

				<!-- Force next columns to break to new line at md breakpoint and up -->
				<div class="w-100 d-block d-md-none"></div>

				<div class="col-6 col-md-auto">
					<button type="submit" id="apply-btn" class="btn btn-block btn-main">Apply</button>
				</div>

				<div class="col-6 col-md-auto">
					<button type="reset" id="apply-btn" class="btn btn-block btn-main">Reset</button>
				</div>
			</div>
		</form>
	</section>

	<!-- Data -->
	<section id="product-data" class="mt-3">
	</section>

	<!-- Modal -->
	<div class="modal fade" id="product-modal" tabindex="-1" role="dialog" aria-labelledby="Product Modal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	ajaxLoad("{{ route('admin.products.list') }}", "product-data");

	$("#product-filter")
		.on("hide.bs.collapse", function () {
			$("#filter-collapse-btn").removeClass("active");
			$.post(
				"{{ route('admin.products.set.session') }}",
				{
					type: "filter",
					value: "hide"
				},
				function(data) {
					if(data == false) {
						alert("Something is wrong. (Code: A01)");
					}
				}
			);
		})
		.on("show.bs.collapse", function () {
			$("#filter-collapse-btn").addClass("active");
			$.post(
				"{{ route('admin.products.set.session') }}",
				{
					type: "filter",
					value: "show"
				},
				function(data) {
					if(data == false) {
						alert("Something is wrong. (Code: A01)");
					}
				}
			);
		})
		.on("shown.bs.collapse", function () {
			$("#inputSearch").focus();
		})
		.on("hidden.bs.collapse", function () {
			$("#filter-collapse-btn").blur();
		});

	$("#form-filter")
		.submit(function(e) {
			e.preventDefault();
			ajaxLoad("{{ route('admin.products.list') }}?ok_name=1&name=" + $("#inputSearch").val(), "product-data");
		})
		.on("reset", function(e)
		{
			setTimeout(function() {
				$("#inputSearch").focus();
			});
		});

	$("#inputType").change(function() {
		ajaxLoad("{{ route('admin.products.list') }}?ok_type=1&type=" + $("#inputType").val(), "product-data");
	});

	$("#inputLimit").change(function() {
		ajaxLoad("{{ route('admin.products.list') }}?ok_limit=1&limit=" + $("#inputLimit").val(), "product-data");
	});

	$("#inputStatus").change(function() {
		ajaxLoad("{{ route('admin.products.list') }}?ok_status=1&status=" + $("#inputStatus").val(), "product-data");
	});

	$("#create-btn").click(function() {
		var btn = $(this);
		$("#loading").show();
		$("#product-modal").modal("show").find(".modal-content").empty().load(btn.data("link"), function() {
			$("#loading").hide();
		});
	});
</script>
@endsection
