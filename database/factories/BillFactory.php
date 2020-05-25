<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bill;
use Faker\Generator as Faker;

$factory->define(Bill::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 100),
        'weight' => $faker->randomDigit,
        'project_id' =>  $faker->numberBetween($min = 1, $max = 5),
    ];
});
