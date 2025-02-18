<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
	protected $table = 'product_categories';
    protected $guarded=['id'];

	public function parent(){
		return $this->belongsTo(ProductCategory::class, 'parent_id');
	}

	public function creator(){
		return $this->belongsTo(User::class, 'creator_id');
	}

	public function editor(){
		return $this->belongsTo(User::class, 'editor_id');
	}

	// public function company(){
	// 	return $this->belongsTo(Company::class, 'company_id');
	// }

}
