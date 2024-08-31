<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Canditature extends Model 
{

    protected $table = 'canditature';
    public $timestamps = true;
    protected $fillable = array('id_user', 'id_anonce', 'message', 'date_candidature');
    protected $visible = array('id_user', 'id_anonce', 'message', 'date_candidature');

    public function user()
    {
        return $this->hasOne('User');
    }

    public function anonce()
    {
        return $this->hasOne('Anonce');
    }

}