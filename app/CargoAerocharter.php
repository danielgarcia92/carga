<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CargoAerocharter extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'tblCargoAeroCharter';
}
