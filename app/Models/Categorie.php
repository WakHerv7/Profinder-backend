<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model 
{

    protected $table = 'categories';
    public $timestamps = true;
    protected $fillable = array('nom','updated_by','active');
    // protected $visible = array('nom');

    public function anonces()
    {
        return $this->hasMany('Anonce');
    }

}