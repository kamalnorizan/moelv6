<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'content' => $this->faker->sentence(rand(5,10)),
        'user_id' => $this->faker->numberBetween(1,200),
        'post_id' => $this->faker->numberBetween(1,400)
    ];
});
