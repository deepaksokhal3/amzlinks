<?php

namespace App\Http\Controllers;
use App\Models\Campaigns;
use App\Models\TrackingLinks;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignsController extends GoogleController {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');

	}

	/**
	 * Show list compaigns.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		$data['campaigns'] = Campaigns::whereUserId(Auth::user()->id)->with('countTakingLinks')->get();
		$tokens = self::refreshToken();
		$endDate = Date('Y-m-d');
		$startDate = Auth::user()->created_at->format('Y-m-d');
		$links = TrackingLinks::whereUserId(Auth::user()->id)->get();
		$filter = '';
		foreach ($links as $links):
			$filter .= 'ga:pagePath=~/' . $links->uniqe_url . ',';
		endforeach;
		$filter = rtrim($filter, ",");

		$urlRequest = urldecode('https://www.googleapis.com/analytics/v3/data/ga?ids=ga:193566229&start-date=' . $startDate . '&end-date=' . $endDate . '&metrics=ga:pageviews,ga:uniquePageviews&dimensions=ga:pagePath&filters=' . $filter . '&access_token=' . $tokens->access_token);
		$res = self::sendGetData($urlRequest);
		$data['clicks'] = json_decode($res);

		return view('front.campaigns.index')->with($data);

	}

	/**
	 * Get campaign form values
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request) {
		if (!$request->input('id')) {
			return redirect('campaigns');
		}
		$data['campaign'] = Campaigns::find($request->input('id'));
		return view('front.campaigns.edit')->with($data);
	}

	/**
	 * G Update Campaign
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function update(Request $request) {
		try {
			$campaign = new Campaigns();
			$campaign->exists = true;
			foreach ($request->all() as $key => $field):
				if ($key != "_token") {
					$campaign->$key = $field;
				}

			endforeach;
			$campaign->save();
			return redirect('campaigns');
		} catch (Exception $e) {

		}
	}

	/**
	 *add compaigns
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function add(Request $request) {
		if ($request->isMethod('post')):
			try {
				$validator = Validator::make($request->all(), [
					'campaignName' => 'required',
					'campaignNotes' => 'required',
					'campaignTags' => 'required',
				]);
				if ($validator->fails()) {
					return view('front.campaigns.add')->with(['errors' => $validator->errors()]);
				}

				$request['user_id'] = Auth::user()->id;
				Campaigns::create($request->all());
				return redirect('campaigns');
			} catch (Exception $e) {
				return view('front.campaigns.add');
			} else :
			return view('front.campaigns.add');
		endif;

	}

	/**
	 * Campaign details
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function detail($campId) {
		$tokens = self::refreshToken();
		$endDate = Date('Y-m-d');
		$startDate = Auth::user()->created_at->format('Y-m-d');

		$data['links'] = TrackingLinks::whereCampaignId($campId)->with('getDestinationUrls')->orderBy('id', 'DESC')->get();
		$filter = '';
		foreach ($data['links'] as $links):
			$filter .= 'ga:pagePath=~/' . $links->uniqe_url . ',';
		endforeach;
		$filter = rtrim($filter, ",");
		$urlRequest = urldecode('https://www.googleapis.com/analytics/v3/data/ga?ids=ga:193566229&start-date=' . $startDate . '&end-date=' . $endDate . '&metrics=ga:pageviews,ga:uniquePageviews&dimensions=ga:pagePath&filters=' . $filter . '&access_token=' . $tokens->access_token);
		$res = self::sendGetData($urlRequest);
		$data['clicks'] = (object) json_decode($res);
		$data['allCliks'] = array();
		if (isset($data['clicks']->totalsForAllResults)):
			foreach ($data['clicks']->totalsForAllResults as $result):
				$data['allCliks'][] = $result;
			endforeach;
		endif;
		$data['campaign'] = Campaigns::find($campId);
		return view('front.campaigns.detail')->with($data);

	}

	/**
	 * Delete the application campaigns.
	 *
	 *@param Illuminate\Http\Request; $id
	 * @return \Illuminate\Http\Response
	 */
	public function drop(Request $request) {
		if ($request->ajax() && $request->input('id')):
			try {
				Campaigns::destroy($request->input('id'));
				echo json_encode(array('sucsess' => 'Campaign delete successfully.'));
			} catch (Exception $e) {
				echo json_encode(array('error' => $e->getMessage()));
			}
		endif;
	}

}
