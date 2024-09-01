<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_role extends Model 
{

    protected $table = 'user_role';
    public $timestamps = true;


    protected $fillable = array('id_user', 'id_role');
    // protected $visible = array('id','id_user', 'id_role');

    public function users()
    {
        return $this->hasOne('App\Models\User');
    }

    public function roles()
    {
        return $this->hasOne('App\Models\Role');
    }

}