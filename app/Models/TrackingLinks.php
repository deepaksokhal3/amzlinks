<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingLinks extends Model {
	//
	protected $fillable = ['user_id', 'redirect_mode_id', 'campaign_id', 'title', 'uniqe_url', 'types', 'user_subscription_id', 'hide_ref_url', 'marketplace', 'asin', 'intermediate_page', 'keyword', 'brand', 'min_price', 'max_price', 'storefront', 'quantity'];

	protected $visible = ['tracking_code_id'];

	public function getMarketPlace() {
		return $this->belongsTo(Countries::class, 'marketplace');
	}

	public function getUrlType() {
		return $this->belongsTo(UrlType::class, 'types');
	}

	public function redirectMode() {
		return $this->belongsTo(RedirectMode::class, 'redirect_mode_id');
	}
	public function getDestinationUrls() {
		return $this->hasMany(DestinationLinks::class, 'tracking_link_id');
	}

	public function getTrackingLogs() {
		return $this->hasMany(LinksLogs::class, 'tracking_links_id');
	}

	public function getTrackingCode() {
		return $this->belongsTo(Tracks::class, 'tracking_code_id');
	}

	public function getSelectedTrackingCode() {
		return $this->hasMany(SelectedPixelCodes::class, 'tracking_link_id');
	}

	public function userSubscription() {
		return $this->belongsTo(Subscriptions::class, 'user_subscription_id')->orderBy('id', 'ASC');
	}

}
