<?php

namespace App\Http\Controllers;
use App\Models\Subscriptions;
use App\Models\UserSubscriptions;
use Auth;
use Cartalyst\Stripe\Stripe;
use Exception;
use Illuminate\Http\Request;
use Mail;
use Redirect;
use Session;
use Validator;

class StripeController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}
	/**
	 * Show the application stripe page to make payment
	 *
	 * @param Illuminate\Http\Request; $reuest subscription id
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		if (!$request->subscriptionId) {
			return redirect('subscription');
		}
		$sub = Subscriptions::with('subscriptionTypes')->find($request->subscriptionId);
		if ($sub->sub_type_id == 1) {
			UserSubscriptions::create([
				'user_id' => Auth::user()->id,
				'sub_id' => 1,
				'transection_id' => '',
				'amount' => '0.00',
				'created_at' => date('Y-m-d H:i'),
			]);
			$user = (object) Auth::user();
			$user->plan = $sub->subscriptionTypes->title;
			Mail::send('emails.subscription', ['user' => $user], function ($m) use ($user) {
				$m->from('admin@amzlinks.com', 'AMZLinks Notifications');
				$m->to($user->email, 'Amzlinks')->subject('AmzLinks Subscription');
			});
			Session::flash('message', 'You have switch free plan subscription');
			Session::flash('alert-class1', 'alert-success');
			return redirect('subscription');
		}
		return view('front.stripe.index', compact('sub'));
	}

	/**
	 * Submit the application make payment sected subscription
	 *
	 * @param Illuminate\Http\Request; $requested  card details and amount
	 * @return \Illuminate\Http\Response
	 */
	public function postPaymentWithStripe(Request $request) {

		$validator = Validator::make($request->all(), [
			'card_no' => 'required',
			'ccExpiryMonth' => 'required|Between:01,12',
			'ccExpiryYear' => 'required|min:4|max:4',
			'cvvNumber' => 'required|min:3|max:4',
		]);

		if ($validator->fails()) {
			$data['sub'] = Subscriptions::find($request->subId);
			Session::flash('message', 'Make payment !');
			Session::flash('alert-class', 'alert-danger');
			$data['errors'] = $validator->errors();
			return view('front.stripe.index')->with($data);
		}
		$input = $request->all();

		$selectedSub = Subscriptions::with('subscriptionTypes')->find($request->subId);

		if (!empty($selectedSub)) {
			try {
				$input = array_except($input, array('_token'));
				$stripe = Stripe::make('sk_test_5z2X9FSLsFeJlr157I4OynWO');
				$token = $stripe->tokens()->create([
					'card' => [
						'number' => $request->get('card_no'),
						'exp_month' => $request->get('ccExpiryMonth'),
						'exp_year' => $request->get('ccExpiryYear'),
						'cvc' => $request->get('cvvNumber'),
						'name' => Auth::user()->name,
					],
				]);

				if (!isset($token['id'])) {
					Session::flash('message', 'Some technical issue occurred. Please try again');
					Session::flash('alert-class1', 'alert-danger');
					return redirect()->route('stripe');
				}
				$charge = $stripe->charges()->create([
					'card' => $token['id'],
					'currency' => $selectedSub->currency,
					'amount' => $selectedSub->fee,
					'description' => 'subscription',
					'metadata' => ['name' => Auth::user()->name, 'email' => Auth::user()->email],
				]);

				if ($charge['status'] == 'succeeded') {
					UserSubscriptions::create([
						'user_id' => Auth::user()->id,
						'sub_id' => $selectedSub->id,
						'transection_id' => $charge['id'],
						'amount' => $selectedSub->fee,
						'created_at' => date('Y-m-d H:i'),
					]);

					$user = (object) Auth::user();
					$user->plan = $selectedSub->subscriptionTypes->title;
					Mail::send('emails.subscription', ['user' => $user], function ($m) use ($user) {
						$m->from('admin@amzlinks.com', 'AMZLinks Notifications');
						$m->to($user->email, 'Amzlinks')->subject('AmzLinks Subscription');
					});
					Session::flash('message', 'Thanks to join AMZlinks Payment successfully');
					Session::flash('alert-class1', 'alert-success');
					return redirect('subscription');
				} else {
					Session::flash('message', 'Please try again not activated yet');
					Session::flash('alert-class1', 'alert-danger');
					return redirect('subscription');
				}

			} catch (Exception $e) {
				Session::flash('message', $e->getMessage());
				Session::flash('alert-class1', 'alert-danger');
				return redirect('subscription');
			} catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
				Session::flash('message', $e->getMessage());
				Session::flash('alert-class1', 'alert-danger');
				return redirect('subscription');
			} catch (\Cartalyst\Stripe\Exception\MissingParameterException $e) {
				Session::flash('message', $e->getMessage());
				Session::flash('alert-class1', 'alert-danger');
				return redirect('subscription');
			}
		}
	}

}
