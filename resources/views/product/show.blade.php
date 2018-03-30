@php(include_once(app_path().'/Functions/indonesian_currency.php'))
<div class="modal-header">
	<h5 class="modal-title" id="modal-title">{{ $product->name }}</h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<!-- Data -->
	<table id="table-data" class="mx-auto">
		<tr>
			<td>Code</td>
			<td>&nbsp;:&nbsp;</td>
			<td><strong>{{ $product->code }}</strong></td>
		</tr>
		<tr>
			<td>Name</td>
			<td>&nbsp;:&nbsp;</td>
			<td><strong>{{ $product->name }}</strong></td>
		</tr>
		<tr>
			<td>Price</td>
			<td>&nbsp;:&nbsp;</td>
			<td><strong>{{ indo_currency($product->price) }}</strong></td>
		</tr>
		<tr>
			<td>Qty</td>
			<td>&nbsp;:&nbsp;</td>
			<td><strong>{{ indo_currency($product->qty) }}</strong></td>
		</tr>
	</table>

	<!-- Edit Form -->
	<form action="{{ route('admin.products.update', ['product' => $product->id]) }}" id="form-edit" method="post">
		{{ method_field('put') }}
		{{ csrf_field() }}
		<div class="form-group">
			<label for="inputCode">Code</label>
			<input type="text" id="inputCode" class="form-control" name="code" required placeholder="Product code" value="{{ $product->code }}" maxlength="8">
		</div>

		<div class="form-group">
			<label for="inputName">Name</label>
			<input type="text" id="inputName" class="form-control" name="name" required placeholder="Product name" value="{{ $product->name }}">
		</div>

		<div class="form-group">
			<label for="inputPrice">Price</label>
			<input type="text" id="inputPrice" class="form-control" name="price" required placeholder="Product price (only number)" value="{{ $product->price }}">
		</div>

		<div class="form-group">
			<label for="inputQty">Qty</label>
			<div class="input-group">
				<input type="text" id="inputQty" class="form-control" name="qty" required placeholder="Product qty (only number)" value="{{ $product->qty }}">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" type="button" onclick="calculate(5)">+5</button>
					<button class="btn btn-outline-secondary" type="button" onclick="calculate(1)">+1</button>
					<button class="btn btn-outline-secondary" type="button" onclick="calculate(-1)">-1</button>
					<button class="btn btn-outline-secondary" type="button" onclick="calculate(-5)">-5</button>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="modal-footer">
	<!-- Main : Edit Button -->
	<div id="edit-div" class="col">
		<button id="edit-btn" class="btn btn-block btn-primary" type="button">
			<span class="fa fa-pencil"></span> Edit
		</button>
	</div>

	@if($product->trashed())
	<!-- Main : Activate Button -->
	<div id="activate-div" class="col">
		<button id="activate-btn" class="btn btn-block btn-success" type="button">
			<span class="fa fa-check"></span> Activate
		</button>
	</div>
	@else
	<!-- Main : Deactivate Button -->
	<div id="delete-div" class="col">
		<button id="delete-btn" class="btn btn-block btn-danger" type="button">
			<span class="fa fa-ban"></span> Deactivate
		</button>
	</div>
	@endif

	<!-- Form : Save Button -->
	<div id="save-div" class="col">
		<button id="save-btn" class="btn btn-block btn-primary" type="submit" form="form-edit">
			<span class="fa fa-check"></span> Save
		</button>
	</div>
	<!-- Form : Reset Button -->
	<div id="reset-div" class="col">
		<button id="reset-btn" class="btn btn-block btn-warning" type="reset" form="form-edit">
			<span class="fa fa-refresh"></span> Reset
		</button>
	</div>

	<!-- Main : Cancel Button -->
	<div class="col">
		<button class="btn btn-block btn-secondary" type="button" data-dismiss="modal">
			<span class="fa fa-times"></span> Batal
		</button>
	</div>
</div>

