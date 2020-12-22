<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Airports extends Model
{
    protected $connection = 'sqlsrv';

    /** @var array */
    protected $fillable = [
        'name'
        , 'base'
    ];

}
