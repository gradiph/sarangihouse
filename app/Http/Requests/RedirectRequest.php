<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RedirectRequest extends FormRequest
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
    public function rules()
    {
        return [
            'link' => [
				'required',
			],
			'alert_type' => [
				Rule::in(['alert-danger', 'alert-success']),
				'required_with_all:alert_title,alert_messages',
			],
			'alert_title' => [
				'required_with_all:alert_type,alert_messages',
			],
			'alert_messages' => 'required_with_all:alert_title,alert_type',
        ];
    }
}
