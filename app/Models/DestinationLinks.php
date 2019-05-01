<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationLinks extends Model {
	//

	protected $fillable = ['id', 'tracking_link_id', 'destination_url', 'unique_url', 'percentage', 'type'];
}
