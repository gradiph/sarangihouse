@php(include_once(app_path().'/Functions/indonesian_currency.php'))
<article id="data" class="table-responsive">
	<table class="table table-striped table-hover">
		<thead class="bg-main text-light">
			<tr>
				<th scope="col">#</th>
				<th scope="col">
					<a href="#sort" class="sort-btn text-light" data-link="{{ route('admin.products.list') }}?ok_order=1&type_order=code&value_order={{ session('product_value_order') == 'asc' ? 'desc' : 'asc' }}">
						Code
						@if(session('product_type_order') == 'code') <span class="fa fa-sort-alpha-{{ session('product_value_order') }}"></span> @endif
					</a>
				</th>
				<th scope="col">
					<a href="#sort" class="sort-btn text-light" data-link="{{ route('admin.products.list') }}?ok_order=1&type_order=name&value_order={{ session('product_value_order') == 'asc' ? 'desc' : 'asc' }}">
						Name
						@if(session('product_type_order') == 'name') <span class="fa fa-sort-alpha-{{ session('product_value_order') }}"></span> @endif
					</a>
				</th>
				<th scope="col">Type</th>
				<th scope="col">
					<a href="#sort" class="sort-btn text-light" data-link="{{ route('admin.products.list') }}?ok_order=1&type_order=price&value_order={{ session('product_value_order') == 'asc' ? 'desc' : 'asc' }}">
						Price
						@if(session('product_type_order') == 'price') <span class="fa fa-sort-alpha-{{ session('product_value_order') }}"></span> @endif
					</a>
				</th>
				<th scope="col">
					<a href="#sort" class="sort-btn text-light" data-link="{{ route('admin.products.list') }}?ok_order=1&type_order=qty&value_order={{ session('product_value_order') == 'asc' ? 'desc' : 'asc' }}">
						Qty
						@if(session('product_type_order') == 'qty') <span class="fa fa-sort-alpha-{{ session('product_value_order') }}"></span> @endif
					</a>
				</th>
				<th scope="col">Status</th>
			</tr>
		</thead>
		<tbody>
			@php($i = ($products->currentPage() - 1) * $products->perpage())
			@foreach($products as $product)
				<tr>
					<th scope="col">{{ ++$i }}</th>
					<td><a href="#show" class="show-btn" data-link="{{ route('admin.products.show', ['product' => $product->id]) }}">{{ $product->code }}</a></td>
					<td>{{ str_limit($product->name, 20) }}</td>
					<td>{{ str_is('G*', $product->code) ? 'Bracelet' : 'Ring' }}</td>
					<td>{{ indo_currency($product->price) }}</td>
					<td>{{ indo_currency($product->qty) }}</td>
					<td>{!! $product->trashed() ? '<span class="text-danger">Inactive</span>' : '<span class="text-success">Active</span>' !!}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</article>


<article id="summary">
	Total Data: <strong>{{ indo_currency($products->total()) }}</strong>, Total Qty: <strong>{{ indo_currency($count) }}</strong>
	<div class="pull-right">
		{{ $products->links('vendor.pagination.bootstrap-4') }}
	</div>
</article>

<article id="hint" class="pt-3">
	Hint:
	<ul>
		<li>Click on the table heading to sort</li>
		<li>Click on the product name to show product detail</li>
	</ul>
</article>

<script>
	$(".sort-btn").click(function(e) {
		e.preventDefault();
		ajaxLoad($(this).data("link"), "product-data");
	});

	$(".pagination a").on("click", function (e) {
        e.preventDefault();
        ajaxLoad($(this).attr("href"), "product-data");
    });

	$("a.show-btn").click(function(e) {
		var btn = $(this);
		e.preventDefault();
		$("#loading").show();
		$("#product-modal").modal("show").find(".modal-content").empty().load(btn.data("link"), function() {
			$("#loading").hide();
		});
	});
</script>
