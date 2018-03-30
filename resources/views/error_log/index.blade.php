@extends('layouts.base.admin')

@section('title')
Error Logs |
@endsection

@section('style')
@endsection

@section('log-menu')
active
@endsection

@section('log-menu-name')
Error
@endsection

@section('main')
<!-- Main Content -->
<div class="container">
	<!-- Title -->
	<section id="error-log-title" class="mt-3">
		<h2>
			Error Logs Management
			<div class="pull-right">
				<a id="filter-collapse-btn" class="btn btn-outline-primary {{ session('error_log_filter', 'show') == 'show' ? 'active' : '' }}" href="#error-log-filter" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="error-log-filter">Show Filters</a>
			</div>
		</h2>
	</section>

	<!-- Filter -->
	<section id="error-log-filter" class="mt-3 collapse {{ session('error_log_filter', 'show') == 'show' ? 'show' : '' }}">
		<form id="form-filter">
			<div class="row">
				<div class="col">
					<input type="text" id="inputSearch" class="form-control" placeholder="Name or Description" value="{{ session('error_log_search', '') }}" autofocus>
				</div>

				<div class="col-auto">
					<select id="inputLimit" class="form-control">
						<option value="6" {{ session('error_log_limit', '6') == '6' ? 'selected' : '' }}>Show 6 Per Page</option>
						<option value="10" {{ session('error_log_limit', '6') == '10' ? 'selected' : '' }}>Show 10 Per Page</option>
						<option value="25" {{ session('error_log_limit', '6') == '25' ? 'selected' : '' }}>Show 25 Per Page</option>
					</select>
				</div>

				<div class="col-auto">
					<select id="inputStatus" class="form-control">
						<option value="Waiting" {{ session('error_log_status', 'Waiting') == 'Waiting' ? 'selected' : '' }}>Only Waiting</option>
						<option value="Process" {{ session('error_log_status', 'Waiting') == 'Process' ? 'selected' : '' }}>Only Process</option>
						<option value="Clear" {{ session('error_log_status', 'Waiting') == 'Clear' ? 'selected' : '' }}>Only Clear</option>
						<option value="all" {{ session('error_log_status', 'Waiting') == 'all' ? 'selected' : '' }}>Show All</option>
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
	<section id="error-log-data" class="mt-3">
	</section>
</div>
@endsection

@section('script')
<script>
	ajaxLoad("{{ route('admin.error-logs.list') }}", "error-log-data");

	$("#error-log-filter")
		.on("hide.bs.collapse", function () {
			$("#filter-collapse-btn").removeClass("active");
			$.post(
				"{{ route('admin.error-logs.set.session') }}",
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
				"{{ route('admin.error-logs.set.session') }}",
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
			ajaxLoad("{{ route('admin.error-logs.list') }}?ok_search=1&search=" + $("#inputSearch").val(), "error-log-data");
		})
		.on("reset", function(e)
		{
			setTimeout(function() {
				$("#inputSearch").focus();
			});
		});

	$("#inputLimit").change(function() {
		ajaxLoad("{{ route('admin.error-logs.list') }}?ok_limit=1&limit=" + $("#inputLimit").val(), "error-log-data");
	});

	$("#inputStatus").change(function() {
		ajaxLoad("{{ route('admin.error-logs.list') }}?ok_status=1&status=" + $("#inputStatus").val(), "error-log-data");
	});
</script>
@endsection
