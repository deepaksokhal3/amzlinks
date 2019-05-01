<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller {

	/** Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('admin');
	}

	public function index() {
		$users = User::whereRole('subscriber')->with('userSubscription')->orderBy('id', 'desc')->paginate(10);
		return view('backend.users.index', compact('users'));
	}

	public function update(Request $request) {
		if ($request->ajax() && $request->input('id')):
			try {
				$user = User::find($request->id);
				$user->exists = true;
				foreach ($request->all() as $key => $field):
					if ($key != "_token") {
						$user->$key = $field;
					}
				endforeach;
				$user->save();
				$message = $request->is_active == 1 ? ucfirst($user->name) . ' unblocked successfully' : ucfirst($user->name) . ' blocked successfully';
				echo json_encode(array('sucsess' => $message));
			} catch (Exception $e) {
				echo json_encode(array('error' => $e->getMessage()));
			}
		endif;
	}

}
