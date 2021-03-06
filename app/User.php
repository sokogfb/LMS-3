<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function activities(){
        return $this->hasMany('App\Activity');
    }

    public function infos(){
        return $this->hasMany('App\UserInfo');
    }
    public function grade(){
        return $this->hasMany('App\Grade');
    }
    public function comments(){
        return $this->hasMany('App\Comment');
    }
}
