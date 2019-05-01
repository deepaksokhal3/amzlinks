<?php

namespace App\Http\Controllers;

class PagesController extends Controller {
	//

	/**
	 * Show the application Contact page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('front.terms');
	}

	/**
	 * Show the application Contact page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function policy() {
		return view('front.privacy-policy');
	}
}
