<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->firstNameMale.$faker->emoji,
        'phone' => $faker->phoneNumber,
        'dob' =>  $faker->dateTime(),
        'image' =>  $faker->unique()->imageUrl(),
        'password' =>  $faker->password(),
    ];
});
