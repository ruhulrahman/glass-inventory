<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model{

	use SoftDeletes;

    protected $guarded=['id'];

    public function related_model(){
    	return $this->belongsTo($this->model, 'model_id');
    }

    public function url(){
    	return asset("media/{$this->file}");
    }

}