<script>
	var focusTag = $("#inputCode");
	$("#form-edit").hide();
	$("#reset-div").hide();
	$("#save-div").hide();

	$("#product-modal").on("shown.bs.modal", function(e) {
		var modal = $(this);
		modal.attr("aria-labelledby", $("#modal-title"));
	});

	$("#form-edit input").on("focus", function(e) {
		focusTag = $(this);
		this.setSelectionRange(this.value.length, this.value.length);
	});

	$("#edit-btn").click(function() {
		$("#table-data").hide();
		$("#edit-div").hide();
		$("#delete-div").hide();
		$("#activate-div").hide();
		$("#form-edit").show();
		$("#reset-div").show();
		$("#save-div").show();
		$("#inputCode").focus();
	});

	$("#inputPrice").on("keyup", function(e) {
		$(this).val(auto_number(e, $(this).val()));
	})
		.keyup();//trigger keyup

	$("#inputQty").on("keyup", function(e) {
		$(this).val(auto_number(e, $(this).val()));
	})
		.keyup();//trigger keyup

	$("#form-edit")
		.submit(function(e) {
			e.preventDefault();

			//remove the thousand separator
			$("#inputPrice").val($("#inputPrice").val().replace(/\./g, ''));
			$("#inputQty").val($("#inputQty").val().replace(/\./g, ''));

			//variables
			var form = $(this),
				btn = $("#save-btn"),
				link = form.attr("action"),
				data = form.serialize();

			//disable the button after clicked
			btn.prop("disabled", true);

			$("#loading").show();
			$.post(link,data).done(
				function(response) {
					if(response.status = "success") {
						window.location.href = "{{ route('redirect') }}" +
							"?link=" + response.link +
							"&alert_type=" + response.alert_type +
							"&alert_title=" + response.alert_title +
							"&alert_messages=" + response.alert_messages;
					}
					else {
						alert(response.alert_messages);
						btn.prop("disabled", false);
						$("#loading").hide();
						$.post(
							"{{ route('error-logs.store') }}",
							{
								'created_at': "{{ date('Y-m-d H:i:s') }}",
								'user_id': "{{ Auth::check() ? Auth::id() : NULL }}",
								'description': response.alert_messages,
								'action': "ProductC@update",
								'errorThrown': "-",
							}
						);
					}
				}
			).fail(
				function(xhr, textStatus, errorThrown) {
					alert("Update product is failed");
					$("#loading").hide();
					$.post(
						"{{ route('error-logs.store') }}",
						{
							'created_at': "{{ date('Y-m-d H:i:s') }}",
							'user_id': "{{ Auth::check() ? Auth::id() : NULL }}",
							'description': errorThrown,
							'action': "ProductC@update",
							'errorThrown': xhr.responseText,
						}
					);
				}
			);

			//re-enable the button
			btn.prop("disabled", false);
		})
		.on("reset", function(e)
		{
			setTimeout(function() {
				focusTag.focus();
				$("#inputPrice").keyup();
				$("#inputQty").keyup();
			});
		});

	$("#delete-btn").click(function() {
		var btn = $(this),
			confirmed = confirm("Deactivate product {{ $product->name }}?"),
			link = "{{ route('admin.products.destroy', ['product' => $product->id]) }}",
			data = {
				_method: "DELETE"
			};

		//disable the button after clicked
		btn.prop("disabled", true);

		if(confirmed) {
			$("#loading").show();
			$.post(link,data).done(
				function(response) {
					if(response.status = "success") {
						window.location.href = "{{ route('redirect') }}" +
							"?link=" + response.link +
							"&alert_type=" + response.alert_type +
							"&alert_title=" + response.alert_title +
							"&alert_messages=" + response.alert_messages;
					}
					else {
						alert(response.alert_messages);
						btn.prop("disabled", false);
						$("#loading").hide();
						$.post(
							"{{ route('error-logs.store') }}",
							{
								'created_at': "{{ date('Y-m-d H:i:s') }}",
								'user_id': "{{ Auth::check() ? Auth::id() : NULL }}",
								'description': response.alert_messages,
								'action': "ProductC@destroy",
								'errorThrown': "-",
							}
						);
					}
				}
			).fail(
				function(xhr, textStatus, errorThrown) {
					alert("Deactivate product is failed");
					$("#loading").hide();
					$.post(
						"{{ route('error-logs.store') }}",
						{
							'created_at': "{{ date('Y-m-d H:i:s') }}",
							'user_id': "{{ Auth::check() ? Auth::id() : NULL }}",
							'description': errorThrown,
							'action': "ProductC@destroy",
							'errorThrown': xhr.responseText,
						}
					);
				}
			);
		}

		//re-enable the button
		btn.prop("disabled", false);
	});

	$("#activate-btn").click(function() {
		var btn = $(this),
			confirmed = confirm("Activate product {{ $product->name }}?"),
			link = "{{ route('admin.products.activate', ['product' => $product->id]) }}",
			data = {
				_method: "POST"
			};

		//disable the button after clicked
		btn.prop("disabled", true);

		if(confirmed) {
			$("#loading").show();
			$.post(link,data).done(
				function(response) {
					if(response.status = "success") {
						window.location.href = "{{ route('redirect') }}" +
							"?link=" + response.link +
							"&alert_type=" + response.alert_type +
							"&alert_title=" + response.alert_title +
							"&alert_messages=" + response.alert_messages;
					}
					else {
						alert(response.alert_messages);
						btn.prop("disabled", false);
						$("#loading").hide();
						$.post(
							"{{ route('error-logs.store') }}",
							{
								'created_at': "{{ date('Y-m-d H:i:s') }}",
								'user_id': "{{ Auth::check() ? Auth::id() : NULL }}",
								'description': response.alert_messages,
								'action': "ProductC@destroy",
								'errorThrown': "-",
							}
						);
					}
				}
			).fail(
				function(xhr, textStatus, errorThrown) {
					alert("Deactivate product is failed");
					$("#loading").hide();
					$.post(
						"{{ route('error-logs.store') }}",
						{
							'created_at': "{{ date('Y-m-d H:i:s') }}",
							'user_id': "{{ Auth::check() ? Auth::id() : NULL }}",
							'description': errorThrown,
							'action': "ProductC@destroy",
							'errorThrown': xhr.responseText,
						}
					);
				}
			);
		}

		//re-enable the button
		btn.prop("disabled", false);
	});

	function calculate(number) {
		var input = $("#inputQty");
		input.val(parseInt(input.val()) + parseInt(number));
	}
</script>
