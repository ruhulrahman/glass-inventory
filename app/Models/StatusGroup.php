<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusGroup extends Model
{
    // use HasFactory;

    protected $guarded=['id'];

	public function creator(){
		return $this->belongsTo('App\Models\User', 'creator_id');
	}

	public function editor(){
		return $this->belongsTo('App\Models\User', 'editor_id');
	}

	public function statuses(){
		return $this->hasMany(Status::class, 'status_group_id')->orderBy('serial');
	}

}
