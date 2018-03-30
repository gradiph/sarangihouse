@php(include_once(app_path().'/Functions/indonesian_date.php'))
@php(include_once(app_path().'/Functions/indonesian_currency.php'))
<article id="data" class="table-responsive">
	<table class="table table-striped table-hover">
		<thead class="bg-main text-light">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Date</th>
				<th scope="col">Name</th>
				<th scope="col">Description</th>
				<th scope="col">Status</th>
			</tr>
		</thead>
		<tbody>
			@php($i = ($error_logs->currentPage() - 1) * $error_logs->perpage())
			@foreach($error_logs as $error_log)
				<tr>
					<th scope="col">{{ ++$i }}</th>
					<td><a href="{{ route('admin.error-logs.show', ['error_log' => $error_log->id]) }}" class="show-btn" data-link="{{ route('admin.error-logs.show', ['error_log' => $error_log->id]) }}">{{ indo_date($error_log->created_at) }}</a></td>
					<td>{{ $error_log->user_id != NULL ? $error_log->user->name : 'Guest' }}</td>
					<td>{{ str_limit($error_log->description, 50) }}</td>
					<td><span class="text-{{ $error_log->status == 'Waiting' ? 'danger' : ($error_log->status == 'Process' ? 'warning' : 'success') }}">{{ $error_log->status }}</span></td>
				</tr>
			@endforeach
		</tbody>
	</table>
</article>


<article id="summary">
	Total Data: <strong>{{ indo_currency($error_logs->total()) }}</strong>
	<div class="pull-right">
		{{ $error_logs->links('vendor.pagination.bootstrap-4') }}
	</div>
</article>

<article id="hint" class="pt-3">
	Hint:
	<ul>
		<li>Click on the log date to show the log detail</li>
	</ul>
</article>

<script>
	$(".pagination a").on("click", function (e) {
        e.preventDefault();
        ajaxLoad($(this).attr("href"), "error-log-data");
    });

	$("a.show-btn").click(function(e) {
		var btn = $(this);
		$("#loading").show();
	});
</script>
