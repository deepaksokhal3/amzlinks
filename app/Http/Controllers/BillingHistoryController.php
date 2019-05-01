<?php

namespace App\Http\Controllers;
use App\Models\Subscriptions;
use Auth;

class BillingHistoryController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application billing history.
	 *
	 * @param \Illuminate\Http\Request by Auth User
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$hostory = Subscriptions::whereUserId(Auth::user()->id)->orderBy('id', 'desc')->get();
		return view('front.billing.index', compact('hostory'));
	}
}
