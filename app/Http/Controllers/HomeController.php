<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    public function welcome()
	{
		return view('welcome');
	}

	public function product(Product $product)
	{
		return view('layouts.base.product');
	}

	public function home()
	{
		if(Auth::check())
		{
			if(Auth::user()->level == 'Admin')
			{
				return redirect()->route('admin.home')->with([
					'alert_type' => 'alert-success',
					'alert_title' => 'Welcome!',
					'alert_messages' => 'You have successfully logged in.',
				]);
			}
			elseif(Auth::user()->level == 'Member')
			{
				return redirect()->route('member.home')->with([
					'alert_type' => 'alert-success',
					'alert_title' => 'Welcome!',
					'alert_messages' => 'You have successfully logged in.',
				]);
			}
		}

		//failed authentication
		Auth::logout();

		return redirect()->route('login')->with([
			'alert_type' => 'alert-danger',
			'alert_title' => 'Warning!',
			'alert_messages' => 'Something is wrong. Please try again. (Code: L02)',
		]);
	}
}
