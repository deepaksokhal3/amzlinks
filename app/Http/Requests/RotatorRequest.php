<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RotatorRequest extends FormRequest {
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
				$roules = [
					'title' => 'required',
					'redirect_mode_id' => 'required',
				];

				foreach (@$this->input('destination') as $key => $destination) {

					if (is_numeric($key) && !isset($this->input('destination')['select'])) {
						$roules['destination.*'] = 'required';
					}

				}
				return $roules;
			}
		case 'PUT':
		case 'PATCH':
			{
				return [
					'title' => 'required',
					'redirect_mode_id' => 'required',
					'destination.*' => 'required',
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
			'title.required' => 'The friendly name field is required.',
			'destination.*.required' => 'The destination url field is required.',
		];
	}

}
