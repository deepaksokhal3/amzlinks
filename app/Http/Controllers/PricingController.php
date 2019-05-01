<?php

namespace App\Http\Controllers;
use App\Models\Plan;
use App\Models\Subscriptions;
use Auth;

class PricingController extends Controller {

/**
 * Show the application subscription pricing
 *
 * @return \Illuminate\Http\Response
 */
	public function index() {
		$plans = Plan::orderBy('id', 'desc')->get();
		if (Auth::check()) {
			$subscription = Subscriptions::whereUserId(Auth::user()->id)->orderBy('id', 'desc')->first();
		}
		return view('front.pricing.index', compact('subscription', 'plans'));
	}
}
