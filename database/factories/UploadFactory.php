<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Upload;
use Faker\Generator as Faker;

$factory->define(Upload::class, function (Faker $faker) {
    return [
        'accept' 			=> $faker->numberBetween($min=0, $max=1),
        'flight_number' 	=> 'VB' . $faker->numberBetween($min=0, $max=9999),
        'std'				=> $faker->dateTime($max='now', $timezone=null),
        'from_id'           => 27,
        'from'				=> 'MTY',
        'to_id'             => 24,
        'to'				=> 'MEX',
        'rego'				=> 'XA-V' . strtoupper(Str::random(2)),
        'send'				=> $faker->text($maxNbChars = 30),
        'description'		=> $faker->text($maxNbChars = 30),
        'assurance'			=> $faker->text($maxNbChars = 30),
        'packing'			=> $faker->text($maxNbChars = 30),
        'message_approval'	=> $faker->text($maxNbChars = 30),
        'volume_unit'		=> strtoupper(Str::random(2)),
        'volume'			=> $faker->randomFloat($nbMaxDecimals=2, $min=0, $max=999),
        'pieces' 			=> $faker->numberBetween($min=0, $max=999),
        'weight' 			=> $faker->numberBetween($min=0, $max=999),
        'origins_id' 		=> 1,
        'created_by'		=> 1,
        'approved_by'		=> 1,
        'email1'            => 'david.ramos@vivaaerobus.com'
    ];
});
