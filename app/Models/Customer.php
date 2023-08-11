<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table= 'customers';
    protected $guarded=['id'];

	public function creator(){
		return $this->belongsTo(User::class, 'creator_id');
	}

}
