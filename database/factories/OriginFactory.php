<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Origin;
use Faker\Generator as Faker;

$factory->define(Origin::class, function (Faker $faker) {
    return [
        'name' => 'aerocharter'
    ];
});
