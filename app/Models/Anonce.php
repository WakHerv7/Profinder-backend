<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anonce extends Model 
{

    protected $table = 'anonces';
    public $timestamps = true;
    protected $fillable = array('titre', 'description', 'budjet', 'date_limite', 'ville', 'id_user', 'id_categorie');
    protected $visible = array('titre', 'description', 'budjet', 'date_limite', 'ville', 'id_user', 'id_categorie');

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