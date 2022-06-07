<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'content' => $this->faker->paragraph(rand(5,10)),
        'user_id' => $this->faker->numberBetween(1,200)
    ];
});
