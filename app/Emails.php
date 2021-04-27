<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    public $timestamps = false;
    protected $connection = 'sqlsrv';

    /** @var array */
    protected $fillable = [
        'email'
        , 'areas_id'
        , 'airports_id'
        , 'active'
    ];
}
