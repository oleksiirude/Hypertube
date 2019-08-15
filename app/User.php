<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'username', 'first_name', 'last_name', 'email', 'password',
    ];
    
    /**
     * Turn off default casting [id] to int type
     */
    public $incrementing = false;
}
