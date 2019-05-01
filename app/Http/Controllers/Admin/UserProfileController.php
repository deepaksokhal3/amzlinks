<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\User;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class UserProfileController extends Controller {
	//

	public function index($id) {
		$user = User::find($id);
		$countries = Countries::all();
		return view('backend.users.update', compact('user', 'countries'));

	}

	/**
	 * update user profile
	 * @param  object  $request
	 * @return status
	 */

	public function update(Request $request) {
		try {
			$user = User::find($request->id);
			$user->exists = true;
			foreach ($request->all() as $key => $field):
				if ($key != "_token") {
					$user->$key = $field;
				}

			endforeach;
			$user->save();
			return redirect()->back()->withSuccess('Profile update successfully.');
		} catch (Exception $e) {
			return redirect()->back()->with('error', $e->getMessage());

		}
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  object $request
	 * @return  \Illuminate\file
	 */
	public function upload(Request $request) {
		$validator = Validator::make($request->all(), [
			'profilePic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2000',

		]);
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}
		try {
			$user = User::find($request->id);
			$image = $request->file('profilePic');
			$imageName = $image->getClientOriginalName();
			$imageName = $user->id . time() . '.' . $image->getClientOriginalExtension();
			$image_resize = Image::make($image->getRealPath());
			$image_resize->resize(50, 50);
			$image_resize->save(public_path('images/35X35' . $imageName));

			$prevImg = public_path('images') . '/' . $user->image;
			$prevImg35 = public_path('images') . '/35X35' . $user->image;
			request()->profilePic->move(public_path('images'), $imageName);

			$user->exists = true;
			$user->id = $request->id;
			$user->image = $imageName;
			$user->save();
			File::delete($prevImg);
			File::delete($prevImg35);
			return back()->with('uploadsuccess', 'You have successfully upload image.');
		} catch (Exception $e) {
			return back();
		}
	}
}
