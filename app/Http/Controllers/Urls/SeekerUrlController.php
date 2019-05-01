<?php

namespace App\Http\Controllers\Urls;
use App\Http\Controllers\Controller;
use App\Http\Requests\SeekerRequest;
use App\Models\DestinationLinks;
use App\Models\SelectedPixelCodes;
use App\Models\TrackingLinks;
use Auth;
use Exception;
use Helper;
use Illuminate\Http\Request;

class SeekerUrlController extends Controller {
	//

	/**
	 * Create the application (seeker url) Tracking Links
	 *
	 * @param App\Http\Request\SeekerRequest; $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(SeekerRequest $request) {
		if (!Helper::checkSubscription()) {
			return redirect('/subscription');
		}
		try {
			$trackingLinks = new TrackingLinks();
			$trackingLinks->user_subscription_id = Helper::currentSubscription()->id;
			$trackingLinks->user_id = Auth::user()->id;
			$trackingLinks->uniqe_url = 'm' . uniqid(); // set unique url id
			$trackingLinks->hide_ref_url = false;
			$trackingLinks->asin = json_encode($request->asin);
			$trackingLinks->keyword = json_encode($request->keyword);
			$trackingLinks->title = $request->title;
			$trackingLinks->redirect_mode_id = isset($request->redirect_mode_id) ? $request->redirect_mode_id : 1;
			$trackingLinks->campaign_id = $request->campaign_id;
			$trackingLinks->marketplace = $request->marketplace;
			$trackingLinks->intermediate_page = isset($request->intermediate_page) ? $request->intermediate_page : '';
			$trackingLinks->types = $request->types;
			$trackingLinks->save();
			$request['asin'] = json_encode($request->asin);
			if ($request->types != 2) {
				foreach ($request->keyword as $key => $keyword) {
					$request['keyword'] = json_encode(array($keyword));
					$destination_url = Helper::setUrl($request);
					$destinationsLinks[] = array(
						'tracking_link_id' => $trackingLinks->id,
						'destination_url' => $destination_url,
						'type' => 'NO',
						'unique_url' => 'sb' . uniqid(),
						'percentage' => isset($request->percentage[$key]) ? $request->percentage[$key] : 0,
					);
				}
				DestinationLinks::insert($destinationsLinks);
			}
			if ($request->pixelcodes) {
				foreach ($request->pixelcodes as $id) {
					$SelectedPixelCodes[] = array(
						'tracking_link_id' => $trackingLinks->id,
						'tracking_code_id' => $id,
					);
				}
				SelectedPixelCodes::insert($SelectedPixelCodes);
			}
			return redirect('tracking-links')->withSucess('Url successfully created');
		} catch (\Exception $e) {
			return redirect()->back()->withErrors(['error' => 'oops! Some technical issue is occurred. Try again']);
		}
	}

	/**
	 * update the application (seeker url) Tracking Links
	 *
	 * @param TrackingLinks $link
	 * @param Illuminate\Http\Request; $requested data
	 * @return \Illuminate\Http\Response
	 */
	public function update(SeekerRequest $request, TrackingLinks $link) {
		try {
			$link->title = $request->title;
			$link->marketplace = $request->marketplace;
			$link->asin = json_encode($request->asin);
			$link->keyword = json_encode($request->keyword);
			$link->redirect_mode_id = isset($request->redirect_mode_id) ? $request->redirect_mode_id : 1;
			$link->intermediate_page = isset($request->intermediate_page) ? $request->intermediate_page : '';
			$link->campaign_id = $request->campaign_id;
			if ($request->types != 2) {
				$request['asin'] = json_encode($request->asin);
				DestinationLinks::whereTrackingLinkId($link->id)->delete();
				foreach ($request->keyword as $key => $keyword) {
					$request['keyword'] = json_encode(array($keyword));
					$destination_url = Helper::setUrl($request);
					$destinationsLinks[] = array(
						'tracking_link_id' => $link->id,
						'destination_url' => $destination_url,
						'type' => 'NO',
						'unique_url' => 'sb' . uniqid(),
						'percentage' => isset($request->percentage[$key]) ? $request->percentage[$key] : 0,
					);
				}
				DestinationLinks::insert($destinationsLinks);
			}

			if ($request->pixelcodes):
				SelectedPixelCodes::whereTrackingLinkId($link->id)->delete();
				foreach ($request->pixelcodes as $id):
					$SelectedPixelCodes[] = array(
						'tracking_link_id' => $link->id,
						'tracking_code_id' => $id,
					);
				endforeach;
				SelectedPixelCodes::insert($SelectedPixelCodes);
			endif;
			$request->session()->flash('success', $link->getUrlType->name . " Updated successfully");
			$link->save();
			return redirect('tracking-links')->withSucess('Url successfully updated');
		} catch (\Exception $e) {
			return redirect()->back()->withErrors(['error' => 'oops! Some technical issue is occurred. Try again']);
		}
	}

}
