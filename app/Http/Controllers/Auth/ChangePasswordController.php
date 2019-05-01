<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		return view('auth.passwords.change-password');
	}

	/**
	 * Change password
	 *
	 **/
	public function changePassword(Request $request) {

		$messages = [
			'current_password.required' => 'Please enter current password',
			'new_password.required' => 'Please enter password',
		];

		$validator = Validator::make($request->all(), [
			'current_password' => 'required',
			'new_password' => 'required|min:8',
			'password_confirmation' => 'required|same:new_password',
		], $messages);
		if ($validator->fails()) {
			return redirect('change-password')
				->withErrors($validator)
				->withInput();
		}
		try {
			$current_password = Auth::user()->password;
			// check current password
			if (Hash::check($request->current_password, $current_password)) {
				$user_id = Auth::user()->id;
				$obj_user = User::find($user_id);
				$obj_user->password = Hash::make($request->new_password);
				$obj_user->save();
				$error = array('success' => 'Password successfully changed');
				return redirect('change-password')
					->withErrors($error)
					->withInput();
			} else {
				$error = array('current_password' => 'Please enter correct current password');
				return redirect('change-password')
					->withErrors($error)
					->withInput();
			}
		} catch (Exception $e) {
			$error = array('error' => $e->getMessage());
			return redirect('change-password')
				->withErrors($error)
				->withInput();
		}
	}

}
