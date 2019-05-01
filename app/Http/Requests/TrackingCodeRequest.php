<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackingCodeRequest extends FormRequest {
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
					'trackTitle' => 'required',
					'type' => 'required',
					'trackCode' => 'required',
				];
			}
		case 'PUT':
		case 'PATCH':
			{
				return [
					'trackTitle' => 'required',
					'type' => 'required',
					'trackCode' => 'required',
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
			'trackTitle' => 'The tracking name field is required.',
			'type' => 'The type of code field is required.',
			'trackCode' => 'The tracking code field is required.',
		];
	}
}
