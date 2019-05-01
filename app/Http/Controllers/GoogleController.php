<?php

namespace App\Http\Controllers;

use App\Models\Oauth;
use Google_Client;
use Google_Service_Analytics;
use Google_Service_Webmasters;
use Illuminate\Http\Request;

class GoogleController extends Controller {

	/**
	 * Show the application oauth.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function oauth(Request $request) {
		if (isset($request->code)) {
			$client = self::initializeAnalytics();
			$client->setApprovalPrompt('force');
			$client->authenticate($request->code);
			$token = $client->getAccessToken();

			$store = new Oauth;
			$store->access_token = $token['access_token'];
			$store->refresh_token = json_encode($token);
			$store->save();

			$request->session()->flash('success', "Google analytic login successfully");
			return redirect()->route('connect.index');
		} else {
			$client = self::initializeAnalytics();
			$client->setApprovalPrompt('force');
			$authUrl = $client->createAuthUrl();

			return redirect($authUrl);
		}
	}

	/**
	 * Show the application initialize Analytics.
	 *
	 * @return \Illuminate\Http\Response
	 */
	static function initializeAnalytics() {
		//get from .env file
		$client_id = config('services.analytic.client_id');
		$client_secret = config('services.analytic.client_secret');
		$api_key = config('services.analytic.api_key');

		$client = new Google_Client();
		$client->setApplicationName("Analytic Login");
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri(route('google.oauth'));
		$client->setDeveloperKey($api_key);
		$client->addScope(Google_Service_Webmasters::WEBMASTERS_READONLY);
		$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
		$client->setAccessType('offline');

		return $client;
	}

	/**
	 * refresh the Analytics token.
	 *
	 * @return \Illuminate\Http\Response
	 */
	static function refreshToken() {

		$analytic = Oauth::first();
		if (@$analytic) {
			$token = json_decode($analytic->refresh_token);
			$client = self::initializeAnalytics();
			$client->setAccessToken((array) $token);

			if ($client->isAccessTokenExpired()) {
				$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
				$token = $client->getAccessToken();

				//update token
				$analytic->access_token = $token['access_token'];
				$analytic->refresh_token = json_encode($token);
				$analytic->save();
			}
			return $analytic;
		}
		return false;
	}

	/**
	 * Show the application get Analytic Accounts.
	 *
	 * @return \Illuminate\Http\Response
	 */
	static function getAnalyticAccounts($analytic) {
		$results1 = array();
		$token = json_decode($analytic->refresh_token);
		$url = "https://www.googleapis.com/analytics/v3/management/accounts?access_token=" . $token->access_token;
		$res = self::sendGetData($url);
		$results = json_decode($res);
		foreach ($results->items as $Rresult) {
			$webProperty = "https://www.googleapis.com/analytics/v3/management/accounts/" . $Rresult->id . "/webproperties?access_token=" . $token->access_token;
			$res1 = self::sendGetData($webProperty);
			$results1[] = json_decode($res1);

		}
		return $results1;
	}

	/**
	 * Show the application premium.
	 *
	 * @return \Illuminate\Http\Response
	 */
	static function getPremium($parms, $analytic) {
		if (@$analytic && $analytic->access_token) {
			$startDate = date("Y-m-d", strtotime($parms['from_date']));
			$endDate = date("Y-m-d", strtotime($parms['to_date']));
			$metrics = explode(',', $parms['metrics']);
			$dimensions = explode(',', $parms['dimensions']);

			$url = "https://analyticsreporting.googleapis.com/v4/reports:batchGet?access_token=" . $analytic->access_token;
			$params = '{
				reportRequests:[{
					viewId:"ga:' . $analytic->accountid . '",
					dateRanges:[{
						startDate:"' . $startDate . '",
						endDate:"' . $endDate . '"
					}],
					metrics:[';
			foreach ($metrics as $metric) {
				$params .= '{expression:"ga:' . $metric . '"},';
			}
			$params .= '],
					dimensions: [';
			foreach ($dimensions as $dimension) {
				$params .= '{name:"ga:' . $dimension . '"},';
			}
			$params .= '],
					pageToken: "' . $parms['page'] . '",
					pageSize: "' . $parms['per_page'] . '",';
			if (@$parms['filter']) {
				$params .= 'filtersExpression: "' . $parms['filter'] . '",';
			}
			$params .= '}]
			}';
			$resp = self::sendPostData($url, $params);
			return json_decode($resp);
		}
		return response('Error Connecting with analytics', 404);
	}

	/**
	 * Show the application curl request
	 *
	 * @return \Illuminate\Http\Response
	 */
	static function sendGetData($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		return $result;
	}

	static function sendPostData($url, $post) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", 'Content-Length: ' . strlen($post)));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		return $result;
	}

}
