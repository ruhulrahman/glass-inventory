<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    // use HasFactory;

    protected $guarded=['id'];

    public function group(){
    	return $this->belongsTo('App\Models\StatusGroup', 'status_group_id');
    }

    public function job_applicants()
    {
        return $this->hasMany(JobApplicant::class, 'screening_group_id', 'id');
    }
}
