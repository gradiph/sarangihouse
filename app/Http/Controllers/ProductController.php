<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSetSessionRequest;
use Illuminate\Http\Request;
use App\Product;
use DB;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($product)
    {
        $product = Product::withTrashed()->find($product);

		return view('product.show')->with([
			'product' => $product,
		]);
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }

	public function dataList(Request $request)
	{
		session(['product_name' => $request->has('ok_name') ? $request->name : session('product_name', '')]);
		session(['product_type_order' => $request->has('ok_order') ? $request->type_order : session('product_type_order', 'name')]);
		session(['product_value_order' => $request->has('ok_order') ? $request->value_order : session('product_value_order', 'asc')]);
		session(['product_limit' => $request->has('ok_limit') ? $request->limit : session('product_limit', '6')]);
		session(['product_status' => $request->has('ok_status') ? $request->status : session('product_status', 'active')]);

		$products = Product::where('name', 'like', '%'.session('product_name').'%')
			->orderBy(session('product_type_order'), session('product_value_order'));

		if(session('product_status') == 'inactive') $products->onlyTrashed();
		elseif(session('product_status') == 'all') $products->withTrashed();

		$count = $products->sum('qty');

		return view('product.list')->with([
			'products' => $products->paginate(session('product_limit')),
			'count' => $count,
		]);
	}

	public function setSessionPost(ProductSetSessionRequest $request)
	{
		session(['product_'.$request->type => $request->value]);

		return session('product_'.$request->type) == $request->value;
	}
}
