<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Tracks extends Model {

	protected $fillable = ['trackTitle', 'type', 'trackCode', 'user_id'];

	public function trackingType() {
		return $this->belongsTo(TrackingType::class, 'type');
	}
}
