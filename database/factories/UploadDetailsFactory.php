<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UploadDetails;
use Faker\Generator as Faker;

$factory->define(UploadDetails::class, function (Faker $faker) {
    return [
        'guide_number' 	=> '333-00289553',
        'pieces' 		=> 10.0,
        'weight' 		=> 32.0,
        'volume'		=> 0,
        'partial'       => 1,
        'density'       => 06,
        'nature_goods'  => 'PAQUETERIA',
        'route_item'    => 'MEXCJS',
        'uploads_id'     => 1
    ];
});
