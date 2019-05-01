<?php

namespace App\Http\Controllers;
use App\Models\Campaigns;
use App\Models\Subscriptions;
use App\Models\TrackingLinks;
use App\User;
use Auth;
use DB;
use Helper;
use Session;

class DashboardController extends GoogleController {

	/**
	 * Show the application Analytics reports of compaigns.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$plainDetails = Helper::checkSubscriptionPlanPolicy();
		$tokens = self::refreshToken();
		$endDate = Date('Y-m-d');
		$startDate = Auth::user()->created_at->format('Y-m-d');
		$totlaCamp = Campaigns::whereUserId(Auth::user()->id)->get()->count();
		$links = TrackingLinks::whereUserId(Auth::user()->id)->orderBy('id', 'DESC')->get();
		// Google analytics apply file
		$filter = '';
		foreach ($links as $link):
			$filter .= 'ga:pagePath=~/' . $link->uniqe_url . ',';
		endforeach;
		$filter = rtrim($filter, ",");
		$urlRequest = urldecode('https://www.googleapis.com/analytics/v3/data/ga?ids=ga:193566229&start-date=' . $startDate . '&end-date=' . $endDate . '&metrics=ga:pageviews,ga:uniquePageviews&dimensions=ga:date,ga:pagePath,ga:browser,ga:operatingSystem,ga:countryIsoCode,ga:city&filters=' . $filter . '&access_token=' . $tokens->access_token);
		$res = self::sendGetData($urlRequest);

		$analytics = (object) json_decode($res);
		$allCliks = array();
		if (isset($analytics->totalsForAllResults)):
			foreach ($analytics->totalsForAllResults as $result):
				$allCliks[] = $result;
			endforeach;
		endif;
		if (isset($plainDetails['userSubscription'])) {
			$reachedLimit = isset($plainDetails['totalClicks']) ? $plainDetails['totalClicks'] : 0;

			$currentPlan = $plainDetails['userSubscription']->name;

			if ($plainDetails['userSubscription']->name == 'Free') {
				$text = isset($plainDetails['totalClicks']) && $plainDetails['totalClicks'] < 1000 ? 'You have not yet reached the 1,000 click limit. To send more than 1,000 clicks, please upgrade your plan' : 'You have reached the limit of ' . $reachedLimit . ' clicks under your "' . $currentPlan . '" plan , kindly upgrade to get more clicks';

				$plainDetails['totalClicks'] < 1000 ? Session::flash('alert-class', 'alert-primary') : Session::flash('alert-class', 'alert-danger');
			} else {
				$text = isset($plainDetails['totalClicks']) && $plainDetails['totalClicks'] < 20000 ? 'You have not yet reached the 20,000 click limit. To send more than 20,000 clicks, please upgrade your plan' : 'You have reached the limit of ' . $reachedLimit . ' clicks under your "' . $currentPlan . '" plan , kindly upgrade to get more clicks';
				$plainDetails['totalClicks'] < 20000 ? Session::flash('alert-class', 'alert-primary') : Session::flash('alert-class', 'alert-danger');
			}
			Session::flash('message', $text);

		}
		return view('front.dashboard.dashboard', compact('links', 'allCliks', 'totlaCamp', 'analytics'));

	}

	public function cron() {
		try {

			$users = DB::table('user_subscriptions')->get();
			foreach ($users as $key => $value) {
				Subscriptions::create([
					'id' => $value->id,
					'user_id' => $value->user_id,
					'name' => $value->sub_id == 1 ? 'Free' : 'Professional',
					'stripe_plan' => $value->sub_id == 1 ? 'plan_free' : 'plan_EqZKxJbaVcUXVr',
					'type' => 'New',
					'quantity' => 1,
					'created_at' => $value->created_at,
					'updated_at' => $value->updated_at,
				]);
			}

		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}

}
