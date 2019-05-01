<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\GoogleController;
use App\Models\Campaigns;
use App\Models\TrackingLinks;
use App\User;
use Auth;

class DashboardController extends GoogleController {
	//

	/** Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {

		$tokens = self::refreshToken();
		$endDate = Date('Y-m-d');
		$user = Auth::user();
		$startDate = "2019-02-01";

		$urlRequest = urldecode('https://www.googleapis.com/analytics/v3/data/ga?ids=ga:193566229&start-date=' . $startDate . '&end-date=' . $endDate . '&metrics=ga:users,ga:newUsers&dimensions=ga:date&access_token=' . $tokens->access_token);

		$res = self::sendGetData($urlRequest);
		$analytic = (object) json_decode($res);
		$totalLinks = TrackingLinks::count();
		$totalUser = User::whereRole('subscriber')->count();
		$totalCampaign = Campaigns::count();
		return view('backend.dashboard.index', compact('totalLinks', 'totalUser', 'totalCampaign', 'analytic'));
	}

}
