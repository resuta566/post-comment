<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\PostComment;
use Faker\Generator as Faker;

$factory->define(PostComment::class, function (Faker $faker) {
    return [
        'post_id' => 1, 
        'comment_id'=> null, 
        'username'=> $faker->username, 
        'comment'=> $faker->sentence()
    ];
});
