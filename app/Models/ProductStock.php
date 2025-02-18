<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $table= 'product_stocks';
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

	public function histories(){
		return $this->hasMany(ProductHistory::class, 'product_id');
	}

	public function creator(){
		return $this->belongsTo(User::class, 'creator_id');
	}
}
