<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $connection = 'sqlsrv';

    /** @var array */
    protected $fillable = [
        'name', 'rol', 'areas_id', 'airports_id', 'email', 'active', 'password'
    ];

    /** @var array */
    protected $hidden = [
        'password', 'remember_token'
    ];

}
