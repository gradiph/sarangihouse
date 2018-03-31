<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSetSessionRequest;
use App\Http\Requests\ProductResourceRequest;
use Illuminate\Http\Request;
use App\Product;
use App\UserLog;
use Auth;
use DB;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index');
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(ProductResourceRequest $request)
    {
        DB::beginTransaction();

		//create product
		$product = Product::create([
			'code' => $request->code,
			'name' => $request->name,
			'price' => $request->price,
			'qty' => $request->qty,
		]);

		if($product)
		{
			//create model UserLog
			$log = UserLog::create([
				'created_at' => date('Y-m-d H:i:s'),
				'user_id' => Auth::id(),
				'description' => 'Product #' . $product->id . ': create product',
			]);

			if($log) {
				goto success;
			}
		}

		DB::rollBack();
		return response()->json([
			'status' => 'fail',
			'alert_messages' => 'Terjadi kesalahan.',
		]);

		success:
		DB::commit();
		return response()->json([
			'status' => 'success',
			'link' => 'admin.products.index',
			'alert_type' => 'alert-success',
			'alert_title' => 'Success!',
			'alert_messages' => 'Product ' . $product->name . ' is created.',
		]);
    }

    public function show($product)
    {
		$product = Product::withTrashed()->find($product);

		return view('product.show')->with([
			'product' => $product,
		]);
    }

    public function update(ProductResourceRequest $request, $product)
    {
        DB::beginTransaction();

		//find product
		$product = Product::withTrashed()->find($product);

		//check whether new data is different with old data
		if($product->code != $request->code || $product->name != $request->name || $product->price != $request->price || $product->qty != $request->qty)
		{
			//description for log
			$desc = 'Product #' . $product->id . ': change product (';

			//update product code
			if($product->code != $request->code)
			{
				$desc = $desc . 'code: ' . $product->code . ' -> ' . $request->code . ', ';
				$product->code = $request->code;
			}

			//update product name
			if($product->name != $request->name)
			{
				$desc = $desc . 'name: ' . $product->name . ' -> ' . $request->name . ', ';
				$product->name = $request->name;
			}

			//update product price
			if($product->price != $request->price)
			{
				$desc = $desc . 'price: ' . $product->price . ' -> ' . $request->price . ', ';
				$product->price = $request->price;
			}

			//update product qty
			if($product->qty != $request->qty)
			{
				$desc = $desc . 'qty: ' . $product->qty . ' -> ' . $request->qty . ', ';
				$product->qty = $request->qty;
			}

			//beutify the description
			$desc = str_replace_last(', ', ')', $desc);

			if($product->save())
			{
				//create model UserLog
				$log = UserLog::create([
					'created_at' => date('Y-m-d H:i:s'),
					'user_id' => Auth::id(),
					'description' => $desc,
				]);

				if($log) {
					goto success;
				}
			}
		}
		else
		{
			//no new information, straight return
			goto success;
		}

		DB::rollBack();
		return response()->json([
			'status' => 'fail',
			'alert_messages' => 'Terjadi kesalahan.',
		]);

		success:
		DB::commit();
		return response()->json([
			'status' => 'success',
			'link' => 'admin.products.index',
			'alert_type' => 'alert-success',
			'alert_title' => 'Success!',
			'alert_messages' => 'Product ' . $product->name . ' is updated.',
		]);
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();

		if($product->delete())
		{
			//create model UserLog
			$log = UserLog::create([
				'created_at' => date('Y-m-d H:i:s'),
				'user_id' => Auth::id(),
				'description' => 'Product #' . $product->id . ': deactivate product',
			]);

			if($log) {
				goto success;
			}
		}

		DB::rollBack();
		return response()->json([
			'status' => 'fail',
			'alert_messages' => 'Terjadi kesalahan.',
		]);

		success:
		DB::commit();
		return response()->json([
			'status' => 'success',
			'link' => 'admin.products.index',
			'alert_type' => 'alert-success',
			'alert_title' => 'Success!',
			'alert_messages' => 'Product ' . $product->name . ' is deactivated.',
		]);
    }

	public function dataList(Request $request)
	{
		//set session
		session(['product_name' => $request->has('ok_name') ? $request->name : session('product_name', '')]);
		session(['product_type_order' => $request->has('ok_order') ? $request->type_order : session('product_type_order', 'code')]);
		session(['product_value_order' => $request->has('ok_order') ? $request->value_order : session('product_value_order', 'asc')]);
		session(['product_type' => $request->has('ok_type') ? $request->type : session('product_type', 'All')]);
		session(['product_limit' => $request->has('ok_limit') ? $request->limit : session('product_limit', '6')]);
		session(['product_status' => $request->has('ok_status') ? $request->status : session('product_status', 'active')]);

		//fetch data
		$products = Product::where('name', 'like', '%'.session('product_name').'%')
			->orderBy(session('product_type_order'), session('product_value_order'));

		//filter type
		if(session('product_type') == 'Bracelet') $products->where('code', 'like', 'G%');
		elseif(session('product_type') == 'Ring') $products->where('code', 'like', 'C%');

		//filter status
		if(session('product_status') == 'inactive') $products->onlyTrashed();
		elseif(session('product_status') == 'all') $products->withTrashed();

		//count total qty
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

	public function resetList()
	{
		session(['product_name' => '']);

		return redirect()->action('ProductController@dataList');
	}

	public function activatePost($product)
	{
        DB::beginTransaction();

		//retrieve data
		$product = Product::withTrashed()->find($product);
		if($product->restore())
		{
			//create model UserLog
			$log = UserLog::create([
				'created_at' => date('Y-m-d H:i:s'),
				'user_id' => Auth::id(),
				'description' => 'Product #' . $product->id . ': activate product',
			]);

			if($log) {
				goto success;
			}
		}

		DB::rollBack();
		return response()->json([
			'status' => 'fail',
			'alert_messages' => 'Terjadi kesalahan.',
		]);

		success:
		DB::commit();
		return response()->json([
			'status' => 'success',
			'link' => 'admin.products.index',
			'alert_type' => 'alert-success',
			'alert_title' => 'Success!',
			'alert_messages' => 'Product ' . $product->name . ' is activated.',
		]);
	}
}
