<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Text;
use Faker\Generator as Faker;

$factory->define(Text::class, function (Faker $faker) {
    return [
        'title' => $faker->words(4, true),
        'text' => $faker->text(),
    ];
});
