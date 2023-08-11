<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded=['id'];

	public function category(){
		return $this->belongsTo(ProductCategory::class, 'category_id');
	}

	public function supplier(){
		return $this->belongsTo(Supplier::class, 'supplier_id');
	}

}
