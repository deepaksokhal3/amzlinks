<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinksLogs extends Model {
	//

	protected $fillable = ['user_id', 'tracking_links_id', 'destination_links_id', 'link_position', 'clicks'];
}
