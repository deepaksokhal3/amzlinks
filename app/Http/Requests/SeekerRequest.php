<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeekerRequest extends FormRequest {
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
				return [
					'title' => 'required',
					'marketplace' => 'required',
					'asin.*' => 'required|min:10|max:10',
					'keyword.*' => 'required',
					'percentage.*' => 'required',
				];
			}
		case 'PUT':
		case 'PATCH':
			{
				return [
					'title' => 'required',
					'marketplace' => 'required',
					'asin.*' => 'required|min:10|max:10',
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
			'asin.*.required' => 'The asin field is required.',
			'asin.*.min' => 'The asin must be at least 10 characters.',
			'asin.*.max' => 'The asin must be at least 10 characters.',
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
