<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqPages extends Model {
	protected $fillable = ['title', 'cat_id', 'description'];

	public function getCatagories() {
		return $this->belongsTo(FaqCatagory::class, 'cat_id');
	}
}
