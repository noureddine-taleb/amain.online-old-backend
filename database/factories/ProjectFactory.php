<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'desc' => $faker->text,
        'fees' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 1.2, $max = 200.21),
    ];
});
