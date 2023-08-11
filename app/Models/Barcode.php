<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    protected $guarded=['id'];

	public function creator(){
		return $this->belongsTo(User::class, 'creator_id');
	}

	public function product(){
		return $this->belongsTo(Product::class, 'product_id');
	}

}
