<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use App\Models\Countries;
use App\User;
use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application profile data
	 *
	 * @param Illuminate\Http\Request;
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$user = Auth::user();
		$countries = Countries::all();
		return view('front.profile.edit', compact('user', 'countries'));
	}

	/**
	 * Update the application profile data
	 *
	 * @param Illuminate\Http\UserRequest; $requested data
	 * @return \Illuminate\Http\Response
	 */
	public function update(UserRequest $request) {
		try {
			$user = User::find(Auth::user()->id);
			$user->exists = true;
			foreach ($request->all() as $key => $field):
				if ($key != "_token") {
					$user->$key = $field;
				}
			endforeach;
			$user->save();
			Auth::setUser($user);
			return redirect('/profile');
		} catch (Exception $e) {

		}
	}
	/**
	 * Upload the profile images
	 *
	 * @param Illuminate\Http\Request; file data
	 * @return \Illuminate\Http\Response
	 */
	public function upload(Request $request) {
		$validator = Validator::make($request->all(), [
			'profilePic' => 'required|image|mimes:jpeg,png,jpg,gif|max:200',
		]);
		if ($validator->fails()) {
			return redirect('profile')->withErrors($validator)->withInput();
		}
		try {
			$image = $request->file('profilePic');
			$imageName = $image->getClientOriginalName();
			$imageName = Auth::user()->id . time() . '.' . $image->getClientOriginalExtension();
			$image_resize = Image::make($image->getRealPath());
			$image_resize->resize(35, 35, function ($constraint) {
				$constraint->aspectRatio();
			});
			$image_resize->save(public_path('images/35X35' . $imageName)); // Resize image with same ratio
			$prevImg = public_path('images') . '/' . Auth::user()->image;
			$prevImg35 = public_path('images') . '/35X35' . Auth::user()->image;
			request()->profilePic->move(public_path('images'), $imageName);
			$user = User::find(Auth::user()->id);
			$user->exists = true;
			$user->id = Auth::user()->id;
			$user->image = $imageName;
			$user->save();
			Auth::setUser($user);
			File::delete($prevImg);
			File::delete($prevImg35);
			return back()->with('success', 'You have successfully upload image.');
		} catch (Exception $e) {
			return back();
		}
	}
}
