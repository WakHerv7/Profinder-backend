<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestation extends Model 
{

    protected $table = 'prestation';
    public $timestamps = true;
    protected $fillable = array('titre', 'description', 'tarifs', 'id_user');
    protected $visible = array('titre', 'description', 'tarifs', 'id_user');

    public function user()
    {
        return $this->hasOne('User');
    }
    

}