@php(include_once(app_path().'/Functions/indonesian_currency.php'))
<div class="modal-header">
	<h5 class="modal-title" id="modal-title">{{ $product->name }}</h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<table class="mx-auto">
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
</div>
<div class="modal-footer">
	<div class="col">
		<button id="edit-btn" class="btn btn-block btn-primary" type="button">
			<span class="fa fa-pencil"></span> Edit
		</button>
	</div>
	<div class="col">
		<button id="delete-btn" class="btn btn-block btn-danger" type="button">
			<span class="fa fa-trash"></span> Deactivate
		</button>
	</div>
	<div class="col">
		<button class="btn btn-block btn-secondary" type="button" data-dismiss="modal">
			<span class="fa fa-times"></span> Batal
		</button>
	</div>
</div>
<script>
	$("#product-modal").on("shown.bs.modal", function(e) {
		var modal = $(this);
		modal.attr("aria-labelledby", $("#modal-title"));
	});
</script>
