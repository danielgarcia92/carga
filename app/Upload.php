<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array 
     */
	protected $fillable = [
        'origins_id'
		, 'accept'
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
        , 'createdBy'
        , 'user_approval'
        , 'message_approval'
        , 'volume_unit'
        , 'volume'
        , 'pieces'
        , 'weight'
	];
}
