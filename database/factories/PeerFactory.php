<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Peer;
use Faker\Generator as Faker;

$factory->define(Peer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'url' => $faker->url,
        'token' => $faker->uuid,
    ];
});
