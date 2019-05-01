<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model {
	protected $fillable = ['id', 'user_id', 'name', 'stripe_id', 'stripe_plan', 'type', 'ends_at'];
}
