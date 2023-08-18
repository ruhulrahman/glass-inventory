<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    protected $guarded=['id'];

	public function product(){
		return $this->belongsTo(ProductType::class, 'product_id');
	}

	public function supplier(){
		return $this->belongsTo(Supplier::class, 'supplier_id');
	}

	public function creator(){
		return $this->belongsTo(User::class, 'creator_id');
	}

}
