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
use App\Models\Card;
use App\Models\Category;
use App\Models\Deck;
use App\Models\Field;
use App\Models\Tag;
use App\Models\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Deck::class, function(Faker\Generator $faker) {
    return [
        'user_id' => 1,
        'name' => $faker->text(20),
    ];
});

$factory->define(Field::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->text(10),
    ];
});

$factory->define(Tag::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->text(10),
    ];
});

$factory->define(Card::class, function(Faker\Generator $faker) {
    return [];
});

$factory->define(Category::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->text(15),
    ];
});