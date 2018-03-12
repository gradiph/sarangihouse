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
				<a id="filter-collapse-btn" class="btn btn-outline-primary {{ session('product_filter', 'show') == 'show' ? 'active' : '' }}" href="#product-filter" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="product-filter">Show Filters</a>
			</div>
		</h2>
	</section>

	<!-- Filter -->
	<section id="product-filter" class="mt-3 collapse {{ session('product_filter', 'show') == 'show' ? 'show' : '' }}">
		<form id="form-filter">
			<div class="row">
				<div class="col">
					<div class="form-label-group">
						<input type="text" id="inputName" class="form-control" placeholder="Name" autofocus>
						<label for="inputName">Name</label>
					</div>
				</div>

				<div class="col-auto">
					<select id="inputLimit" class="form-control form-control-lg">
						<option value="6" {{ session('product_limit', '6') == '6' ? 'selected' : '' }}>Show 6 Per Page</option>
						<option value="10" {{ session('product_limit', '6') == '10' ? 'selected' : '' }}>Show 10 Per Page</option>
						<option value="25" {{ session('product_limit', '6') == '25' ? 'selected' : '' }}>Show 25 Per Page</option>
					</select>
				</div>

				<div class="col-auto">
					<select id="inputStatus" class="form-control form-control-lg">
						<option value="active" {{ session('product_status', 'active') == 'active' ? 'selected' : '' }}>Only Active</option>
						<option value="inactive" {{ session('product_status', 'active') == 'inactive' ? 'selected' : '' }}>Only Inactive</option>
						<option value="all" {{ session('product_status', 'active') == 'all' ? 'selected' : '' }}>Show All</option>
					</select>
				</div>

				<!-- Force next columns to break to new line at md breakpoint and up -->
				<div class="w-100 d-block d-md-none"></div>

				<div class="col-6 col-md-auto">
					<button type="submit" id="apply-btn" class="btn btn-block btn-lg btn-main">Apply</button>
				</div>

				<div class="col-6 col-md-auto">
					<button type="reset" id="apply-btn" class="btn btn-block btn-lg btn-main">Reset</button>
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
		.on('hide.bs.collapse', function () {
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
		.on('show.bs.collapse', function () {
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
		.on('shown.bs.collapse', function () {
			$("#inputName").focus();
		})
		.on('hidden.bs.collapse', function () {
			$("#filter-collapse-btn").blur();
		});

	$("#form-filter")
		.submit(function(e) {
			e.preventDefault();
			ajaxLoad("{{ route('admin.products.list') }}?ok_name=1&name=" + $("#inputName").val(), "product-data");
		})
		.on('reset', function(e)
		{
			setTimeout(function() {
				$("#inputName").focus();
			});
		});

	$("#inputLimit").change(function() {
		ajaxLoad("{{ route('admin.products.list') }}?ok_limit=1&limit=" + $("#inputLimit").val(), "product-data");
	});

	$("#inputStatus").change(function() {
		ajaxLoad("{{ route('admin.products.list') }}?ok_status=1&status=" + $("#inputStatus").val(), "product-data");
	});
</script>
@endsection
