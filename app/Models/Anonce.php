<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anonce extends Model 
{

    protected $table = 'anonces';
    public $timestamps = true;
    protected $fillable = array('titre', 'description', 'butget', 'date_limite', 'ville', 'id_user', 'id_categorie','updated_by','active');
    // protected $visible = array('titre', 'description', 'butget', 'date_limite', 'ville', 'id_user', 'id_categorie');

    public function user()
    {
        return $this->hasOne('User');
    }

    public function categorie()
    {
        return $this->hasOne('Categorie');
    }

    public function canditatures()
    {
        return $this->hasMany('Canditature');
    }

}