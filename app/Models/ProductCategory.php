<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
	protected $table = 'plu_groups';
    protected $guarded=['id'];

	public function creator(){
		return $this->belongsTo(User::class, 'creator_id');
	}

}
