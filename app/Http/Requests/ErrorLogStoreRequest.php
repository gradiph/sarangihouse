<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ErrorLogStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
		return [
            'created_at' => 'required|date',
			'user_id' => 'nullable|integer' . $request->has('user_id') ? '|exists:users,id' : '',
			'description' => 'required|string',
			'action' => 'required|string',
			'errorThrown' => 'required|string',
			'status' => [
				Rule::in(['Waiting', 'Process', 'Clear']),
			],
        ];
    }
}
