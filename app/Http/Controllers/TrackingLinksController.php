<?php

namespace App\Http\Controllers;
use App\Http\Requests\RotatorRequest;
use App\Models\Campaigns;
use App\Models\Countries;
use App\Models\DestinationLinks;
use App\Models\RedirectMode;
use App\Models\SelectedPixelCodes;
use App\Models\TrackingLinks;
use App\Models\Tracks;
use App\Models\UrlType;
use Auth;
use Exception;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use View;

class TrackingLinksController extends GoogleController {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	private $urlTypes = ['rotator' => 'ROTATOR URL', 'seeker' => 'SEEKER(SFB) URL'];
	public function __construct() {
		$this->middleware('auth');

	}

	/**
	 * Show the application Tracking Links
	 *
	 * @param Illuminate\Http\Request; ny Auth user
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		$tokens = self::refreshToken();
		$endDate = Date('Y-m-d');
		$startDate = Auth::user()->created_at->format('Y-m-d');

		$links = TrackingLinks::whereUserId(Auth::user()->id)->with('getDestinationUrls', 'redirectMode', 'getTrackingLogs', 'getUrlType')->orderBy('id', 'DESC')->get();

		// Google analytics apply filer
		$filter = '';
		foreach ($links as $link):
			$filter .= 'ga:pagePath=~/' . $link->uniqe_url . ',';
		endforeach;
		$filter = rtrim($filter, ",");
		$urlRequest = urldecode('https://www.googleapis.com/analytics/v3/data/ga?ids=ga:193566229&start-date=' . $startDate . '&end-date=' . $endDate . '&metrics=ga:pageviews,ga:uniquePageviews&dimensions=ga:pagePath&filters=' . $filter . '&access_token=' . $tokens->access_token);
		$res = self::sendGetData($urlRequest);

		$clicks = (object) json_decode($res);
		$allCliks = array();
		if (isset($clicks->totalsForAllResults)):
			foreach ($clicks->totalsForAllResults as $result):
				$allCliks[] = $result;
			endforeach;
		endif;
		return view('front.tracking-link.index', compact('links', 'clicks', 'allCliks'));
	}

	/**
	 * SELECT the application type of Tracking url
	 * @return \Illuminate\Http\Response
	 */
	public function selectUrlType() {
		$types = UrlType::all();
		return view('front.tracking-link.select-tracking-link', compact('types'));
	}

	/**
	 * Show the application Tracking Links page for create
	 *
	 * @param Illuminate\Http\Request; $requested data
	 * @return \Illuminate\Http\Response
	 */
	public function add(String $type) {
		if (!Helper::checkSubscription()) {
			return redirect('/subscription');
		}
		return self::switchAddUrl(UrlType::whereCode(trim($type))->first());
	}

