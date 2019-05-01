<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model {

	protected $fillable = ['user_id', 'campaignNotes', 'campaignName', 'campaignTags'];

	public function countTakingLinks() {
		return $this->hasMany(TrackingLinks::class, 'campaign_id');
	}
	public function getUser() {
		return $this->belongsTo('App\User', 'user_id');
	}
}
