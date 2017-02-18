<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Author::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Book::class, function (Faker\Generator $faker) {

    return [
        'isbn' => $faker->isbn13,
        'title' => $faker->text(200),
        'subtitle' => $faker->text(200),
        'pub_year' => $faker->year,
        'image_url_small' => $faker->imageUrl(50,50),
        'image_url_medium' => $faker->imageUrl(250,250),
        'image_url_large' => $faker->imageUrl(500,500),
    ];
});
