<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'uuid' => $faker->uuid,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
