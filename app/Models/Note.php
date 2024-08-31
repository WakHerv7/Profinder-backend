<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// corrie butget dans la table Anonce

class Note extends Model 
{

    protected $table = 'notes';
    public $timestamps = true;
    protected $fillable = array('note', 'commentaire', 'date_note', 'id_prestataire', 'id_user');
    protected $visible = array('note', 'commentaire', 'date_note', 'id_prestataire', 'id_user');
    public function provider()
{
    return $this->belongsTo('User'::class, 'provider_id');
}

public function user()
{
    return $this->belongsTo('User'::class, 'user_id');
}

}