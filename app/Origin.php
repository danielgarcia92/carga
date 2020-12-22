<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    protected $connection = 'sqlsrv';

	protected $fillable = [
		'name'
	];
}
