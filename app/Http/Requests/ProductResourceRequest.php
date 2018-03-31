<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ProductResourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		if(Auth::check())
		{
			if(Auth::user()->level == 'Admin')
			{
				return true;
			}
		}
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		switch($this->method())
		{
			case 'POST':
			{
				return [
					'code' => 'required|string',
					'name' => 'required|string',
					'price' => 'required|integer|min:0',
					'qty' => 'required|integer|min:0',
				];
			}
			case 'PUT':
			{
				return [
					'code' => 'required|string',
					'name' => 'required|string',
					'price' => 'required|integer|min:0',
					'qty' => 'required|integer|min:0',
				];
			}
			default:break;
		}
    }
}
