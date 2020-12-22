<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    protected $connection = 'sqlsrv';

    /** @var array */
    protected $fillable = [
        'name'
    ];
}
