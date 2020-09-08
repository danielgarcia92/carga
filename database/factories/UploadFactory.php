<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Upload;
use Faker\Generator as Faker;

$factory->define(Upload::class, function (Faker $faker) {
    return [
        'accept' 			=> $faker->numberBetween($min=0, $max=1),
        'flight_number' 	=> $faker->numberBetween($min=0, $max=9999),
        'legcd'				=> strtoupper(Str::random(1)),
        'std'				=> $faker->dateTime($max='now', $timezone=null),
        'from'				=> strtoupper(Str::random(3)),
        'to'				=> strtoupper(Str::random(3)),
        'rego'				=> 'XA-V' . strtoupper(Str::random(2)),
        'guide_number'		=> strtoupper(Str::random(14)),
        'send'				=> $faker->text($maxNbChars = 30),
        'description'		=> $faker->text($maxNbChars = 30),
        'assurance'			=> $faker->text($maxNbChars = 30),
        'packing'			=> $faker->text($maxNbChars = 30),
        'createdBy'			=> 1,
        'user_approval'		=> $faker->name($gender=null),
        'message_approval'	=> $faker->text($maxNbChars = 30),
        'volume_unit'		=> strtoupper(Str::random(2)),
        'volume'			=> $faker->randomFloat($nbMaxDecimals=2, $min=0, $max=999),
        'pieces' 			=> $faker->numberBetween($min=0, $max=999),
        'weight' 			=> $faker->numberBetween($min=0, $max=999),
        'origins_id' 		=> 1
    ];
});