	/**
	 * Update the application Tracking Links
	 *
	 * @param Illuminate\Http\Request; $requested data
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request) {
		if (!$request->input('id')) {
			return redirect('tracking-links');
		}
		return self::switchEditUrl(TrackingLinks::whereId($request->input('id'))->with('getDestinationUrls', 'redirectMode', 'getSelectedTrackingCode', 'getUrlType')->first());
	}

	/**
	 * Create the application Tracking Links
	 *
	 * @param App\Http\Requests\RotatorRequest; $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(RotatorRequest $request) {
		if (!Helper::checkSubscription()) {
			return redirect('/subscription');
		}

		try {
			$request['user_id'] = Auth::user()->id;
			$request['user_subscription_id'] = Helper::currentSubscription()->id;
			$request['uniqe_url'] = 'm' . uniqid(); // set unique url id
			$request['hide_ref_url'] = false;
			$trackLinks = TrackingLinks::create($request->all()); // create rotator url

			// Add Multiple Pixel code
			if ($request->pixelcodes) {
				foreach ($request->pixelcodes as $id) {
					$SelectedPixelCodes[] = array(
						'tracking_link_id' => $trackLinks->id,
						'tracking_code_id' => $id,
					);
				}
				SelectedPixelCodes::insert($SelectedPixelCodes);
			}
			$destinationsLinks = array();
			foreach ($request->destination as $key => $link) {
				if ($link && is_numeric($key)):
					$destinationsLinks[] = array(
						'tracking_link_id' => $trackLinks->id,
						'destination_url' => $link,
						'type' => 'NO',
						'unique_url' => 'sb' . uniqid(),
						'percentage' => isset($request->percentage[$key]) ? $request->percentage[$key] : 0, // if redirect mode weighted
					);

				elseif ($link && !is_numeric($key)):
					foreach ($link as $key1 => $selectedLinks):
						if ($selectedLinks):
							$destinationsLinks[] = array(
								'tracking_link_id' => $trackLinks->id,
								'destination_url' => $selectedLinks,
								'type' => 'YES',
								'unique_url' => 'sb' . uniqid(),
								'percentage' => isset($request->percentage[$key1]) ? $request->percentage[$key1] : 0, // if redirect mode weighted
							);
						endif;
					endforeach;
				endif;
			}
			DestinationLinks::insert($destinationsLinks);
			return redirect('tracking-links')->withSucess('Url successfully created');
		} catch (Exception $e) {
			return redirect()->back()->withErrors(['error' => 'oops! Some technical issue is occurred. Try again']);
		}
	}

	/**
	 * update the application (rotator url) Tracking Links
	 *
	 * @param App\Http\Requests\RotatorRequest; $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request) {
		$ids = array();
		$desitantionLinks = array();
		try {
			$trackingLinks = new TrackingLinks();
			$trackingLinks->exists = true;
			$trackingLinks->redirect_mode_id = $request->redirect_mode_id;
			$trackingLinks->campaign_id = $request->campaign_id;
			$trackingLinks->title = $request->title;
			$trackingLinks->id = $request->id;

			if ($request->rmLinkIds) {
				$ids = explode(",", $request->rmLinkIds);
				$test = DestinationLinks::whereIn('id', $ids)->delete();
			}

			foreach ($request->destination as $key => $field):
				if (is_numeric($key)) {
					$destinationLinkData = DestinationLinks::find($key);
					if ($field && !empty($destinationLinkData)) {
						if ($request->redirect_mode_id == 2) {
							$destinationLinkData->exists = true;
							$destinationLinkData->id = $key;
							$destinationLinkData->destination_url = $field;
							$destinationLinkData->percentage = $request->percentage[$key] ? $request->percentage[$key] : 0;

						} else {
							$destinationLinkData->exists = true;
							$destinationLinkData->id = $key;
							$destinationLinkData->destination_url = $field;
						}
						$destinationLinkData->save();
					}

				} else {
					$destination = array();
					foreach ($request->destination[$key] as $key1 => $val):
						if ($key == 'select') {

							$destination[] = [
								'destination_url' => $val,
								'percentage' => isset($request->percentage['new'][$key1]) ? $request->percentage['new'][$key1] : 0,
								'type' => 'YES',
								'tracking_link_id' => $request->id,
								'unique_url' => 'sb' . uniqid(),
							];
						} else if ($val) {
						$destination[] = [
							'destination_url' => $val,
							'percentage' => isset($request->percentage[$key][$key1]) ? $request->percentage[$key][$key1] : 0,
							'type' => 'NO',
							'tracking_link_id' => $request->id,
							'unique_url' => 'sb' . uniqid(),
						];
					}
				endforeach;
				DestinationLinks::insert($destination);
			}
			endforeach;
			if ($request->pixelcodes):
				SelectedPixelCodes::whereTrackingLinkId($request->id)->delete();
				foreach ($request->pixelcodes as $id):
					$SelectedPixelCodes = array(
						'tracking_link_id' => $request->id,
						'tracking_code_id' => $id,
					);
					SelectedPixelCodes::create($SelectedPixelCodes);
				endforeach;
			endif;
			$trackingLinks->save();
			return redirect('tracking-links');
		} catch (Exception $e) {
			return redirect('tracking-links');
		}
	}

	/**
	 * Dalete the application  Tracking Links
	 *
	 * @param Illuminate\Http\Request; id
	 * @return \Illuminate\Http\Response
	 */
	public function drop(Request $request) {
		if ($request->ajax() && $request->input('id')):
			try {
				TrackingLinks::destroy($request->input('id'));
				echo json_encode(array('sucsess' => 'Tracking Links deleted successfully.'));
			} catch (Exception $e) {
				echo json_encode(array('error' => $e->getMessage()));
			}
		endif;
	}

