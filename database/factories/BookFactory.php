<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->words($nb = $faker->numberBetween(1,2), $asText = true),
        'author' => $faker->name,
        'copies' => $faker->numberBetween(1,10),
        'image' => $faker->image('public/storage/images',640,480, null, false),
        'description' => $faker->text,
        'category_id' => $faker->numberBetween(1,10),
    ];
});
