<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Upload extends Model
{
    use Sortable;

    protected $connection = 'sqlsrv';

	/** @var array */
	protected $fillable = [
	    'accept'
        , 'flight_number'
        , 'legcd'
        , 'std'
        , 'from_id'
        , 'from'
        , 'to_id'
        , 'to'
        , 'rego'
        , 'guide_number'
        , 'send'
        , 'description'
        , 'assurance'
        , 'packing'
        , 'message_approval'
        , 'volume_unit'
        , 'volume'
        , 'pieces'
        , 'weight'
        , 'origins_id'
        , 'created_by'
        , 'approved_by'
        , 'file'
        , 'email1'
        , 'email2'
        , 'email3'
        , 'int_cargo'
        , 'std_zulu'
	];

	public $sortable = ['id', 'accept', 'flight_number', 'std', 'std_zulu', 'from', 'to', 'rego'];
}
