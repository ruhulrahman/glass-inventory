<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    protected $table= 'employee_attendances';
    protected $guarded=['id'];

	public function creator(){
		return $this->belongsTo(User::class, 'creator_id');
	}

	public function editor(){
		return $this->belongsTo(User::class, 'editor_id');
	}
}
