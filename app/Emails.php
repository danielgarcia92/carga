<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    protected $connection = 'sqlsrv';

    /** @var array */
    protected $fillable = [
        'name'
        , 'base'
    ];
}
