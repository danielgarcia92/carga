<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flights extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = 'tbl_AllFlights';
}
