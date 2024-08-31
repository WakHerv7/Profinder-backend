<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model 
{

    protected $table = 'categories';
    public $timestamps = true;
    protected $fillable = array('nom');
    protected $visible = array('nom');

    public function anonces()
    {
        return $this->hasMany('Anonce');
    }

}