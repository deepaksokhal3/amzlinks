<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable {
	use Notifiable;
	use Billable;
	const ADMIN_TYPE = 'admin';
	const DEFAULT_TYPE = 'subscriber';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'is_active', 'country_id', 'language', 'image',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * Handle an incoming request.=
	 * @return mixed
	 */
	public function isAdmin() {
		return $this->role === self::ADMIN_TYPE;
	}

	/**
	 * Handle an incoming request.
	 * @return mixed
	 */
	public function isSubscriber() {
		return $this->role === self::DEFAULT_TYPE;
	}

	public function userSubscription() {
		return $this->hasOne('App\Models\Subscriptions', 'user_id')->latest();
	}
}
