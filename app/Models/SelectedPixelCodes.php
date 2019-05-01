<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelectedPixelCodes extends Model {

	protected $fillable = ['tracking_link_id', 'tracking_code_id'];

	public function getPixelCode() {
		return $this->belongsTo(Tracks::class, 'tracking_code_id');
	}
}
