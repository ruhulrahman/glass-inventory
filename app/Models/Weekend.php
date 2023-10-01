<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weekend extends Model
{
    protected $guarded=['id'];

	public function creator(){
		return $this->belongsTo(User::class, 'creator_id');
	}

	public function editor(){
		return $this->belongsTo(User::class, 'editor_id');
	}
}
