<?php
namespace App\Http\Controllers;
use App\Models\IntermediateData;
use App\Models\LinksLogs;
use App\Models\Subscriptions;
use App\Models\TrackingLinks;
use App\User;
use Carbon\Carbon;
use Goutte;
use Helper;
use Illuminate\Http\Request;
use View;

class IntermediateViewController extends GoogleController {

	/**
	 * Show the application amazon product view
	 *@var $filter
	 */
	private $filter;
	public function index($id) {
		try {
			$links = TrackingLinks::whereUniqeUrl($id)->with('redirectMode', 'getSelectedTrackingCode.getPixelCode', 'getMarketPlace')->firstOrFail();
			$track = true;
			if (!$this->checkSubscriptionPlanPolicy($links->user_id)) {
				$track = false;
			}
			if (!empty($links)):
				return view('front.tracking-link.intermediate.index', compact('links', 'urlTypes', 'track'));
			else:
				return view('errors.404');
			endif;
		} catch (Exception $e) {
		}
	}

	/**
	 * Show the application scraping data from amazon
	 *
	 * @param Illuminate\Http\Request; $id
	 * @return \Illuminate\Http\Response
	 */

	public function getIntermediateData($id) {

		$links = TrackingLinks::whereUniqeUrl($id)->with('getDestinationUrls')->firstOrFail();
		if (!$this->checkSubscriptionPlanPolicy($links->user_id)) {
			$data['expire'] = true;
			$data['target'] = false;
			return json_encode($data);
		}

		$insertLog['user_id'] = $links->user_id;
		$insertLog['tracking_links_id'] = $links->id;
		$redirectUrl = '';
		$data['html'] = array();
		$data['target'] = false;
		if (in_array($links->types, [1, 3, 4, 5, 6])) {
			if ($links->redirect_mode_id == 1) {
				if (LinksLogs::whereTrackingLinksId($links->id)->exists()) {
					$logs = LinksLogs::whereTrackingLinksId($links->id)->orderBy('id', 'DESC')->first();
					if (count($links->getDestinationUrls) > ($logs->link_position + 1)) {
						$insertLog['link_position'] = $logs->link_position + 1;
						$insertLog['destination_links_id'] = $links->getDestinationUrls[$logs->link_position + 1]->id;
						$data['redirect_url'] = $links->getDestinationUrls[$logs->link_position + 1]->destination_url;
					} else {
						$insertLog['link_position'] = 0;
						$insertLog['destination_links_id'] = $links->getDestinationUrls[0]->id;
						$data['redirect_url'] = $links->getDestinationUrls[0]->destination_url;
					}
				} else {
					$insertLog['link_position'] = 0;
					$insertLog['destination_links_id'] = $links->getDestinationUrls[0]->id;
					$data['redirect_url'] = $links->getDestinationUrls[0]->destination_url;
				}

			} else if ($links->redirect_mode_id == 2) {
				$DestinationUrls = array();
				$deletedItem = array();
				foreach ($links->getDestinationUrls as $key => $destinationUrl):
					if (!in_array($destinationUrl->id, $deletedItem)) {
						$deletedItem[] = $destinationUrl->id;
					}
					if (LinksLogs::whereDestinationLinksId($destinationUrl->id)->count() <= $destinationUrl->percentage) {
						$DestinationUrls[$key] = $destinationUrl->destination_url;
					}
				endforeach;
				if (!empty($DestinationUrls)) {
					$random_id = array_rand($DestinationUrls, 1);
					$insertLog['destination_links_id'] = $links->getDestinationUrls[$random_id]->id;
					$data['redirect_url'] = $DestinationUrls[$random_id];
				} else {
					LinksLogs::whereIn('destination_links_id', $deletedItem)->delete();
					$this->getIntermediateData($id);
				}

			} else {
				$DestinationUrls = array();
				foreach ($links->getDestinationUrls as $destinationUrl):
					$DestinationUrls[] = $destinationUrl->destination_url;
				endforeach;
				$random_id = array_rand($DestinationUrls, 1);
				$insertLog['destination_links_id'] = $links->getDestinationUrls[$random_id]->id;
				$data['redirect_url'] = $DestinationUrls[$random_id];
			}
			$insertLog['clicks'] = 1;

			if (!$data['redirect_url']) {
				$data['redirect_url'] = 'https://www.amazon.com/';
			} else {
				$data['redirect_url'] = $this->addhttp($data['redirect_url']);
				LinksLogs::create($insertLog);
			}
		} else {
			$data['redirect_url'] = Helper::setUrl($links);

			$data['asin'] = $links->asin;
			if ($links->intermediate_page) {
				$data['html'] = self::scrape($links);
				$data['target'] = true;
			}
		}
		echo json_encode($data);exit;

	}

