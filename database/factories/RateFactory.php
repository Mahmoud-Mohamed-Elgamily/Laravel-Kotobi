<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Rate;
use Faker\Generator as Faker;

$factory->define(Rate::class, function (Faker $faker) {
    return [
        'rating' => $faker->randomFloat(5,0,5),
        'user_id' => $faker->numberBetween(1,10),
        'book_id' => $faker->numberBetween(1,10),
    ];
});
