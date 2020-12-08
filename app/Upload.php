<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Upload extends Model
{
    use Sortable;

	/**
     * The attributes that are mass assignable.
     *
     * @var array 
     */
	protected $fillable = [
	    'accept'
        , 'flight_number'
        , 'legcd'
        , 'std'
        , 'from'
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
	];

	public $sortable = ['id', 'accept', 'flight_number', 'std', 'from', 'to', 'rego'];
}
