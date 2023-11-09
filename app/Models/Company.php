<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    protected $table= 'companies';
    protected $guarded=['id'];
    protected $appends = ['media_url'];

	public function creator(){
		return $this->belongsTo(User::class, 'creator_id');
	}

    public function getMediaUrlAttribute () {
        if ($this->logo) {
            return asset('uploads/logo/'.$this->logo);
        } else {
            return NULL;
        }
    }
}
