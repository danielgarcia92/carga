<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flights extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'tbl_AllFlights';
}
