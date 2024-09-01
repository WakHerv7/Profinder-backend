<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    public $timestamps = true;
    protected $fillable = array('nom', 'prenom', 'email', 'password', 'ville','phone','updated_by','active');
    // protected $visible = array('nom', 'prenom', 'email', 'password', 'ville','phone,');

    public function anonces()
    {
        return $this->hasMany('Anonce');
    }

    public function prestations()
    {
        return $this->hasMany('Prestation');
    }

    public function canditatures()
    {
        return $this->hasMany('Canditature');
    }
    public function sentMessages()
    {
        return $this->hasMany('Message'::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany('Message'::class, 'receiver_id');
    }

    public function servicesProvided()
    {
        return $this->hasMany('Service'::class, 'provider_id');
    }

    public function servicesReceived()
    {
        return $this->hasMany('Service'::class, 'user_id');
    }
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role','user_role','id_user', 'id_role');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
