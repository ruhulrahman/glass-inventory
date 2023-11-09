<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'permissions';

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function parent() {
        return $this->belongsTo(Permission::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Permission::class, 'parent_id');
    }

    // public static function getAppId()
    // {
    //     $num = 1;

    //     $model = self::latest('id')->first(['id', 'code']);
    //     $prefix = 'CA-0000';
    //     $startPosition = strlen($prefix);

    //     if ($model) {
    //         $num = (int) substr($model->code, $startPosition) + 1;
    //     }

    //     return "{$prefix}{$num}";
    // }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function($model) {
    //         $model->code = self::getAppId();
    //     });
    // }
}
