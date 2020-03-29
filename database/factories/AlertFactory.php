<?php
use App\Alert;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(Alert::class, function (Faker $faker) {
    return [
        'project_id' => $faker->randomDigit,
        'frequency' => $faker->randomDigit,
        'priority' =>  $faker->randomDigit,
    ];

});
