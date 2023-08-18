<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded=['id'];

	public function type(){
		return $this->belongsTo(ProductType::class, 'product_type_id');
	}

	public function color(){
		return $this->belongsTo(ProductColor::class, 'color_id');
	}

	public function unit(){
		return $this->belongsTo(ProductUnit::class, 'unit_id');
	}

	public function category(){
		return $this->belongsTo(ProductCategory::class, 'category_id');
	}

	public function supplier(){
		return $this->belongsTo(Supplier::class, 'supplier_id');
	}

}
