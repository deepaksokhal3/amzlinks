<?php

namespace App\Http\Controllers;
use App\Models\Plan;
use App\Models\Subscriptions;
use Auth;
use Illuminate\Http\Request;
use Mail;
use Session;

class SubscriptionController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application user subscription
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$plans = Plan::orderBy('id', 'desc')->get();

		$subscription = Subscriptions::whereUserId(Auth::user()->id)->orderBy('id', 'desc')->first();
		if ($subscription) {
			$activatedPlan = $subscription->name;
			Session::flash('messagePlan', 'You currently have the "' . $activatedPlan . '" plan.');
			Session::flash('alert-class', 'alert-info');
		}
		return view('front.subscription.index', compact('subscription', 'plans'));
	}

	public function show(Plan $plan, Request $request) {
		if ($request->user()->subscribedToPlan($plan->plan_id, $plan->stripe_plan) && !$request->user()->subscription($plan->stripe_plan)->cancelled()) {
			// return redirect()->route('subscription.index')->with('success', 'You  subscribed the plan');
		}
		return view('front.plans.index', compact('plan'));
	}

	public function create(Request $request, Plan $plan) {
		$plan = Plan::findOrFail($request->get('plan'));
		if ($request->user()->subscribedToPlan($plan->plan_id, $plan->stripe_plan) && !$request->user()->subscription($plan->stripe_plan)->cancelled()) {
			return redirect()->back()->with('success', 'You have already subscribed the plan');
		}
		$request->user()
			->newSubscription($plan->stripe_plan, $plan->plan_id)->create($request->stripeToken);

		// Send mail activate subscription
		$user = (object) Auth::user();
		try {
			$user->plan = $plan->name;
			Mail::send('emails.subscription', ['user' => $user], function ($m) use ($user) {
				$m->from('admin@amzlinks.com', 'AMZLinks Notifications');
				$m->to($user->email, 'Amzlinks')->subject('AmzLinks Subscription');
			});
		} catch (\Exception $e) {

		}
		return redirect()->route('subscription.index')->with('success', 'You  subscribed the plan');

	}

	public function cancel(Request $request, Plan $plan) {

		if ($request->user()->subscription($plan->stripe_plan)->cancel()) {
			Subscriptions::create(['user_id' => Auth::user()->id, 'name' => 'Free', 'stripe_plan' => 'plan_free', 'created_at' => date('Y-m-d H:i')]);
			return redirect()->route('subscription.index')->with('success', 'Your subscription "' . $plan->stripe_plan . '" cancelled and switched on Free Plan subscription');
		}
	}

}