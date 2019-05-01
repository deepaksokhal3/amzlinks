<?php
namespace App\Helpers;
use App\Http\Controllers\GoogleController;
use App\Models\Subscriptions;
use App\Models\TrackingLinks;
use Auth;
use Carbon\Carbon;

class Helper {
	private $skip = 0;
	public static function checkSubscription() {
		try {
			$userSub = Subscriptions::whereUserId(Auth::user()->id)->orderBy('id', 'desc')->first();
			$links = TrackingLinks::whereUserId(Auth::user()->id)->whereUserSubscriptionId($userSub->id)->get();
			$checkPolicyPlan = self::checkSubscriptionPlanPolicy();
			if ($userSub->name == 'Free'):
				$ended = $userSub->type != 'New' && Auth::user()->subscription('Professional')->ends_at ? Auth::user()->subscription('Professional')->ends_at->format('Y-m-d H:i:s') : false;

				$upto = date('Y-m-d H:i:s', strtotime("+1 month", strtotime($userSub->created_at)));
				$upto = ($ended > Carbon::now()->format('Y-m-d H:i:s')) && $ended ? $ended : $upto;
				$flag = ($ended > Carbon::now()->format('Y-m-d H:i:s')) && $ended ? true : false;

				if ($flag) {
					Auth::user()->subscription = ($upto > Carbon::now()->format('Y-m-d') && $checkPolicyPlan['totalClicks'] < 20000) || $upto < Carbon::now()->format('Y-m-d') ? false : true;
				} else {
					Auth::user()->subscription = ((count($links) >= 2 && $upto > Carbon::now()->format('Y-m-d H:i:s')) || ($checkPolicyPlan['totalClicks'] > 1000 && $upto > Carbon::now()->format('Y-m-d H:i:s'))) || ($upto < Carbon::now()->format('Y-m-d H:i:s')) ? false : true;
				}
				Auth::user()->subscriptionName = $userSub->name;
			else:
				if ($userSub->name == 'Professional' && $userSub->type == 'New') {
					$upto = date('Y-m-d H:i:s', strtotime("+1 month", strtotime($userSub->created_at)));
				} else {
					$timestamp = Auth::user()->asStripeCustomer()["subscriptions"]->data[0]["current_period_end"];

					$upto = Carbon::createFromTimeStamp($timestamp)->format('Y-m-d H:i:s');
				}
				Auth::user()->subscription = ($upto > Carbon::now()->format('Y-m-d H:i:s') && $checkPolicyPlan['totalClicks'] > 20000) || ($upto < Carbon::now()->format('Y-m-d H:i:s')) ? false : true;
				Auth::user()->subscriptionName = $userSub->name;
			endif;
			return Auth::user()->subscription;
		} catch (Exception $e) {

		}
	}

