<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'author' => $faker->name,
        'copies' => $faker->numberBetween(1,10),
        'description' => $faker->text,
        'category_id' => $faker->numberBetween(1,10),
    ];
});