	public function addhttp($url) {
		if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			$url = "https://" . $url;
		}
		return $url;
	}

	/**
	 * Show the application scraping data from amazon
	 *
	 * @param (object) $links
	 * @return \Illuminate\Http\Response
	 */
	static function scrape($links) {
		$url = 'https://www.amazon.' . $links->marketplace . '/' . Helper::setKeyword($links->keyword, $links->types) . '/dp/' . Helper::setAsin($links->asin, $links->types);
		$crawler = Goutte::request('GET', $url);
		Goutte::setHeader('user-agent', "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36");
		$product = [];
		try {
			$product['title'] = count($crawler->filter('#productTitle')) > 0 ? trim($crawler->filter('#productTitle')->text()) : '';
			$product['rating'] = count($crawler->filter('.a-icon-star')) > 0 ? $crawler->filter('.a-icon-star span')->eq(0)->text() : '';
			$product['price'] = count($crawler->filter('.a-color-price')) > 0 ? $crawler->filter('.a-color-price')->html() : '';
			$product['image'] = count($crawler->filter('#imgTagWrapperId img')) > 0 ? trim($crawler->filter('#imgTagWrapperId img')->eq(0)->attr('src')) : '';
			$product['status'] = true;
			self::store($product, $links->id);

		} catch (Exception $e) {

		}

		if (strlen(trim($product['title'])) < 1) {
			$product['status'] = false;
			$product['mrkPlace'] = $links->marketplace;
		}
		return $product;

	}

	/**
	 * Save the application scraping data from amazon
	 *
	 * @param (object) $scraped,$id
	 * @return \Illuminate\Http\Response
	 */
	static function store($scraped, $id) {
		if ($scraped['status']) {
			IntermediateData::create(['tracking_link_id' => $id, 'htmlString' => json_encode($scraped)]);
		}
	}

	/**
	 * @param clicks on there user links $clicks
	 * @param link under the user $user
	 * @param current user subscription $userSub
	 * @return \Illuminate\Http\Response
	 */
	public static function isValidPolicy($userSub, $user, $clicks) {
		try {
			if ($userSub->name == 'Free') {
				$ended = $userSub->type != 'New' && $user->subscription('Professional')->ends_at ? $user->subscription('Professional')->ends_at->format('Y-m-d H:i:s') : false;
				$upto = date('Y-m-d H:i:s', strtotime("+1 month", strtotime($userSub->created_at)));
				$upto = ($ended > Carbon::now()->format('Y-m-d H:i:s')) && $ended ? $ended : $upto;
				$flag = ($ended > Carbon::now()->format('Y-m-d H:i:s')) && $ended ? true : false;
				if ($flag) {
					return ($upto > Carbon::now()->format('Y-m-d H:i:s') && $clicks < 20000) || $upto < Carbon::now()->format('Y-m-d') ? false : true;
				} else {
					return ($clicks > 1000 && $upto > Carbon::now()->format('Y-m-d H:i:s')) || ($upto < Carbon::now()->format('Y-m-d H:i:s')) ? false : true;
				}
			} else {
				if ($userSub->name == 'Professional' && $userSub->type == 'New') {
					$upto = date('Y-m-d H:i:s', strtotime("+1 month", strtotime($userSub->created_at)));
				} else {
					$timestamp = $user->asStripeCustomer()["subscriptions"]->data[0]["current_period_end"];
					$upto = Carbon::createFromTimeStamp($timestamp)->format('Y-m-d H:i:s');
				}
				return ($upto > Carbon::now()->format('Y-m-d H:i:s') && $clicks > 20000) || ($upto < Carbon::now()->format('Y-m-d H:i:s')) ? false : true;
			}
		} catch (Exception $e) {

		}
	}
	/**
	 * @param user Id $userId
	 * @return \Illuminate\Http\Response
	 */
	public function checkSubscriptionPlanPolicy($userId) {
		try {
			$user = User::find($userId);
			$userSubscription = Subscriptions::whereUserId($user->id)->orderBy('id', 'desc')->first();
			$endSubscriptionDate = $userSubscription->type != 'New' && $user->subscription('Professional')->ends_at ? $user->subscription('Professional')->ends_at->format('Y-m-d H:i:s') : $userSubscription->created_at->format('Y-m-d H:i:s');

			if ($endSubscriptionDate > Carbon::now()->format('Y-m-d H:i:s') && $userSubscription->type != 'New') {
				$timestamp = $user->asStripeCustomer()["subscriptions"]->data[0]["current_period_start"];
				$startDate = Carbon::createFromTimeStamp($timestamp)->format('Y-m-d H:i:s');
				$timestamp = $user->asStripeCustomer()["subscriptions"]->data[0]["current_period_end"];
				$endDate = Carbon::createFromTimeStamp($timestamp)->format('Y-m-d H:i:s');
			} else if ($userSubscription->name == 'Professional' && $userSubscription->type != 'New') {
				$timestamp = $user->asStripeCustomer()["subscriptions"]->data[0]["current_period_start"];
				$startDate = Carbon::createFromTimeStamp($timestamp)->format('Y-m-d H:i:s');
				$timestamp = $user->asStripeCustomer()["subscriptions"]->data[0]["current_period_end"];
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
			$this->linksCollector($userId, 0);
			if ($this->filter != '') {

				$tokens = GoogleController::refreshToken();
				// Google analytics apply filer
				$filter = rtrim($this->filter, ",");
				$urlRequest = urldecode('https://www.googleapis.com/analytics/v3/data/ga?ids=ga:193566229&start-date=' . $startDateG . '&end-date=' . $endDateG . '&metrics=ga:pageviews,ga:uniquePageviews&filters=' . $filter . '&access_token=' . $tokens->access_token);
				$res = GoogleController::sendGetData($urlRequest);
				$analytics = (object) json_decode($res);
				$allCliks = array();
				if (isset($analytics->totalsForAllResults)):
					foreach ($analytics->totalsForAllResults as $result):
						$allCliks[] = $result;
					endforeach;
				endif;
				return isset($allCliks[0]) ? $this->isValidPolicy($userSubscription, $user, $allCliks[0]) : true;
			}
		} catch (Exception $e) {

		}
	}

	/**
	 * @param offest  $skip
	 * @param user Id $userId
	 * @return \Illuminate\Http\Response
	 */
	public function linksCollector($userId, $skip = 0) {
		$links = TrackingLinks::whereUserId($userId)->take(10)->skip($skip)->get();
		if (count($links) < 1) {
			return $this->filter;
			exit;
		}
		$couner = $skip;
		foreach ($links as $link):
			$this->filter .= 'ga:pagePath=~/' . $link->uniqe_url . ',';
			$couner++;
		endforeach;
		$this->linksCollector($userId, $couner);
	}

}
