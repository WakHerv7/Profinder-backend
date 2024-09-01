<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestation extends Model 
{

    protected $table = 'prestation';
    public $timestamps = true;
    protected $fillable = array('titre', 'description', 'tarifs', 'id_user','updated_by','active');
    // protected $visible = array('titre', 'description', 'tarifs', 'id_user');

    public function user()
    {
        return $this->hasOne('User');
    }
    

}