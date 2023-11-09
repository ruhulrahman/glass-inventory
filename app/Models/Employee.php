<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    protected $guarded=['id'];
    protected $appends = ['photo_url'];

    public function designation(){
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function getPhotoUrlAttribute(){

        if($this->media_id){
            return media_url($this->media_id);
        }
    }
}
