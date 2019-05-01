<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyTogetherRequest extends FormRequest {
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
					'title' => 'required|string',
					'asin.1' => 'required|max:10|min:10',
					'quentity.1' => 'required',
					'asin.2' => 'required|max:10|min:10',
					'quentity.2' => 'required',
				];
			}
		case 'PUT':
		case 'PATCH':
			{
				return [
					'title' => 'required|string',
					'asin.1' => 'required|max:10|min:10',
					'quentity.1' => 'required',
					'asin.2' => 'required|max:10|min:10',
					'quentity.2' => 'required',
				];
			}
		default:break;
		}
	}
}
