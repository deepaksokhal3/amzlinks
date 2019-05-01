<?php

namespace App\Http\Controllers\Urls;

use App\Http\Controllers\Controller;
use App\Http\Requests\CanonicalRequest;
use App\Models\SelectedPixelCodes;
use App\Models\TrackingLinks;
use Auth;
use Helper;

class CanonicalController extends Controller {
	/**
	 * Show the application Tracking Links page for create
	 *
	 * @param Illuminate\Http\Requests\BrandStorefrontRequest; $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CanonicalRequest $request) {
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
			$trackingLinks->marketplace = $request->marketplace;
			$trackingLinks->keyword = json_encode($request->keyword);
			$trackingLinks->intermediate_page = isset($request->intermediate_page) ? $request->intermediate_page : '';
			$trackingLinks->title = $request->title;
			$trackingLinks->campaign_id = $request->campaign_id;
			$trackingLinks->types = $request->types;
			$trackingLinks->save();
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
		} catch (Exception $e) {
			return redirect('tracking-links/seeker');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param UsersRequest $request
	 * @param  \App\Models\TrackingLinks $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(CanonicalRequest $request, TrackingLinks $link) {
		try {
			$link->title = $request->title;
			$link->asin = json_encode($request->asin);
			$link->keyword = json_encode($request->keyword);
			$link->marketplace = $request->marketplace;
			$link->intermediate_page = isset($request->intermediate_page) ? $request->intermediate_page : '';
			$link->campaign_id = $request->campaign_id;
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
			return redirect('tracking-links');
		} catch (Exception $e) {
			return redirect('tracking-links');
		}
	}
}
