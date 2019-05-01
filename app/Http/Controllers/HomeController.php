<?php

namespace App\Http\Controllers;
use App\Models\Plan;
use App\Models\Subscriptions;
use Auth;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index() {
		$plans = Plan::orderBy('id', 'desc')->get();
		$subscription = '';
		if (Auth::check()) {

			$subscription = Subscriptions::whereUserId(Auth::user()->id)->orderBy('id', 'desc')->first();
		}
		return view('front.dashboard.landing', compact('subscription', 'plans'));
	}
}
