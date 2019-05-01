<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandStorefrontRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		switch ($this->method()) {
		case 'GET':
		case 'DELETE':
			{
				return [];
			}
		case 'POST':
			{
				if (@$this->input('types') == 5):
					return [
						'title' => 'required',
						'marketplace' => 'required',
						'brand' => 'required',
						'keyword.*' => 'required',
					];
				elseif (@$this->input('types') == 6):
					return [
						'title' => 'required',
						'marketplace' => 'required',
						'storefront' => 'required|min:10|max:14',
						'keyword.*' => 'required',
					];
				else:
					return [
						'title' => 'required',
						'marketplace' => 'required',
						'keyword.*' => 'required',
					];
				endif;
			}
		case 'PUT':
		case 'PATCH':
			{
				return [
					'title' => 'required',
					'marketplace' => 'required',
					'keyword.*' => 'required',
				];

			}
		default:break;
		}
	}
	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages() {
		return [
			'keyword.*.required' => 'The :attributes field is required.',
			'title.required' => 'The friendly name field is required.',
		];
	}

	/**
	 * Get custom attributes for validator errors.
	 *
	 * @return array
	 */
	public function attributes() {
		return [
			'keyword.*' => 'keyword',
		];
	}
}