	/**
	 * Action the application Edit Urls form
	 *
	 * @param Illuminate\Http\$types
	 * @return \Illuminate\Http\Response
	 */
	static function switchEditUrl($link) {
		$trackingCodes = $option = $campaigns = [];
		foreach (Countries::orderBy('id', 'DESC')->get() as $country):
			$countries[$country->code] = $country->country_name;
			$flags[$country->code] = ['data-content' => "<i class='" . trim($country->flag) . "'></i>" . $country->country_name];
		endforeach;

		foreach (Tracks::whereUserId(Auth::user()->id)->with('trackingType')->get() as $trackingCode):
			$trackingCodes[$trackingCode->id] = $trackingCode->trackingType->name;
			$option[$trackingCode->id] = ['data-content' => "<i class='" . trim($trackingCode->trackingType->icon) . "'></i>" . $trackingCode->trackingType->name];
		endforeach;

		foreach (Campaigns::whereUserId(Auth::user()->id)->get() as $campaign):
			$campaigns[$campaign->id] = $campaign->campaignName;
		endforeach;
		$SelectedPixelCodes = array();
		foreach ($link->getSelectedTrackingCode as $pixelCodeId):
			$SelectedPixelCodes[] = $pixelCodeId->tracking_code_id;
		endforeach;

		switch ($link->types) {
		case 1: // URL ROTATOR
			$redirect_mode = RedirectMode::all();
			$amazLinks = TrackingLinks::whereUserId(Auth::user()->id)->whereTypes($link->types)->with('getDestinationUrls')->get();
			return view('front.tracking-link.rotator.edit', compact('trackingCodes', 'campaigns', 'link', 'SelectedPixelCodes', 'amazLinks', 'redirect_mode', 'option'));
			break;
		case in_array($link->types, [2, 3, 4]): // SEEKER,2-STEP VIA FIELD-ASIN AND 2-STEP VIA HIDDEN KEYWORD
			foreach (RedirectMode::all() as $modes):
				$redirect_mode[$modes->id] = $modes->name;
			endforeach;
			return view('front.tracking-link.seeker.edit', compact('trackingCodes', 'campaigns', 'link', 'SelectedPixelCodes', 'countries', 'option', 'redirect_mode', 'flags'));
			break;

		case in_array($link->types, [5, 6]): // SEEKER,2-STEP VIA FIELD-ASIN AND 2-STEP VIA HIDDEN KEYWORD
			foreach (RedirectMode::all() as $modes):
				$redirect_mode[$modes->id] = $modes->name;
			endforeach;
			return view('front.tracking-link.brand-storefront.edit', compact('trackingCodes', 'campaigns', 'link', 'SelectedPixelCodes', 'countries', 'option', 'redirect_mode', 'flags'));
			break;
		case 7:
			return view('front.tracking-link.buy-together.edit', compact('trackingCodes', 'campaigns', 'link', 'SelectedPixelCodes', 'countries', 'option', 'flags'));
		case 8:
			return view('front.tracking-link.add-cart.edit', compact('trackingCodes', 'campaigns', 'link', 'SelectedPixelCodes', 'countries', 'option', 'flags'));
			break;
		case 9:
			return view('front.tracking-link.canonical.edit', compact('trackingCodes', 'campaigns', 'link', 'SelectedPixelCodes', 'option', 'countries', 'flags'));
			break;

		default:break;
		}
	}

	/**
	 * Action the application Urls form
	 *
	 * @param Illuminate\Http\$types
	 * @return \Illuminate\Http\Response
	 */
	static function switchAddUrl($types) {
		$trackingCodes = $option = $campaigns = [];
		foreach (Countries::orderBy('id', 'DESC')->get() as $country):
			$countries[$country->code] = $country->country_name;
			$flags[$country->code] = ['data-content' => "<i class='" . trim($country->flag) . "'></i>" . $country->country_name];
		endforeach;

		foreach (Tracks::whereUserId(Auth::user()->id)->with('trackingType')->get() as $trackingCode):
			$trackingCodes[$trackingCode->id] = $trackingCode->trackingType->name;
			$option[$trackingCode->id] = ['data-content' => "<i class='" . trim($trackingCode->trackingType->icon) . "'></i>" . $trackingCode->trackingType->name];
		endforeach;

		foreach (Campaigns::whereUserId(Auth::user()->id)->get() as $campaign):
			$campaigns[$campaign->id] = $campaign->campaignName;
		endforeach;
		$SelectedPixelCodes = [];
		switch ($types->id) {
		case 1: // URL ROTATOR
			$redirect_mode = RedirectMode::all();
			$amazLinks = TrackingLinks::whereUserId(Auth::user()->id)->whereTypes($types->id)->with('getDestinationUrls')->get();
			return view('front.tracking-link.rotator.add', compact('types', 'trackingCodes', 'campaigns', 'amazLinks', 'redirect_mode', 'option', 'SelectedPixelCodes'));
			break;
		case in_array($types->id, [2, 3, 4]): // SEEKER,2-STEP VIA FIELD-ASIN AND 2-STEP VIA HIDDEN KEYWORD
			foreach (RedirectMode::all() as $modes):
				$redirect_mode[$modes->id] = $modes->name;
			endforeach;
			return view('front.tracking-link.seeker.add', compact('types', 'option', 'trackingCodes', 'campaigns', 'countries', 'SelectedPixelCodes', 'redirect_mode', 'flags'));
			break;
		case in_array($types->id, [5, 6]): // 2-STEP VIA BRAND, 2-STEP VIA STOREFRONT
			foreach (RedirectMode::all() as $modes):
				$redirect_mode[$modes->id] = $modes->name;
			endforeach;
			return view('front.tracking-link.brand-storefront.add', compact('types', 'option', 'trackingCodes', 'campaigns', 'countries', 'SelectedPixelCodes', 'redirect_mode', 'flags'));
			break;
		case 7:
			return view('front.tracking-link.buy-together.add', compact('types', 'option', 'trackingCodes', 'campaigns', 'countries', 'SelectedPixelCodes', 'flags'));
		case 8:
			return view('front.tracking-link.add-cart.add', compact('types', 'option', 'trackingCodes', 'campaigns', 'countries', 'SelectedPixelCodes', 'flags'));
			break;
		case 9:
			return view('front.tracking-link.canonical.add', compact('types', 'option', 'trackingCodes', 'campaigns', 'countries', 'SelectedPixelCodes', 'flags'));
			break;

		default:break;
		}
	}
}