	public static function checkSubscriptionPlanPolicy() {
		try {
			$userPlainDetails['userSubscription'] = $userSubscription = Subscriptions::whereUserId(Auth::user()->id)->orderBy('id', 'desc')->first();

			$endSubscriptionDate = $userSubscription->type != 'New' && Auth::user()->subscription('Professional')->ends_at ? Auth::user()->subscription('Professional')->ends_at->format('Y-m-d H:i:s') : $userSubscription->created_at->format('Y-m-d H:i:s');

			if ($endSubscriptionDate > Carbon::now()->format('Y-m-d H:i:s') && $userSubscription->type != 'New') {
				$timestamp = Auth::user()->asStripeCustomer()["subscriptions"]->data[0]["current_period_start"];
				$startDate = Carbon::createFromTimeStamp($timestamp)->format('Y-m-d H:i:s');
				$timestamp = Auth::user()->asStripeCustomer()["subscriptions"]->data[0]["current_period_end"];
				$endDate = Carbon::createFromTimeStamp($timestamp)->format('Y-m-d H:i:s');
			} else if ($userSubscription->name == 'Professional' && $userSubscription->type != 'New') {
				$timestamp = Auth::user()->asStripeCustomer()["subscriptions"]->data[0]["current_period_start"];
				$startDate = Carbon::createFromTimeStamp($timestamp)->format('Y-m-d H:i:s');
				$timestamp = Auth::user()->asStripeCustomer()["subscriptions"]->data[0]["current_period_end"];
				$endDate = Carbon::createFromTimeStamp($timestamp)->format('Y-m-d H:i:s');
			} else if ($userSubscription->name == 'Professional' && $userSubscription->type == 'New') {
				$startDate = $userSubscription->created_at->format('Y-m-d H:i:s');
				$endDate = Carbon::now()->format('Y-m-d H:i:s');
			} else {
				$startDate = $userSubscription->created_at->format('Y-m-d H:i:s');
				$endDate = Carbon::now()->format('Y-m-d H:i:s');
			}
			$startDateG = date('Y-m-d', strtotime($startDate));
			$endDateG = date('Y-m-d', strtotime($endDate));
			$links = TrackingLinks::whereUserSubscriptionId($userSubscription->id)->whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'DESC')->get();
			$userPlainDetails['totalClicks'] = 0;
			if ($links->count() > 0) {
				$tokens = GoogleController::refreshToken();
				// Google analytics apply filer
				$filter = '';
				foreach ($links as $link):
					$filter .= 'ga:pagePath=~/' . $link->uniqe_url . ',';
				endforeach;
				$filter = rtrim($filter, ",");
				$urlRequest = urldecode('https://www.googleapis.com/analytics/v3/data/ga?ids=ga:193566229&start-date=' . $startDateG . '&end-date=' . $endDateG . '&metrics=ga:pageviews,ga:uniquePageviews&dimensions=ga:date,ga:pagePath,ga:browser,ga:operatingSystem,ga:countryIsoCode,ga:city&filters=' . $filter . '&access_token=' . $tokens->access_token);
				$res = GoogleController::sendGetData($urlRequest);

				$analytics = (object) json_decode($res);

				$allCliks = array();
				if (isset($analytics->totalsForAllResults)):
					foreach ($analytics->totalsForAllResults as $result):
						$allCliks[] = $result;
					endforeach;
				endif;
				$userPlainDetails['totalClicks'] = isset($allCliks[0]) ? $allCliks[0] : 0;
			}
			return $userPlainDetails;
		} catch (Exception $e) {

		}
	}
	public static function currentSubscription() {
		return Subscriptions::whereUserId(Auth::user()->id)->orderBy('id', 'desc')->first();
	}

	/**
	 * Set the application keywords
	 *
	 * @param $keywords,type
	 * @return \Illuminate\Http\Response
	 */
	static function setKeyword($keywords, $type) {
		$keywords = json_decode($keywords);
		if ($keywords) {
			$concatinate = in_array($type, [5, 4, 3, 6]) ? '+' : '-';
			$combineKeywords = '';
			foreach ($keywords as $key => $keyword) {
				if ($key != 0) {
					$combineKeywords .= str_replace(' ', $concatinate, $keyword);
				} else {
					$combineKeywords .= str_replace(' ', $concatinate, $keyword);
				}
			}
			return $combineKeywords;
		} else {
			return false;
		}
	}

	/**
	 * Save the application scraping data from amazon
	 *
	 * @param (object) $obj
	 * @return \Illuminate\Http\Response
	 */
	static function setUrl($obj) {
		switch ($obj->types) {
		case 2:
			return "https://www.amazon." . $obj->marketplace . "/s/ref=nb_sb_noss_2?field-keywords=" . self::setKeyword($obj->keyword, $obj->types);
			break;
		case 3:
			return 'https://www.amazon.' . $obj->marketplace . '/s/?keywords=' . self::setKeyword($obj->keyword, $obj->types) . '&ie=UTF8&field-asin=' . self::setAsin($obj->asin, $obj->types) . '&rh=i:aps,ssx:relevance';
			break;
		case 4:
			return 'https://www.amazon.' . $obj->marketplace . '/s/ref=nb_sb_noss_1?url=search-alias%3Daps&field-keywords=' . self::setKeyword($obj->keyword, $obj->types) . '&hidden-keywords=' . self::setAsin($obj->asin, $obj->types);
			break;
		case 5:
			$urlTailPart = '';
			if ($obj->min_price) {
				$urlTailPart .= '&low-price=' . $obj->min_price;
			}
			if ($obj->max_price) {
				$urlTailPart .= '&high-price=' . $obj->max_price;
			}
			if (self::setAsin($obj->asin, $obj->types)) {
				$urlTailPart .= '&field-asin=' . self::setAsin($obj->asin, $obj->types);
			}
			return 'https://www.amazon.' . $obj->marketplace . '/s/ref=nb_sb_noss_2?url=search-alias%3Daps&field-keywords=' . self::setKeyword($obj->keyword, $obj->types) . '&field-brand=' . $obj->brand . $urlTailPart;
			break;
		case 6:
			$urlTailPart = '';
			if (self::setAsin($obj->asin, $obj->types)) {
				$urlTailPart .= '&asin=' . self::setAsin($obj->asin, $obj->types);
			}
			if ($obj->min_price) {
				$urlTailPart .= '&low-price=' . $obj->min_price;
			}
			if ($obj->max_price) {
				$urlTailPart .= '&high-price=' . $obj->max_price;
			}
			return 'https://www.amazon.' . $obj->marketplace . '/s/ref=nb_sb_noss?url=me%3D' . $obj->storefront . '&field-keywords=' . self::setKeyword($obj->keyword, $obj->types) . $urlTailPart;

		case in_array($obj->types, [7, 8]):
			self::setAsinQuantity($obj->asin, $obj->quantity);
			return 'https://www.amazon.' . $obj->marketplace . '/gp/aws/cart/add.html?' . self::setAsinQuantity($obj->asin, $obj->quantity);
			break;
		case 9:
			return 'https://www.amazon.' . $obj->marketplace . '/' . self::setKeyword($obj->keyword, $obj->types) . '/dp/' . self::setAsin($obj->asin, $obj->types);
			break;

		default:break;
		}

	}

	/**
	 * Set the application ASIN Number
	 *
	 * @param $asins,type
	 * @return \Illuminate\Http\Response
	 */
	static function setAsin($asins, $type) {
		$asins = json_decode($asins, true);
		if (isset($asins)) {
			$solvedAsin = '';
			foreach ($asins as $key => $asin) {
				$solvedAsin = $asin;
			}
			return $solvedAsin;
		} else {
			return false;
		}
	}
	/**
	 * Set the application ASIN Number and Quentity
	 *
	 * @param $asins,type
	 * @return \Illuminate\Http\Response
	 */
	static function setAsinQuantity($asins, $qty) {
		$buyTogether = '';
		try {
			$asins = json_decode($asins, true);
			$qtys = json_decode($qty, true);
			$flag = false;
			foreach ($asins as $key => $asin) {
				if ($key == 0) {
					$flag = true;
				}
				$cont = $flag ? $key + 1 : $key;
				$concat = $key != 1 ? '&' : '';
				$buyTogether .= 'ASIN.' . $cont . '=' . $asin . '&Quantity.' . $cont . '=' . $qtys[$key] . $concat;
			}
			return rtrim($buyTogether, "&");
		} catch (Exception $e) {

		}
	}
}