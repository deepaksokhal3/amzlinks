<?php

namespace App\Http\Controllers\Urls;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandStorefrontRequest;
use App\Models\DestinationLinks;
use App\Models\SelectedPixelCodes;
use App\Models\TrackingLinks;
use Auth;
use Exception;
use Helper;
use Illuminate\Http\Request;

class BrandStorefrontController extends Controller {

	/**
	 * Show the application Tracking Links page for create
	 *
	 * @param Illuminate\Http\Requests\BrandStorefrontRequest; $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(BrandStorefrontRequest $request) {
		if (!Helper::checkSubscription()) {
			return redirect('/subscription');
		}
		try {
			$trackingLinks = new TrackingLinks();
			$trackingLinks->user_subscription_id = Helper::currentSubscription()->id;
			$trackingLinks->user_id = Auth::user()->id;
			$trackingLinks->uniqe_url = 'm' . uniqid(); // set unique url id
			$trackingLinks->hide_ref_url = false;
			if ($request->types == 5) {
				$trackingLinks->brand = $request->brand;
			} else {
				$trackingLinks->storefront = $request->storefront;
			}
			$trackingLinks->asin = json_encode($request->asin);
			$trackingLinks->keyword = json_encode($request->keyword);
			$trackingLinks->title = $request->title;
			$trackingLinks->marketplace = $request->marketplace;
			$trackingLinks->redirect_mode_id = isset($request->redirect_mode_id) ? $request->redirect_mode_id : 1;
			$trackingLinks->campaign_id = $request->campaign_id;
			$trackingLinks->min_price = $request->min_price;
			$trackingLinks->max_price = $request->max_price;
			$trackingLinks->types = $request->types;
			$trackingLinks->save();
			$request['asin'] = json_encode($request->asin);
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
	 * Update the specified resource in storage.
	 *
	 * @param UsersRequest $request
	 * @param  \App\Models\TrackingLinks $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(BrandStorefrontRequest $request, TrackingLinks $link) {
		try {

			$link->title = $request->title;
			$link->marketplace = $request->marketplace;
			if ($link->types == 5) {
				$link->brand = $request->brand;
			} else {
				$link->storefront = $request->storefront;
			}
			$link->keyword = json_encode($request->keyword);
			$link->asin = json_encode($request->asin);
			$link->redirect_mode_id = isset($request->redirect_mode_id) ? $request->redirect_mode_id : 1;
			$link->min_price = $request->min_price;
			$link->max_price = $request->max_price;
			$link->campaign_id = $request->campaign_id;
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
			if ($request->pixelcodes):
				SelectedPixelCodes::whereTrackingLinkId($link->id)->delete();
				foreach ($request->pixelcodes as $id):
					$SelectedPixelCodes = array(
						'tracking_link_id' => $link->id,
						'tracking_code_id' => $id,
					);
					SelectedPixelCodes::create($SelectedPixelCodes);
				endforeach;
			endif;
			$request->session()->flash('success', $link->getUrlType->name . " Updated successfully");
			$link->save();
			return redirect('tracking-links');
		} catch (\Exception $e) {
			return redirect()->back()->withErrors(['error' => 'oops! Some technical issue is occurred. Try again']);
		}
	}

}
