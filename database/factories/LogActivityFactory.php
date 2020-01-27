<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use \Bpocallaghan\LogActivity\Models\LogActivity;

$factory->define(LogActivity::class, function (Faker $faker) {
    return [
        'name'        => $faker->name,
        'description' => $faker->sentence,
    ];
});
