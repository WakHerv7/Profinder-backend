<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model 
{

    protected $table = 'message';
    public $timestamps = true;
    protected $fillable = array('contenu', 'date_envoi', 'receiver_id', 'sender_id','updated_by','active');
    // protected $visible = array('contenu', 'date_envoi', 'receiver_id', 'sender_id');
    public function sender()
{
    return $this->belongsTo('User'::class, 'sender_id');
}

public function receiver()
{
    return $this->belongsTo('User'::class, 'receiver_id');
}

}