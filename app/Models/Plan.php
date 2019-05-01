<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model {
	protected $fillable = ['plan_id', 'name', 'slug', 'type', 'stripe_plan', 'cost', 'description'];

	public function getRouteKeyName() {
		return 'slug';
	}
}
