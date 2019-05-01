<?php

namespace App\Http\Controllers;

use App\Models\Oauth;
use Illuminate\Http\Request;

class ConnectController extends GoogleController {
	const active = 'connect';
	const title = 'Connect Analytics';

	/**
	 * Show the application index.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$title = array(
			'active' => self::active,
			'title' => self::title,
		);
		//refresh access token
		$analytic = self::refreshToken();

		$accounts = '';
		if ($analytic && $analytic->accountid == '') {
			$accounts = self::getAnalyticAccounts($analytic);
		}
		return view('pages.connect.index', compact('title', 'analytic', 'accounts'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return void
	 */
	public function update(Request $request, Oauth $connect) {
		$connect->accountid = $request->accountid;
		$connect->save();

		$request->session()->flash('success', "Analytic account selected");
		return redirect()->route('connect.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Request $request
	 * @param  \App\Models\Oauth $connect
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 */
	public function destroy(Request $request, Oauth $connect) {
		$request->session()->flash('success', "Google analytic account removed");
		$connect->delete();
		return redirect()->route('connect.index');
	}

}
