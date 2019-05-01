<?php

namespace App\Http\Middleware;

use Closure;

class Subscriber {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (auth()->user()->isSubscriber()) {
			return $next($request);
		}
		return redirect('/');
	}

}
