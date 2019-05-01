<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\GoogleController;
use App\Models\Campaigns;
use App\Models\TrackingLinks;
use App\User;
use Illuminate\Http\Request;

class CampaignsController extends GoogleController {
	/** Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('admin');
	}

	/**
	 * Show the application campaigns.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$campaigns = Campaigns::with('countTakingLinks')->paginate(10);
		return view('backend.campaigns.index', compact('campaigns'));

	}

	/**
	 * Show the application campaigns details.
	 *
	 *@param Illuminate\Http\Request; $id
	 * @return \Illuminate\Http\Response
	 */
	public function detail($id) {
		$tokens = self::refreshToken();
		$endDate = Date('Y-m-d');
		$user = User::find($id);
		$startDate = $user->created_at->format('Y-m-d');
		$campaigns = Campaigns::whereUserId($id)->with('countTakingLinks')->paginate(10);
		$links = TrackingLinks::whereUserId($id)->with('getUrlType')->get();
		$filter = '';
		foreach ($links as $link):
			$filter .= 'ga:pagePath=~/' . $link->uniqe_url . ',';
		endforeach;
		$filter = rtrim($filter, ",");
		$urlRequest = urldecode('https://www.googleapis.com/analytics/v3/data/ga?ids=ga:193566229&start-date=' . $startDate . '&end-date=' . $endDate . '&metrics=ga:pageviews,ga:uniquePageviews&dimensions=ga:date,ga:pagePath&filters=' . $filter . '&access_token=' . $tokens->access_token);

		$res = self::sendGetData($urlRequest);
		$clicks = (object) json_decode($res);
		$allCliks = array();
		if (isset($clicks->totalsForAllResults)):
			foreach ($clicks->totalsForAllResults as $result):
				$allCliks[] = $result;
			endforeach;
		endif;
		return view('backend.campaigns.detail', compact('campaigns', 'user', 'links', 'allCliks', 'clicks'));

	}

	/**
	 * Show the application a campaign detail.
	 *
	 *@param Illuminate\Http\Request; $campId
	 * @return \Illuminate\Http\Response
	 */
	public function single($campId) {
		$tokens = self::refreshToken();
		$endDate = Date('Y-m-d');

		$campaign = Campaigns::whereId($campId)->with('countTakingLinks', 'getUser')->first();
		$startDate = $campaign->getUser->created_at->format('Y-m-d');
		$filter = '';
		foreach ($campaign->countTakingLinks as $link):
			$filter .= 'ga:pagePath=~/' . $link->uniqe_url . ',';
		endforeach;
		$filter = rtrim($filter, ",");
		$urlRequest = urldecode('https://www.googleapis.com/analytics/v3/data/ga?ids=ga:193566229&start-date=' . $startDate . '&end-date=' . $endDate . '&metrics=ga:pageviews,ga:uniquePageviews&dimensions=ga:date,ga:pagePath&filters=' . $filter . '&access_token=' . $tokens->access_token);
		$res = self::sendGetData($urlRequest);
		$clicks = (object) json_decode($res);
		$allCliks = array();
		if (isset($clicks->totalsForAllResults)):
			foreach ($clicks->totalsForAllResults as $result):
				$allCliks[] = $result;
			endforeach;
		endif;
		return view('backend.campaigns.single', compact('campaign', 'clicks', 'allCliks'));

	}

}
