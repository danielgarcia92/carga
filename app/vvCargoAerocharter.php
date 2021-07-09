<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vvCargoAerocharter extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'vwCargo_alterno';
}
