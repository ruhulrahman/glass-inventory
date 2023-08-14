<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $guarded=['id'];

	public function department(){
		return $this->belongsTo(Department::class, 'department_id');
	}
}
