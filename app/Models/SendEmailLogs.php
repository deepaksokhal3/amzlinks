<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SendEmailLogs extends Model {
	protected $fillable = ['user_id', 'sub_id', 'plan_title', 'clicks', 'status'];
}
