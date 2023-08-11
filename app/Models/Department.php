<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded=['id'];

	public function parent(){
		return $this->belongsTo(Department::class, 'parent_id');
	}
}
