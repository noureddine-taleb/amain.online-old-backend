<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'bill_id' => $faker->unique()->numberBetween($min = 1, $max = 300) ,
    ];
});
