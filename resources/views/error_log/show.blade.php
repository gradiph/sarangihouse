@extends('layouts.base.admin')

@section('title')
Error Logs #{{ $error_log->id }} |
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
@php(include_once(app_path('/Functions/indonesian_date.php')))
<!-- Main Content -->
<div class="container">
	<!-- Title -->
	<section id="error-log-title" class="mt-3">
		<h2>
			Error Logs #{{ $error_log->id }}
			<div class="pull-right">
				<button class="dropdown-toggle btn btn-secondary" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Option
				</button>
				<div class="dropdown-menu">
					@if($prev != null)
						<a href="{{ route('admin.error-logs.show', ['error_log' => $prev]) }}" class="dropdown-item">
							<span class="fa fa-vw fa-arrow-left"></span> Previous
						</a>
					@endif

					<button class="status-btn dropdown-item btn btn-secondary" data-status="Waiting" {{ $error_log->status == 'Waiting' ? 'disabled' : '' }}>
						<span class="fa fa-vw fa-check-square text-danger"></span> Waiting
					</button>

					<button class="status-btn dropdown-item btn btn-secondary" data-status="Process" {{ $error_log->status == 'Process' ? 'disabled' : '' }}>
						<span class="fa fa-vw fa-check-square text-warning"></span> Process
					</button>

					<button class="status-btn dropdown-item btn btn-secondary" data-status="Clear" {{ $error_log->status == 'Clear' ? 'disabled' : '' }}>
						<span id="clear-icon" class="fa fa-vw fa-check-square text-success"></span> Clear
					</button>

					@if($next != null)
						<a href="{{ route('admin.error-logs.show', ['error_log' => $next]) }}" class="dropdown-item">
							<span class="fa fa-vw fa-arrow-right"></span> Next
						</a>
					@endif
				</div>
			</div>
		</h2>
	</section>

	<!-- Data -->
	<section id="error-log-data" class="mt-3">
		<div class="row">
			<div class="col-12 col-md-4">
				<p>Date : <strong>{{ indo_date($error_log->created_at) }}</strong></p>
			</div>

			<div class="col-12 col-md-4">
				<p>User : <strong>{{ $error_log->user_id != NULL ? $error_log->user->name : 'Guest' }}</strong></p>
			</div>

			<div class="col-12 col-md-4">
				<p>Status : <strong id="error-log-status" class="text-{{ $error_log->status == 'Waiting' ? 'danger' : ($error_log->status == 'Process' ? 'warning' : 'success') }}">{{ $error_log->status }}</strong></p>
			</div>

			<div class="col-12 col-md-6">
				<p>Action : <strong>{{ $error_log->action }}</strong></p>
			</div>

			<div class="col-12 col-md-6">
				<p>Description : <strong>{{ $error_log->description }}</strong></p>
			</div>

			<div class="w-100"></div>

			<div class="col">
				Error Thrown :
				<br>
				{{ dump($error_log->errorThrown) }}
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')
<script>
	$(".status-btn").click(function() {
		var btn = $(this);
		$("#loading").show();

		$.post(
			"{{ route('admin.error-logs.update', ['error_log' => $error_log->id]) }}",
			{
				_method: "patch",
				status: btn.data("status"),
			}
		).done(
			function(response) {
				if(response.status = "success") {
					$("#loading").hide();
					location.reload();
				}
				else {
					alert(response.alert_messages);
					$("#loading").hide();
					$.post(
						"{{ route('error-logs.store') }}",
						{
							'created_at': "{{ date('Y-m-d H:i:s') }}",
							'user_id': "{{ Auth::id() }}",
							'description': response.alert_messages,
							'action': "ErrorLogC@update",
							'errorThrown': "-",
						}
					);
				}
			}
		).fail(
			function(xhr, textStatus, errorThrown) {
				alert("Change status is failed");
				$("#loading").hide();
				$.post(
					"{{ route('error-logs.store') }}",
					{
						'created_at': "{{ date('Y-m-d H:i:s') }}",
						'user_id': "{{ Auth::id() }}",
						'description': errorThrown,
						'action': "ErrorLogC@update",
						'errorThrown': xhr.responseText,
					}
				);
			}
		);

	});
</script>
@endsection
