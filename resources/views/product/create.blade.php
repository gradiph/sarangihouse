<div class="modal-header">
	<h5 class="modal-title" id="modal-title">Create Product</h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<!-- Create Form -->
	<form action="{{ route('admin.products.store') }}" id="form-create" method="post">
		{{ csrf_field() }}
		<div class="form-group">
			<label for="inputCode">Code</label>
			<input type="text" id="inputCode" class="form-control" name="code" required placeholder="Product code" value="{{ old('code') }}" maxlength="8">
		</div>

		<div class="form-group">
			<label for="inputName">Name</label>
			<input type="text" id="inputName" class="form-control" name="name" required placeholder="Product name" value="{{ old('name') }}">
		</div>

		<div class="form-group">
			<label for="inputPrice">Price</label>
			<input type="text" id="inputPrice" class="form-control" name="price" required placeholder="Product price (only number)" value="{{ old('price') }}">
		</div>

		<div class="form-group">
			<label for="inputQty">Qty</label>
			<div class="input-group">
				<input type="text" id="inputQty" class="form-control" name="qty" required placeholder="Product qty (only number)" value="{{ old('qty', 0) }}">
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
	<!-- Form : Save Button -->
	<div id="save-div" class="col">
		<button id="save-btn" class="btn btn-block btn-primary" type="submit" form="form-create">
			<span class="fa fa-check"></span> Save
		</button>
	</div>

	<!-- Form : Reset Button -->
	<div id="reset-div" class="col">
		<button id="reset-btn" class="btn btn-block btn-warning" type="reset" form="form-create">
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

	$("#product-modal").on("shown.bs.modal", function(e) {
		var modal = $(this);
		modal.attr("aria-labelledby", $("#modal-title"));
		$("#inputCode").focus();
	});

	$("#form-create input").on("focus", function(e) {
		focusTag = $(this);
		this.setSelectionRange(this.value.length, this.value.length);
	});

	$("#inputPrice").on("keyup", function(e) {
		$(this).val(auto_number(e, $(this).val()));
	})
		.keyup();//trigger keyup

	$("#inputQty").on("keyup", function(e) {
		$(this).val(auto_number(e, $(this).val()));
	})
		.keyup();//trigger keyup

	$("#form-create")
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
								'action': "ProductC@create",
								'errorThrown': "-",
							}
						);
					}
				}
			).fail(
				function(xhr, textStatus, errorThrown) {
					alert("Create product is failed");
					$("#loading").hide();
					$.post(
						"{{ route('error-logs.store') }}",
						{
							'created_at': "{{ date('Y-m-d H:i:s') }}",
							'user_id': "{{ Auth::check() ? Auth::id() : NULL }}",
							'description': errorThrown,
							'action': "ProductC@create",
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

	function calculate(number) {
		var input = $("#inputQty"),
			result = parseInt(input.val()) + parseInt(number);
		input.val(result < 0 ? 0 : result);
	}
</script>
