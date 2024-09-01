<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model 
{

    protected $table = 'roles';
    public $timestamps = true;

    protected $fillable = array('name','active','updated_by');
    // protected $visible = array('id','name');

    public function users()
    {
        return $this->belongsToMany('App\Models\User','user_role', 'id_role', 'id_user');
    }
    public function user_role()
    {
        return $this->hasMany('App\Models\User_role');
    }

}