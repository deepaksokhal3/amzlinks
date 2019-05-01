<?php

namespace App\Console\Commands;
use App\Http\Controllers\GoogleController;
use App\Mail\Subscription;
use App\Models\SendEmailLogs;
use App\Models\TrackingLinks;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SubscriptionMail extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	// protected $signature = 'subascription:mail';
	protected $name = 'subascription:mail';
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send subscription alert notification when click reached limit';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle($skip = 1) {
		try {
			$users = User::with('userSubscription')->take(10)->skip($skip)->get();
			if ($users->count() == 0) {
				exit;
			}

			$couner = $skip;
			$tokens = GoogleController::refreshToken();
			foreach ($users as $key => $user) {
				$endSubscriptionDate = $user->userSubscription->type != 'New' && $user->userSubscription->ends_at ? $user->userSubscription->ends_at->format('Y-m-d H:i:s') : $user->userSubscription->created_at->format('Y-m-d');

				if ($endSubscriptionDate > Carbon::now()->format('Y-m-d H:i:s') && $user->userSubscription->type != 'New') {
					$timestamp = $user->asStripeCustomer()["subscriptions"]->data[0]["current_period_start"];
					$startDate = Carbon::createFromTimeStamp($timestamp)->format('Y-m-d H:i:s');
					$timestamp = $user->asStripeCustomer()["subscriptions"]->data[0]["current_period_end"];
					$endDate = Carbon::createFromTimeStamp($timestamp)->format('Y-m-d H:i:s');
				} else if ($user->userSubscription->name == 'Professional' && $user->userSubscription->type != 'New') {
					$timestamp = $user->asStripeCustomer()["subscriptions"]->data[0]["current_period_start"];
					$startDate = Carbon::createFromTimeStamp($timestamp)->format('Y-m-d H:i:s');
					$timestamp = $user->asStripeCustomer()["subscriptions"]->data[0]["current_period_end"];
					$endDate = Carbon::createFromTimeStamp($timestamp)->format('Y-m-d H:i:s');
				} else if ($user->userSubscription->name == 'Professional' && $user->userSubscription->type == 'New') {

					$startDate = $user->userSubscription->created_at->format('Y-m-d H:i:s');
					$endDate = Carbon::now()->format('Y-m-d H:i:s');
				} else {

					$startDate = $user->userSubscription->created_at->format('Y-m-d H:i:s');
					$endDate = Carbon::now()->format('Y-m-d H:i:s');
				}
				$startDateG = date('Y-m-d', strtotime($startDate));
				$endDateG = date('Y-m-d', strtotime($endDate));

				$links = TrackingLinks::whereUserSubscriptionId($user->userSubscription->id)->orderBy('id', 'DESC')->get();
				// Google analytics apply filer
				if (count($links) > 0) {
					$filter = '';
					foreach ($links as $link) {
						$filter .= 'ga:pagePath=~/' . $link->uniqe_url . ',';
					}
					$filter = rtrim($filter, ",");
					$urlRequest = urldecode('https://www.googleapis.com/analytics/v3/data/ga?ids=ga:193566229&start-date=' . $startDateG . '&end-date=' . $endDateG . '&metrics=ga:pageviews,ga:uniquePageviews&dimensions=ga:date,ga:pagePath,ga:browser,ga:operatingSystem,ga:countryIsoCode,ga:city&filters=' . $filter . '&access_token=' . $tokens->access_token);
					$res = GoogleController::sendGetData($urlRequest);

					$analytics = (object) json_decode($res);

					$allCliks = array();
					if (isset($analytics->totalsForAllResults)) {
						foreach ($analytics->totalsForAllResults as $result) {
							$allCliks[] = $result;
						}
					}

					// Applied send alert email to users Acc. to plan policy
					$emailFlag = SendEmailLogs::whereSubId($user->userSubscription->id)->first();
					if (isset($allCliks[0]) && $allCliks[0] >= 500 && $allCliks[0] <= 800 && SendEmailLogs::whereSubId($user->userSubscription->id)->count() < 1 && $user->userSubscription->name == 'Free') {

						SendEmailLogs::create(['user_id' => $user->id, 'sub_id' => $user->userSubscription->id, 'clicks' => $allCliks[0], 'plan_title' => $user->userSubscription->name, 'status' => 1]);
						$user->totalClicked = $allCliks[0];
						$this->subscriptionAlertMail($user);
					} else if (isset($allCliks[0]) && $allCliks[0] >= 500 && SendEmailLogs::whereSubId($user->userSubscription->id)->count() < 1 && $user->userSubscription->name == 'Free') {
						SendEmailLogs::create(['user_id' => $user->id, 'sub_id' => $user->userSubscription->id, 'clicks' => $allCliks[0], 'plan_title' => $user->userSubscription->name, 'status' => 1]);
						$user->totalClicked = $allCliks[0];
						$this->subscriptionAlertMail($user);
					} else if (isset($allCliks[0]) && $allCliks[0] >= 1000 && $emailFlag->status == 1 && $user->userSubscription->name == 'Free') {
						$user->totalClicked = $emailFlag->clicks = $allCliks[0];
						$emailFlag->status = 2;
						$emailFlag->save();
						$this->subscriptionAlertMail($user);
					} else if (isset($allCliks[0]) && $allCliks[0] >= 20000 && SendEmailLogs::whereSubId($user->userSubscription->id)->count() < 1 && $user->userSubscription->name == 'Professional') {
						SendEmailLogs::create(['user_id' => $user->id, 'sub_id' => $user->userSubscription->id, 'clicks' => $allCliks[0], 'plan_title' => $user->userSubscription->name]);
						$user->totalClicked = $allCliks[0];
						$this->subscriptionAlertMail($user);
					}
				}
				$couner++;
			}
			$this->handle($couner);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	private function subscriptionAlertMail($user) {
		try {
			Mail::to($user->email, 'Amzlinks')->send(new Subscription($user));
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}
