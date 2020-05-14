<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\LeaseDetail;
use Faker\Generator as Faker;

$factory->define(LeaseDetail::class, function (Faker $faker) {
    return [
        'date' =>$faker->dateTime(),
        'days' =>$faker->numberBetween(1,10),
        'price' => $faker->randomFloat(2,10,100),
        'user_id' =>$faker->numberBetween(1,10),
        'book_id' =>$faker->numberBetween(1,10),
        // 'created_at' -> Carbon::now()
        'created_at' => $faker->dateTimeThisMonth()
        //
    ];
});
